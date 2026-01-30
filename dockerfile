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
    nodejs \
    npm \
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

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Copy Apache configuration
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Expose port
EXPOSE 8080

# Copy entrypoint script
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

# Use entrypoint script
ENTRYPOINT ["entrypoint.sh"]