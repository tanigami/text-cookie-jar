FROM php:7-fpm-alpine

RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/bin/ --filename=composer

RUN apk update \
    && apk add  --no-cache g++ make autoconf

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

RUN mkdir /code
WORKDIR /code