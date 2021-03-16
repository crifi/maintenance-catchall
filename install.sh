#!/bin/sh
if [ ! -f .env.local ]; then
    echo "APP_ENV=prod" > .env.local
    echo "APP_SECRET=$(openssl rand -hex 32)" >> .env.local
fi
if [ ! -f templates/my.html.twig ]; then
    echo "{% include 'base.html.twig' %}" > templates/my.html.twig
fi
mkdir -p var/maintenance
composer install --no-dev --optimize-autoloader
APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear
chown -R www-data.www-data var/cache var/log