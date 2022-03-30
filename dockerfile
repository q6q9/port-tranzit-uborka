FROM php:7.2-fpm-alpine

RUN curl -s https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

RUN docker-php-ext-install pdo pdo_mysql

