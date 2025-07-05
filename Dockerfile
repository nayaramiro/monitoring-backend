FROM php:8.1-apache

RUN apt-get update && apt-get install -y libsqlite3-dev \
    && docker-php-ext-install pdo_sqlite

# Modifier Apache pour écouter le port via variable d'environnement PORT
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

ENV PORT 8080

RUN sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf

EXPOSE 8080

COPY . /var/www/html/

CMD ["apache2-foreground"]
