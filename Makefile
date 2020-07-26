.SILENT:

include .env

dc=docker-compose -p ${APP_NAME}

web=web
php=php
db=db
cache=cache
#db_testing = db_testing
#node = node

build:
	sudo mkdir -p vendor
	sudo chmod 777 -R vendor/
	sudo chmod 777 -R docker/storage
	$(dc) up --build --force-recreate -d
	sudo chmod 777 -R vendor/
	sudo chmod 777 -R docker/storage
	sudo chmod 777 -R storage
	echo "http://${DOCKER_BRIDGE}"

start:
	$(dc) start

stop:
	$(dc) stop

down:
	$(dc) down

logs:
	$(dc) logs

logs_f:
	$(dc) logs -f

ps:
	$(dc) ps

php_bash:
	$(dc) exec $(php) bash

web_bash:
	$(dc) exec $(web) bash

db_bash:
	$(dc) exec $(db) bash

db_testing_bash:
	$(dc) exec $(db_testing) bash

restart:
	$(dc) restart

clear_web_log:
	> docker/storage/logs/web.errors.log && > docker/storage/logs/web.access.log

clear_cache:
	php artisan clear-compiled && php artisan cache:clear && php artisan config:clear && php artisan debugbar:clear && php artisan passport:purge && php artisan view:clear && php artisan websockets:clean
