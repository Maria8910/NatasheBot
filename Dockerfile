FROM php:8.1-fpm-bullseye

COPY . /var/www/html

WORKDIR /var/www/html

EXPOSE 10000
CMD ["php-fpm"]
