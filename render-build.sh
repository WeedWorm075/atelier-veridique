#!/bin/bash
echo "Starting Render build process..."

# Install dependencies
composer install --no-interaction --optimize-autoloader --no-dev

# Generate application key if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" == "base64:GuOWxHOIKgFjl9kynLi2gFcwmo6j0QEMC2LEoA7fJIY=" ]; then
  php artisan key:generate --force
fi

# Create necessary directories
mkdir -p storage/framework/{sessions,views,cache}
chmod -R 775 storage bootstrap/cache

# Create storage link
php artisan storage:link

# Run database migrations
php artisan migrate --force --no-interaction

# Cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Build process completed!"