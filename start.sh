# 1. Update your start.sh to ensure proper asset building:
#!/usr/bin/env bash
echo "Installing composer dependencies..."
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

echo "Installing npm dependencies..."
npm ci --omit=dev

echo "Building assets..."
npm run build  # or "npm run prod" if you have that script

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force