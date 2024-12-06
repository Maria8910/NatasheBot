FROM php:8.1-fpm

# Установка расширений PHP (добавьте необходимые вам)
RUN docker-php-ext-install pdo pdo_mysql mbstring

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Копирование файлов проекта
COPY . /var/www/html

# Установка зависимостей
WORKDIR /var/www/html
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Изменение владельца файлов (для безопасности)
RUN chown -R www-data:www-data /var/www/html

# Настройка веб-сервера
EXPOSE 80
CMD ["php-fpm"]

