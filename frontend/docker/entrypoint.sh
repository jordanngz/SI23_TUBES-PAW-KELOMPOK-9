#!/bin/sh
set -e

APP_ROOT=/var/www

if [ -f "$APP_ROOT/artisan" ]; then
  mkdir -p "$APP_ROOT/storage/logs" \
           "$APP_ROOT/storage/framework/cache" \
           "$APP_ROOT/storage/framework/sessions" \
           "$APP_ROOT/storage/framework/views" \
           "$APP_ROOT/bootstrap/cache"
  chown -R www-data:www-data "$APP_ROOT/storage" "$APP_ROOT/bootstrap/cache" "$APP_ROOT/public" 2>/dev/null || true

  rm -f "$APP_ROOT/bootstrap/cache/packages.php" "$APP_ROOT/bootstrap/cache/services.php"

  php artisan config:clear >/dev/null 2>&1 || true
  php artisan cache:clear >/dev/null 2>&1 || true
fi

exec "$@"
