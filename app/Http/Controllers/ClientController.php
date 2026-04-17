<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::withCount('orders')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'identification' => 'nullable|string|max:20',
            'email'          => 'nullable|email|max:255|unique:clients,email',
            'phone'          => 'nullable|string|max:20',
        ]);

        $client = Client::create($data);

        AuditLogger::log('Clientes: Crear', "Cliente '{$client->name}' registrado", auth()->id());

        return redirect()->route('admin.clients.index')
            ->with('success', "Cliente '{$client->name}' registrado.");
    }

    public function edit(Client $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client): RedirectResponse
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'identification' => 'nullable|string|max:20',
            'email'          => "nullable|email|max:255|unique:clients,email,{$client->id}",
            'phone'          => 'nullable|string|max:20',
        ]);

        $client->update($data);

        AuditLogger::log('Clientes: Actualizar', "Cliente '{$client->name}' actualizado", auth()->id());

        return redirect()->route('admin.clients.index')
            ->with('success', "Cliente '{$client->name}' actualizado.");
    }

    public function destroy(Client $client): RedirectResponse
    {
        $name = $client->name;
        $client->delete();

        AuditLogger::log('Clientes: Eliminar', "Cliente '{$name}' eliminado", auth()->id());

        return redirect()->route('admin.clients.index')
            ->with('success', "Cliente '{$name}' eliminado.");
    }
}
