FROM php:8.1-fpm-bullseye

RUN apt-get update && \
    apt-get install -y curl libpcre3-dev libicu-dev libzip-dev libonig-dev && \
    rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php \
    && php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm /tmp/composer-setup.php \
    && docker-php-ext-install pdo pdo_mysql mbstring

ENV PATH="${PATH}:/usr/local/bin"

COPY composer.json composer.lock ./

# Устанавливаем права на директорию ДО COPY всего проекта
RUN groupadd -g 82 www-data
RUN useradd -u 82 -g www-data -ms /bin/bash www-data
RUN mkdir /var/www/html
RUN chown -R www-data:www-data /var/www/html
USER www-data


COPY . /var/www/html
WORKDIR /var/www/html

RUN composer install --no-interaction --optimize-autoloader --no-dev --no-progress --no-suggest

EXPOSE 80
CMD ["php-fpm"]

