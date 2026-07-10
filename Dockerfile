FROM php:8.2-fpm-alpine

RUN apk add --no-cache nginx mysql-dev git unzip bash \
    && docker-php-ext-install pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY app/ .

RUN composer install --no-dev --optimize-autoloader --no-interaction

COPY docker/nginx/nginx.conf /etc/nginx/http.d/default.conf
RUN sed -i 's/fastcgi_pass php:9000/fastcgi_pass 127.0.0.1:9000/' /etc/nginx/http.d/default.conf

RUN mkdir -p var/cache var/log && chmod -R 777 var/

COPY start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80

CMD ["/start.sh"]
