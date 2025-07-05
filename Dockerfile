FROM php:8.1-apache

# Installer sqlite et pdo_sqlite
RUN apt-get update && apt-get install -y libsqlite3-dev sqlite3 \
    && docker-php-ext-install pdo_sqlite

# Copier le code backend dans le dossier Apache
COPY . /var/www/html/

# Donner les bonnes permissions sur la base SQLite
RUN chown -R www-data:www-data /var/www/html/db \
    && chmod -R 755 /var/www/html/db

EXPOSE 80
