#!/bin/sh
set -e

chmod -R 777 var/

# Inject Railway environment variables explicitly into PHP-FPM pool config
{
  echo ""
  echo "[www]"
  echo "env[DATABASE_URL] = ${DATABASE_URL}"
  echo "env[APP_ENV] = ${APP_ENV:-prod}"
  echo "env[APP_SECRET] = ${APP_SECRET}"
  echo "env[MAILER_DSN] = ${MAILER_DSN:-null://null}"
  echo "env[MESSENGER_TRANSPORT_DSN] = ${MESSENGER_TRANSPORT_DSN:-doctrine://default?auto_setup=0}"
  echo "env[APP_SHARE_DIR] = ${APP_SHARE_DIR:-var/share}"
} >> /usr/local/etc/php-fpm.d/www.conf

# Clear stale Symfony cache so config is always rebuilt with current env vars
rm -rf var/cache/prod var/cache/dev

php-fpm -D

exec nginx -g "daemon off;"
