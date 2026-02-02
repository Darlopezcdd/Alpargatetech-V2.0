#!/bin/sh

# Fail on error
set -e

# Caching
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations (Optional - be careful with this in production if you have zero-downtime requirements, but fine for simple setup)
# echo "Running migrations..."
# php artisan migrate --force

# Execute the command passed to the container, or default to starting Nginx/PHP
if [ $# -gt 0 ]; then
    exec "$@"
else
    # Start PHP-FPM in the background
    php-fpm -D
    # Start Nginx in the foreground
    nginx
fi
