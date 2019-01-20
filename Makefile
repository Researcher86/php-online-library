## If the first argument is "run"...
#ifeq (doctrine,$(firstword $(MAKECMDGOALS)))
#  # use the rest as arguments for "run"
#  RUN_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
#  # ...and turn them into do-nothing targets
#  $(eval $(RUN_ARGS):;@true)
#endif

list:
	grep '^[^#[:space:]].*:' Makefile

up:
	docker-compose up -d

build:
	docker-compose build

remove-all:
	docker-compose down --rmi local -v --remove-orphans

down:
	docker-compose down -v --remove-orphans

start:
	docker-compose start

stop:
	docker-compose stop

restart:
	docker-compose restart

# make logs c=php-cli
logs:
	docker-compose logs $(CMD)

test:
	docker-compose run php-cli vendor/bin/phpunit

composer:
	docker-compose run composer $(CMD)

dump-autoload:
	docker-compose run composer dump-autoload -o

phing:
	docker-compose run php-cli vendor/bin/phing

npm-watch:
	docker-compose run node npm run watch-poll

tinker:
	# Interactive run laravel code
	docker-compose run php-cli php artisan tinker

db-refresh:
	docker-compose run php-cli php artisan refresh --seed

artisan:
	docker-compose run php-cli php artisan $(CMD)