FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    bash \
    git \
    curl \
    icu-dev \
    oniguruma-dev \
    libzip-dev \
    zip \
    unzip \
    mysql-client

RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    zip \
    intl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www