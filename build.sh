#!/bin/bash
# Deployment script

git pull

cd app

composer install

php artisan migrate

sudo supervisorctl stop all

sudo supervisorctl restart all

echo 'Done'