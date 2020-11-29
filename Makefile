COMPOSE=docker-compose -f ./docker-configs/docker-compose.yml

project: laravel-dep node-dep build-front up test

laravel-dep:
	cp project/.env.example project/.env
	$(COMPOSE) run --rm composer install

node-dep:
	$(COMPOSE) run --rm npm install

up:
	$(COMPOSE) up -d $(c)

test:
	$(COMPOSE) run --rm tests

develop-front:
	$(COMPOSE) run --rm npm run watch

build-front:
	$(COMPOSE) run --rm npm run prod

down:
	$(COMPOSE) down