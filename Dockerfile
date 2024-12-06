FROM php:8.1-fpm-bullseye

RUN apt-get update && \
    apt-get install -y --no-install-recommends libpcre3-dev libicu-dev libzip-dev libonig-dev && \
    docker-php-ext-install pdo pdo_mysql mbstring && \
    rm -rf /var/lib/apt/lists/*

COPY . /var/www/html

WORKDIR /var/www/html

RUN composer install --no-interaction --optimize-autoloader --no-dev

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
CMD ["php-fpm"]