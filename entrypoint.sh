#!/bin/sh

cp .env.example .env
composer install
php artisan key:generate --force
php artisan migrate --force
php artisan migrate --database=testing --force
php-fpm
