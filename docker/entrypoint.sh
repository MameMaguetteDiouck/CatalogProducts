#!/bin/sh
set -e

# Copy .env if not exists
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Install composer dependencies if vendor is missing
if [ ! -d vendor ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction --prefer-dist
fi

# Generate application key if not set
if ! grep -q "APP_KEY=base64:" .env; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Install npm dependencies if node_modules is missing
if [ ! -d node_modules ]; then
    echo "Installing NPM dependencies..."
    npm install
fi

exec "$@"
