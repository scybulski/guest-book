FROM php:8.3-fpm

RUN apt-get update
RUN apt-get upgrade
RUN apt-get install -y git zip unzip libzip-dev
RUN curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

RUN docker-php-ext-install mysqli pdo pdo_mysql zip
