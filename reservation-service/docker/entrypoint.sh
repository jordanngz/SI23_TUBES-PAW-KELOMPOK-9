#!/bin/sh
set -e

APP_ROOT=/var/www

if [ -f "$APP_ROOT/artisan" ]; then

  # Pastikan direktori storage & bootstrap ada dan permission benar
  mkdir -p "$APP_ROOT/storage/logs" \
           "$APP_ROOT/storage/framework/cache" \
           "$APP_ROOT/storage/framework/sessions" \
           "$APP_ROOT/storage/framework/views" \
           "$APP_ROOT/bootstrap/cache"
  chown -R www-data:www-data "$APP_ROOT/storage" "$APP_ROOT/bootstrap/cache" "$APP_ROOT/public" 2>/dev/null || true

  # MySQL sudah healthy (dijamin docker-compose healthcheck), cukup tunggu 2 detik
  sleep 2
  echo "Database is ready."

  # Hapus bootstrap cache lama agar auto-discovery bersih
  rm -f "$APP_ROOT/bootstrap/cache/packages.php" "$APP_ROOT/bootstrap/cache/services.php"

  php artisan migrate --force 2>&1 || echo "Migrations skipped or completed."
  php artisan db:seed --force 2>&1 || echo "Seeding failed."
  php artisan config:clear >/dev/null 2>&1 || true
  php artisan cache:clear >/dev/null 2>&1 || true
fi

exec "$@"
