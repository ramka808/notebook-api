#!/bin/sh

cp .env.example .env
composer install
php artisan key:generate --force
php artisan migrate --force
php-fpm
