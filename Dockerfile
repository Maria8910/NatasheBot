FROM php:8.1-fpm-bullseye

COPY . /var/www/html

WORKDIR /var/www/html

EXPOSE 80
CMD ["php-fpm"]
