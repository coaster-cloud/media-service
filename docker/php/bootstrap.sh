#!/bin/bash

ENVIRONMENT=$1
PHP_INI_DIR=$2

if [ $ENVIRONMENT == 'production' ]
then
  mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
  cp ./docker/php/development.ini $PHP_INI_DIR/conf.d/

  composer install --no-dev --no-interaction --optimize-autoloader
else
  mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
  cp ./docker/php/development.ini $PHP_INI_DIR/conf.d/
fi
