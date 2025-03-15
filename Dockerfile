# Gunakan image PHP resmi dengan Apache
FROM php:8.1-apache

# Copy source ke container Apache
COPY ./public/ /var/www/html/

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer.json dan install dependency
COPY composer.json /var/www/html/
COPY composer.lock /var/www/html/
WORKDIR /var/www/html/
RUN composer install

# Copy credentials ke lokasi yang bisa dibaca app
COPY firebase_credentials.json /var/www/html/firebase_credentials.json

# Tambahan konfigurasi mod_rewrite jika dibutuhkan
RUN a2enmod rewrite
