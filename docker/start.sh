#!/bin/sh
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi
php artisan migrate --force
php artisan storage:link
php-fpm &
nginx -g "daemon off;"
