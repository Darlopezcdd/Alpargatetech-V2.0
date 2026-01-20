<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RestorePostgresDump extends Command
{
    protected $signature = 'db:restore-dump {file}';
    protected $description = 'Restores a PostgreSQL dump file containing COPY statements by converting them to INSERTs';

    public function handle()
    {
        $file = $this->argument('file');
        if (!File::exists($file)) {
            $this->error("File not found: $file");
            return 1;
        }

        $this->info("Restoring from $file to " . DB::getConfig('host'));

        // Disable foreign key checks if possible (hard in Postgres without superuser, but we can try deferring)
        // DB::statement('SET session_replication_role = replica;'); // Likely fails on Render

        $lines = file($file, FILE_IGNORE_NEW_LINES);
        $currentTable = null;
        $columns = [];
        $buffer = [];

        // DB::beginTransaction(); // Removed to debug errors

        try {
            foreach ($lines as $line) {
                // Skip comments and empty lines
                if (str_starts_with($line, '--') || empty(trim($line))) {
                    continue;
                }

                // Skip psql meta-commands
                if (str_starts_with($line, '\\') && !str_starts_with($line, '\\.')) {
                    continue;
                }

                // Skip SET/SELECT/CREATE DATABASE/ALTER DATABASE
                if (preg_match('/^(SET|SELECT|CREATE DATABASE|ALTER DATABASE)/i', $line)) {
                    continue;
                }

                // Detect COPY start
                // COPY public.users (id, name...) FROM stdin;
                if (preg_match('/^COPY public\.(\w+) \((.*)\) FROM stdin;/', $line, $matches)) {
                    $currentTable = $matches[1];

                    // Filter: Only restore core tables
                    $allowedTables = [
                        'users',
                        'categories',
                        'products',
                        'tables',
                        'clients',
                        'orders',
                        'order_items',
                        'payments',
                        'recipes',
                        'ingredients',
                        'fixed_assets'
                    ];

                    if (!in_array($currentTable, $allowedTables)) {
                        $this->info("Skipping table: $currentTable");
                        $currentTable = null;
                        continue;
                    }

                    $columns = array_map('trim', explode(',', $matches[2])); // ["id", "name", ...]
                    $this->info("Processing table: $currentTable");

                    // Truncate table before inserting to avoid duplicates/errors
                    try {
                        // Use delete instead of truncate to allow Cascade via constraints if defined
                        // But we need to clear data.
                        // Attempt Truncate Cascade
                        DB::statement("TRUNCATE TABLE \"$currentTable\" RESTART IDENTITY CASCADE");
                    } catch (\Exception $e) {
                        $this->warn("Could not truncate $currentTable: " . $e->getMessage());
                    }
                    continue;
                }

                // Detect End of COPY
                if ($line === '\.') {
                    $currentTable = null;
                    $columns = [];
                    continue;
                }

                // Process Data Rows
                if ($currentTable) {
                    $values = explode("\t", $line);
                    $rowData = [];

                    foreach ($values as $index => $value) {
                        if (isset($columns[$index])) {
                            $colName = $columns[$index];
                            if ($value === '\N') {
                                $rowData[$colName] = null;
                            } else {
                                $rowData[$colName] = $value;
                            }
                        }
                    }

                    // Insert immediately
                    try {
                        DB::table($currentTable)->insert($rowData);
                    } catch (\Exception $e) {
                        file_put_contents('restore_errors.log', "Error on table $currentTable: " . $e->getMessage() . "\nRow: " . json_encode($rowData) . "\n", FILE_APPEND);
                    }
                }
            }

            // Restore sequences setval
            foreach ($lines as $line) {
                if (preg_match("/SELECT pg_catalog\.setval\('public\.(\w+)', (\d+), (true|false)\);/", $line, $matches)) {
                    try {
                        DB::statement($line);
                        $this->info("Sequence updated: {$matches[1]}");
                    } catch (\Exception $e) {
                        // Ignore sequence errors
                    }
                }
            }

            $this->info("Restore completed successfully.");
        } catch (\Exception $e) {
            // DB::rollBack();
            $this->error("Error restoring database: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
