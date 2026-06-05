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

# Start PHP-FPM in the background (listen on TCP port 9000)
php-fpm -D -R -y /usr/local/etc/php-fpm.conf -g /var/run/php-fpm.pid
# Wait a moment to ensure it's up
sleep 2

# Start Nginx in the foreground
nginx -g "daemon off;"
