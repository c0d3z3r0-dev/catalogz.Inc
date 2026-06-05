#!/bin/sh

# Ensure .env exists
if [ ! -f .env ]; then
    cp .env.example .env
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

# Run migrations (safe for SQLite)
php artisan migrate --force

# Create storage link if missing
php artisan storage:link

# Start PHP-FPM (TCP port 9000)
php-fpm -D -R -y /usr/local/etc/php-fpm.conf -g /var/run/php-fpm.pid
sleep 2

# Start Nginx in foreground
nginx -g "daemon off;"
