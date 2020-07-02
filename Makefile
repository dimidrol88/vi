up: docker-up
down: docker-down
restart: docker-down docker-up
init: docker-clear docker-pull docker-build docker-up app-init

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:   
	docker-compose build

app-init: app-composer-install app-migrations app-fixtures

app-composer-install:
	docker-compose run --rm php-cli composer install

app-migrations:
	docker-compose run --rm php-cli php bin/console doctrine:migrations:migrate --no-interaction

app-fixtures:
	docker-compose run --rm php-cli php bin/console doctrine:fixtures:load --no-interaction
