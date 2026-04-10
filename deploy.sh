#!/bin/bash
# ─────────────────────────────────────────────────────────────
#  NKB Foundation — Deployment Script
#  Run this on the server after every: git pull origin main
#
#  Usage:  bash deploy.sh
# ─────────────────────────────────────────────────────────────

echo "─────────────────────────────────────────"
echo "  NKB Foundation — Deploy"
echo "─────────────────────────────────────────"

# 1. Install/update PHP dependencies (vendor is gitignored)
echo "▶ Installing composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# 2. Clear all Laravel caches
echo "▶ Clearing caches..."
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan event:clear

# 2. Run any new migrations
echo "▶ Running migrations..."
php artisan migrate --force

# 3. Ensure storage symlink exists
echo "▶ Storage link..."
php artisan storage:link --force 2>/dev/null || true

# 4. Rebuild config/route cache for performance
echo "▶ Caching for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "─────────────────────────────────────────"
echo "  ✓ Deployment complete!"
echo "─────────────────────────────────────────"
