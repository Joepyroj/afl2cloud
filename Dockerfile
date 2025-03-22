# Gunakan PHP 8.1 + Apache
FROM php:8.1-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zip unzip libzip-dev curl libcurl4-openssl-dev libonig-dev libxml2-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql

# Enable mod_rewrite for Apache
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files dan install dependency
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Copy seluruh isi folder public ke folder Apache
COPY ./public/ /var/www/html/

# Set permission
RUN chown -R www-data:www-data /var/www/html

RUN apt-get update && apt-get install -y tzdata
ENV TZ=Asia/Jakarta
