FROM php:8.1-apache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP extensions
RUN apt-get update && apt-get install -y zip unzip libzip-dev && \
    docker-php-ext-install pdo pdo_mysql mysqli json mbstring

# Set working directory
WORKDIR /var/www/html/

# Copy composer files & install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Copy source code
COPY ./public/ /var/www/html/

# Enable Apache mod_rewrite
RUN a2enmod rewrite
