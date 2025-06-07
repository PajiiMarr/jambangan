#!/usr/bin/env bash
echo "Installing composer dependencies..."
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

echo "Installing npm dependencies..."
npm ci

echo "Building assets..."
npm run build

# Clear any previxous caches
echo "Clearing caches..."
php artisan optimize:clear

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force

# Fix permissions
echo "Setting permissions..."
chown -R www-data:www-data /var/www/html/storage
chmod -R 775 /var/www/html/storage

# Create symbolic link for storage if needed
php artisan storage:link