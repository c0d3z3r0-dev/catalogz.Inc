#!/bin/sh

# Ensure .env exists
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run migrations (safe for SQLite)
php artisan migrate --force

# Create storage link if missing
php artisan storage:link

# Start PHP-FPM and Nginx
php-fpm &
nginx -g "daemon off;"
