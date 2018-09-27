#!/usr/bin/env bash

if [ "$1" = "build" ]; then
    docker-compose build
fi

if [ "$1" = "up" ]; then
    docker-compose up -d
fi

if [ "$1" = "down" ]; then
    docker-compose down
fi

if [ "$1" = "restart" ]; then
    docker-compose restart
fi

if [ "$1" = "test" ]; then
    docker-compose run php-cli vendor/bin/phpunit
fi

if [ "$1" = "artisan" ]; then
    docker-compose run php-cli php artisan $2
fi

if [ "$1" = "tinker" ]; then
    docker-compose run php-cli php artisan tinker # Interactive run laravel code
fi

if [ "$1" = "composer" ]; then
    docker-compose run composer $2
fi

if [ "$1" = "dump-autoload" ]; then
    docker-compose run composer dump-autoload -o
fi

if [ "$1" = "yarn" ]; then
    docker-compose run node yarn $2
fi

if [ "$1" = "yarn-watch" ]; then
#    docker-compose run node npm run watch
    docker-compose run node yarn run watch-poll
fi

# artisan migrate --env=testing подтягивает настройки из .env.testing
# ./run.sh artisan "migrate --seed --env=testing"
# composer dump-autoload -o
# ./run.sh artisan storage:link, php artisan storage:link

