#!/bin/bash

ENVIRONMENT=$1
PHP_INI_DIR=$2

if [[ $ENVIRONMENT == 'production' ]]
then
  echo "Bootstrap application for production ..."
  mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
  cp ./docker/php/development.ini $PHP_INI_DIR/conf.d/

  composer install --no-dev --no-interaction --optimize-autoloader
else
  echo "Bootstrap application for development ..."
  mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
  cp ./docker/php/development.ini $PHP_INI_DIR/conf.d/
fi
