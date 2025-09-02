FROM php:8.2-fpm

# Installer les dépendances système pour PHP
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    curl \
    libzip-dev \
    libonig-dev \
    sqlite3 \
    gnupg2 \
    ca-certificates \
    build-essential \
    libssl-dev \
    zlib1g-dev

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql pdo_sqlite mbstring zip

# Nettoyer pour réduire la taille de l'image
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer Node.js 18 LTS et npm via NodeSource
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && node -v && npm -v

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

# Exposer le port pour Laravel
EXPOSE 8000

# Commande pour lancer Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
