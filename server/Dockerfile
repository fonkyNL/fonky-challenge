FROM php:8.1.5-fpm

RUN apt-get update
RUN apt-get install -y git     
RUN apt-get install -y curl 
RUN apt-get install -y zip 
RUN apt-get install -y vim 
RUN apt-get install -y unzip 
RUN apt-get install -y openssl

RUN docker-php-ext-install -j$(nproc) iconv 
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install bcmath 
# RUN docker-php-ext-install json 
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install exif

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www