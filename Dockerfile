FROM php:8.1-fpm-bullseye
COPY index.php /var/www/html/
WORKDIR /var/www/html
EXPOSE 80
CMD ["php-fpm"]