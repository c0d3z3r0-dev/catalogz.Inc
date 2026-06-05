FROM php:8.3-fpm-alpine

RUN apk add --no-cache nginx sqlite-dev \
    && docker-php-ext-install pdo pdo_sqlite

WORKDIR /var/www/html
COPY . .
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN chown -R www-data:www-data storage bootstrap/cache database

COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80
CMD ["/start.sh"]
