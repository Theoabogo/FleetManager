#!/bin/sh
set -e

chmod -R 777 var/

# Capture all Railway env vars into .env.local.php so Symfony finds every variable it needs
php -r '
$vars = getenv();
if (empty($vars["APP_ENV"])) $vars["APP_ENV"] = "prod";
if (empty($vars["DEFAULT_URI"])) $vars["DEFAULT_URI"] = "http://localhost";
file_put_contents(".env.local.php", "<?php return " . var_export($vars, true) . ";");
'

# Clear stale Symfony cache
rm -rf var/cache/prod var/cache/dev

php-fpm -D

exec nginx -g "daemon off;"
