# Étape 1 : base PHP
FROM php:8.2-fpm

# Installer les dépendances système
RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip curl libzip-dev libonig-dev zlib1g-dev libssl-dev \
    libpng-dev libjpeg-dev libfreetype6-dev build-essential \
    && docker-php-ext-install pdo pdo_mysql mbstring zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer Node.js (pour builder Vue)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copier le projet
WORKDIR /var/www
COPY . .

# Installer les dépendances PHP et Node, builder Vue
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Générer la clé Laravel
RUN php artisan key:generate

# Exposer le port
EXPOSE 8000

# Commande pour lancer Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
