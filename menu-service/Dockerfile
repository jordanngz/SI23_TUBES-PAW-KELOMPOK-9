
FROM php:8.2-cli AS base
WORKDIR /var/www
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

FROM base AS vendor
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts \
    && rm -rf /root/.composer/cache

FROM base AS final
WORKDIR /var/www
COPY --from=vendor /var/www/vendor /var/www/vendor
COPY --chown=www-data:www-data . /var/www
RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/app/public bootstrap/cache public/uploads \
    && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/public/uploads \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache /var/www/public/uploads \
    && php artisan key:generate --ansi >/dev/null 2>&1 || true \
    && php artisan storage:link >/dev/null 2>&1 || true

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 8000
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]