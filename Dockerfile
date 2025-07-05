FROM php:8.1-apache

# Installer les dépendances nécessaires pour pdo_sqlite
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    && docker-php-ext-install pdo_sqlite

COPY . /var/www/html/

EXPOSE 80
