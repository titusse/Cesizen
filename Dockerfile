# Utiliser PHP 8.2 avec extensions Laravel
FROM php:8.2-fpm

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libonig-dev nodejs npm sqlite3 \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite mbstring zip

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copier le projet
WORKDIR /var/www
COPY . .

# Installer PHP et Node dépendances et builder Vue
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Générer la clé Laravel
RUN php artisan key:generate

# Exposer le port
EXPOSE 8000

# Commande pour lancer Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
