# Utiliser l’image PHP avec Apache
FROM php:8.1-apache

RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-enabled/000-default.conf

# Installer les dépendances pour SQLite
RUN apt-get update && apt-get install -y libsqlite3-dev \
    && docker-php-ext-install pdo_sqlite

# Copier api.php à la racine web pour qu’il soit accessible par l’URL /api.php
COPY scripts/api.php /var/www/html/api.php

# Copier la base de données SQLite dans un dossier db accessible
COPY db/dashboard.sqlite /var/www/html/db/dashboard.sqlite

# (Optionnel) Copier d’autres scripts si nécessaires
COPY scripts/create_db.php /var/www/html/create_db.php
COPY scripts/test_api.php /var/www/html/test_api.php

# Exposer le port 80 (HTTP)
EXPOSE 80

# Lancement d’Apache en mode foreground (par défaut dans cette image)
CMD ["apache2-foreground"]
