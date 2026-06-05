#!/bin/sh

# Ensure .env exists
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Set APP_URL and ASSET_URL to Render's public HTTPS URL
if [ -n "$RENDER_EXTERNAL_URL" ]; then
    sed -i "s|^APP_URL=.*|APP_URL=${RENDER_EXTERNAL_URL}|" .env
    sed -i "s|^ASSET_URL=.*|ASSET_URL=${RENDER_EXTERNAL_URL}|" .env
fi

# Force HTTPS scheme in Laravel (trust proxies already set in middleware)
echo "FORCE_HTTPS=true" >> .env

# Force session driver to file
sed -i 's/^SESSION_DRIVER=.*/SESSION_DRIVER=file/' .env

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Make database writable
chmod -R 775 database
touch database/database.sqlite
chmod 664 database/database.sqlite

# Make storage writable
mkdir -p storage/framework/views storage/framework/cache storage/framework/sessions
chmod -R 775 storage bootstrap/cache

# Clear any stale config (important so that above .env changes take effect)
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Publish error views
php artisan vendor:publish --tag=laravel-errors --force 2>/dev/null || true

# Run migrations and seed
php artisan migrate --force
php artisan db:seed --class=DemoSeeder --force

# Storage link
php artisan storage:link

# Start PHP-FPM (TCP port 9000)
php-fpm -D -R -y /usr/local/etc/php-fpm.conf -g /var/run/php-fpm.pid
sleep 2

# Start Nginx
nginx -g "daemon off;"
