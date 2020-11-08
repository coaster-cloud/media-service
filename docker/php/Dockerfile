FROM php:7.4-fpm as base

################## PHP EXTENSIONS ##################
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install -j$(nproc) opcache

################## CLI TOOLS ##################
RUN apt-get -qqy install curl unzip

################## COMPOSER ##################
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/html

FROM base as development
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
COPY ./docker/php/development.ini $PHP_INI_DIR/conf.d/

FROM base as production
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY ./docker/php/production.ini $PHP_INI_DIR/conf.d/

COPY ./ ./

RUN composer install --no-dev --no-interaction
