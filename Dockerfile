FROM php:8.1-apache

RUN apt-get update && apt-get install -y libsqlite3-dev \
    && docker-php-ext-install pdo_sqlite

COPY scripts/api.php /var/www/html/api.php
COPY db/dashboard.sqlite /var/www/html/db/dashboard.sqlite
COPY scripts/create_db.php /var/www/html/create_db.php
COPY scripts/test_api.php /var/www/html/test_api.php

# Modifier Apache pour écouter sur le port 8080
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-enabled/000-default.conf

EXPOSE 8080

CMD ["apache2-foreground"]
