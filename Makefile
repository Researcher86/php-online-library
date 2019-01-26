DC := docker-compose
COMPOSER := docker-compose run composer
ARTISAN := docker-compose run php-cli php artisan
NODE := docker-compose run node
PHING := docker-compose run php-cli vendor/bin/phing
PHP := docker-compose run php-cli

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

composer:
	$(COMPOSER) sh

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
	$(ARTISAN) refresh --seed

artisan:
	$(ARTISAN) $(CMD)