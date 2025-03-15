FROM php:8.1-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zip unzip libzip-dev curl libcurl4-openssl-dev libonig-dev libxml2-dev

# Install only needed extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable mod_rewrite for Apache
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html/

# Copy composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Copy source code (your public folder)
COPY ./public/ /var/www/html/
