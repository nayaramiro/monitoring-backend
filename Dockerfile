# Utilise l'image officielle PHP avec serveur Apache
FROM php:8.1-apache

# Active l'extension SQLite
RUN docker-php-ext-install pdo_sqlite

# Copie tout le backend dans le container Apache
COPY . /var/www/html/

# Expose le port 80 (Apache)
EXPOSE 80
