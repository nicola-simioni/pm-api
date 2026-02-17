# 1️⃣ Immagine base PHP 8.3 con FPM
FROM php:8.3-fpm

# 2️⃣ Installazione librerie di sistema necessarie per Laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    libpng-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath gd

# 3️⃣ Installazione Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4️⃣ Impostazione cartella di lavoro
WORKDIR /var/www

# 5️⃣ Copia del progetto nel container
COPY . /var/www

# 6️⃣ Installazione delle dipendenze PHP del progetto
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# 7️⃣ Esponi porta Laravel (per artisan serve se vuoi)
EXPOSE 8000
