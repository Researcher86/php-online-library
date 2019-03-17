DC := docker-compose
COMPOSER := docker-compose run php-cli composer
ARTISAN := docker-compose run php-cli php artisan
NODE := docker-compose run node
PHING := docker-compose run php-cli vendor/bin/phing
PHP := docker-compose run php-cli
NGINX := docker-compose exec nginx

list:
	grep '^[^#[:space:]].*:' Makefile

up:
	$(DC) up -d

build:
	$(DC) build

remove-all:
	$(DC) down --rmi local -v --remove-orphans

down:
	$(DC) down -v --remove-orphans

start:
	$(DC) start

stop:
	$(DC) stop

restart:
	$(DC) restart

# make logs c=php-cli
logs:
	$(DC) logs $(CMD)

test:
	$(PHP) vendor/bin/phpunit

composer-install:
	$(COMPOSER) install
	$(COMPOSER) dump-autoload -o

composer-update:
	$(COMPOSER) update
	$(COMPOSER) dump-autoload -o

dump-autoload:
	$(COMPOSER) dump-autoload -o

phing:
	$(PHING)

npm-watch:
	$(NODE) npm run watch-poll

npm:
	$(NODE) sh

npm-dev:
	$(NODE) npm run dev

npm-prod:
	$(NODE) npm run prod

npm-install:
	$(NODE) npm install

npm-update:
	$(NODE) npm update

tinker:
	# Interactive run laravel code
	$(ARTISAN) tinker

db-refresh:
	$(ARTISAN) migrate:refresh -n --force

db-refresh-seed:
	$(ARTISAN) migrate:refresh --seed -n --force

nginx:
	$(NGINX) bash

nginx-reload:
	$(NGINX) nginx -s reload

php-cli:
#      make:auth
#      make:channel
#      make:command
#      make:controller
#      make:event
#      make:exception
#      make:factory
#      make:job
#      make:listener
#      make:mail
#      make:middleware
#      make:migration
#      make:model
#      make:notification
#      make:observer
#      make:policy
#      make:provider
#      make:request
#      make:resource
#      make:rule
#      make:seeder
#      make:test
#   ./artisan make:event UserLoginEvent
#	./artisan make:listener UserEventSubscriber
#   ./artisan command:consumer
	$(PHP) bash
