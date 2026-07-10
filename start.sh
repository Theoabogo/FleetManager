#!/bin/sh
set -e

chmod -R 777 var/

# Generate .env.local.php from Railway env vars so Symfony always gets correct values
php -r '
$vars = [];
foreach (["DATABASE_URL","APP_ENV","APP_SECRET","MAILER_DSN","MESSENGER_TRANSPORT_DSN","APP_SHARE_DIR"] as $k) {
    $v = getenv($k);
    if ($v !== false && $v !== "") $vars[$k] = $v;
}
if (!isset($vars["APP_ENV"])) $vars["APP_ENV"] = "prod";
file_put_contents(".env.local.php", "<?php return " . var_export($vars, true) . ";");
'

# Clear stale Symfony cache
rm -rf var/cache/prod var/cache/dev

php-fpm -D

exec nginx -g "daemon off;"
