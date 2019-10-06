#!/usr/bin/env bash

set -e
echo Stopping services
docker-compose down
echo Starting services...
docker-compose up -d --force-recreate

# Installing composer dependencies
echo Installing dependencies...
docker-compose exec app composer install

# Running test cases
echo Unit testing...
docker-compose exec app vendor/bin/phpunit

# bash
docker-compose exec app bash