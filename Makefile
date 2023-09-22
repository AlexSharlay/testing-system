init: docker-down docker-up composer-install migrations fixtures

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

composer-install:
	docker-compose run --rm testing-system-php-cli composer install

migrations:
	docker-compose run --rm testing-system-php-cli php bin/console doctrine:migrations:migrate --no-interaction

fixtures:
	docker-compose run --rm testing-system-php-cli php bin/console doctrine:fixtures:load --no-interaction
