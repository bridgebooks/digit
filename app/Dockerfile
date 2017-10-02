FROM php:7-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev mysql-client \
  && docker-php-ext-install mcrypt pdo_mysql bcmath

RUN docker-php-source extract && \
    pecl install redis && \
    docker-php-ext-enable redis&& \
    docker-php-source delete

RUN apt-get update && apt-get install -y wget
#RUN wget https://github.com/jwilder/dockerize/releases/download/v0.1.0/dockerize-linux-amd64-v0.1.0.tar.gz
#RUN tar -C /usr/local/bin -xzvf dockerize-linux-amd64-v0.1.0.tar.gz

WORKDIR /var/www/app