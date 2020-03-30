FROM php:7.4-fpm-alpine

SHELL ["/bin/ash", "-oeux", "pipefail", "-c"]

RUN apk update \
  && docker-php-ext-install pdo_mysql
