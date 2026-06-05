#!/bin/sh

# Ensure .env exists
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Set APP_URL to Render's public HTTPS URL (auto-provided)
if [ -n "$RENDER_EXTERNAL_URL" ]; then
    sed -i "s|^APP_URL=.*|APP_URL=${RENDER_EXTERNAL_URL}|" .env
fi

# Force session driver to file (avoids SQLite writes for sessions)
sed -i 's/^SESSION_DRIVER=.*/SESSION_DRIVER=file/' .env

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Make database directory writable
chmod -R 775 database
touch database/database.sqlite
chmod 664 database/database.sqlite

# Make storage directories writable
mkdir -p storage/framework/views storage/framework/cache storage/framework/sessions
chmod -R 775 storage bootstrap/cache

# Clear any stale cached config/routes/views
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Publish error views (so friendly 500 page appears)
php artisan vendor:publish --tag=laravel-errors --force 2>/dev/null || true

# Run migrations (safe for SQLite)
php artisan migrate --force

# Seed the demo client if not already present
php artisan db:seed --class=DemoSeeder --force

# Create storage link if missing
php artisan storage:link

# Start PHP-FPM (TCP port 9000)
php-fpm -D -R -y /usr/local/etc/php-fpm.conf -g /var/run/php-fpm.pid
sleep 2

# Start Nginx in foreground
nginx -g "daemon off;"
