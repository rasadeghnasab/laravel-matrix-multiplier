COMPOSE=docker-compose -f ./docker-configs/docker-compose.yml

TEST_FILTER=
ifdef filter
	TEST_FILTER = --filter $(filter)
endif

project: laravel-dep node-dep front-production up test

laravel-dep:
	cp project/.env.example project/.env
	$(COMPOSE) run --rm composer install

node-dep:
	$(COMPOSE) run --rm npm install

up:
	$(COMPOSE) up -d $(c)

test:
	$(COMPOSE) run --rm tests $(TEST_FILTER)

front-dev:
	$(COMPOSE) run --rm npm run watch

front-production:
	$(COMPOSE) run --rm npm run prod

down:
	$(COMPOSE) down