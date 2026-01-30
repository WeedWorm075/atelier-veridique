# Multi-stage build: Node for building assets, then PHP for runtime
FROM node:18-alpine AS node

WORKDIR /var/www/html

# Copy package files
COPY package.json package-lock.json* ./
RUN npm ci --no-audit --prefer-offline

# Copy all files for building assets
COPY . .

# Build assets
RUN npm run build

# PHP stage
FROM php:8.2-apache

WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd \
    && a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files from current directory
COPY . .

# Copy built assets from node stage
COPY --from=node /var/www/html/public/build /var/www/html/public/build
COPY --from=node /var/www/html/node_modules /var/www/html/node_modules

# Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Set Apache DocumentRoot to Laravel's public directory
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Expose port
EXPOSE 8080

# Create entrypoint script
RUN echo '#!/bin/bash\n\
echo "Starting Laravel application..."\n\
\n\
# Generate key if not set\n\
if [ -z "$APP_KEY" ] || [ "$APP_KEY" == "base64:GuOWxHOIKgFjl9kynLi2gFcwmo6j0QEMC2LEoA7fJIY=" ]; then\n\
  php artisan key:generate --force\n\
  echo "Application key generated"\n\
fi\n\
\n\
# Run migrations if needed\n\
if [ "$RUN_MIGRATIONS" = "true" ]; then\n\
  php artisan migrate --force --no-interaction\n\
  echo "Migrations completed"\n\
fi\n\
\n\
# Cache configurations\n\
php artisan config:cache\n\
php artisan route:cache\n\
php artisan view:cache\n\
\n\
echo "Starting Apache..."\n\
exec apache2-foreground' > /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh

# Use entrypoint script
ENTRYPOINT ["entrypoint.sh"]