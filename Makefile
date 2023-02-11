init: docker-down-clear \
	api-clear \
	frontend-clear \
	docker-pull docker-build docker-up \
	api-init \
	frontend-init \
	frontend-ready
up: docker-up
down: docker-down
restart: down up

check: lint test analyze api-validate-schema
test: api-test
lint: api-lint
analyze: api-analyze
cs-fix: api-cs-fix
update-deps: frontend-yarn-upgrade api-composer-update restart

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build --pull

api-clear:
	docker run --rm -v ${PWD}/api:/app -w /app alpine sh -c 'rm -rf var/cache/* var/log/*'

api-init: api-composer-install api-permissions api-wait-db api-migrations

api-permissions:
	docker run --rm -v ${PWD}/api:/app -w /app alpine chmod 777 var/cache var/log

api-composer-install:
	docker-compose run --rm api-php-cli composer install

api-wait-db:
	docker-compose run --rm api-php-cli wait-for-it api-postgres:5432 -t 30

api-composer-update:
	docker-compose run --rm api-php-cli composer update

api-migrations:
	docker-compose run --rm api-php-cli composer app migrations:migrate -- --no-interaction

api-validate-schema:
	docker-compose run --rm api-php-cli composer app orm:validate-schema

api-test:
	docker-compose run --rm api-php-cli composer test

api-lint:
	docker-compose run --rm api-php-cli composer lint
	docker-compose run --rm api-php-cli composer php-cs-fixer fix -- --dry-run --diff

api-analyze:
	docker-compose run --rm api-php-cli composer psalm

api-cs-fix:
	docker-compose run --rm api-php-cli composer php-cs-fixer fix

frontend-clear:
	docker run --rm -v ${PWD}/frontend:/app -w /app alpine sh -c 'rm -rf .ready build'

frontend-init: frontend-yarn-install

frontend-yarn-install:
	docker-compose run --rm frontend-node-cli yarn install

frontend-yarn-upgrade:
	docker-compose run --rm frontend-node-cli yarn upgrade

frontend-ready:
	docker run --rm -v ${PWD}/frontend:/app -w /app alpine touch .ready
