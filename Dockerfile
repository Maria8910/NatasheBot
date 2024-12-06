FROM php:8.1-fpm-bullseye

RUN apt-get update && apt-get install -y curl --no-install-recommends && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
RUN php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm /tmp/composer-setup.php

RUN apt-get update && \
    apt-get install -y --no-install-recommends libpcre3-dev libicu-dev libzip-dev libonig-dev && \
    docker-php-ext-install pdo pdo_mysql mbstring && \
    rm -rf /var/lib/apt/lists/*

ENV PATH="${PATH}:/usr/local/bin" # Добавление пути к Composer в PATH

COPY . /var/www/html

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html
RUN groupadd -g 82 www-data
RUN usermod -u 82 www-data
RUN composer install --no-interaction --optimize-autoloader --no-dev

EXPOSE 80
CMD ["php-fpm"]