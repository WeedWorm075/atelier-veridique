#!/bin/bash

echo "Starting Laravel application..."

# Set proper permissions
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

# Generate key if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" == "base64:GuOWxHOIKgFjl9kynLi2gFcwmo6j0QEMC2LEoA7fJIY=" ]; then
  php artisan key:generate --force
  echo "Application key generated"
fi

# Run migrations if needed
if [ "$RUN_MIGRATIONS" = "true" ]; then
  php artisan migrate --force --no-interaction
  echo "Migrations completed"
fi

# Cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting Apache..."
exec apache2-foreground