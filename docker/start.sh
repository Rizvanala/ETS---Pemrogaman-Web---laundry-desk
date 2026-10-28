#!/bin/sh
set -e

PORT="${PORT:-10000}"
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
rm -f database/database.sqlite
touch database/database.sqlite
chown -R www-data:www-data storage bootstrap/cache database

php artisan migrate:fresh --seed --force
chown -R www-data:www-data storage bootstrap/cache database

exec apache2-foreground
