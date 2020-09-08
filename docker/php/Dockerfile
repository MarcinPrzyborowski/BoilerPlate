FROM php:7.4-fpm

RUN apt-get update -yqq \
    && apt-get install git curl unzip zlib1g-dev libicu-dev g++  -y

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
&& composer --version

# extract php-source
RUN docker-php-source extract

# install pdo mysql
RUN docker-php-ext-install pdo_mysql

# install bc-math
RUN docker-php-ext-install bcmath

RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl

# clear php-source
RUN docker-php-source delete

RUN usermod -u 1000 www-data

USER www-data

EXPOSE 9000