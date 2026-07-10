FROM php:8.2-fpm-alpine

RUN apk add --no-cache nginx git unzip bash icu-dev \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-install pdo pdo_mysql intl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY app/ .

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV APP_ENV=prod
ENV APP_SECRET=placeholder

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts \
    && composer dump-autoload --optimize --no-dev

COPY docker/nginx/nginx.conf /etc/nginx/http.d/default.conf
RUN sed -i 's/fastcgi_pass php:9000/fastcgi_pass 127.0.0.1:9000/' /etc/nginx/http.d/default.conf

RUN mkdir -p var/cache var/log && chmod -R 777 var/

RUN echo "clear_env = no" >> /usr/local/etc/php-fpm.d/www.conf

COPY start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80

CMD ["/start.sh"]
