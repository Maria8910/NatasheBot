FROM php:8.1-apache

# Установка необходимых расширений PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring

# Копирование файлов приложения
COPY index.php /var/www/html/

# Настройка Apache для обработки POST запросов
RUN a2enmod rewrite
RUN sed -i 's/;AddType application/x-httpd-php .php/AddType application/x-httpd-php .php/' /etc/apache2/mods-available/php8.1.conf
COPY apache2.conf /etc/apache2/sites-available/

# Включение конфигурационного файла Apache
RUN a2ensite 000-default
RUN systemctl restart apache2