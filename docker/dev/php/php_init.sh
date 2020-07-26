#!/usr/bin/env bash

chmod +x artisan

composer install --no-progress --prefer-dist --working-dir=/app

#php artisan key:generate
#php artisan migrate --no-interaction
#php artisan db:seed

chmod 0744 /etc/cron.d/settings.cron
crontab /etc/cron.d/settings.cron
/etc/init.d/cron start
service supervisor start
supervisorctl reread
supervisorctl update
supervisorctl status

exec php-fpm --nodaemonize