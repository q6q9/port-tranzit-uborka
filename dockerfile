FROM php:8.0-fpm-alpine

RUN curl -s https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

RUN docker-php-ext-install pdo pdo_mysql

RUN apk add --no-cache \
        libjpeg-turbo-dev \
        libpng-dev \
        libwebp-dev \
        freetype-dev

RUN docker-php-ext-install gd


RUN  apk add jpeg-dev libpng-dev \
        && docker-php-ext-configure gd --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd

