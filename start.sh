#!/bin/sh
set -e

chmod -R 777 var/

php-fpm -D

exec nginx -g "daemon off;"
