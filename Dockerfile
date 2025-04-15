FROM php:8.2-fpm-alpine

# Instalace základních nástrojů a závislostí
RUN apk add --no-cache \
    git \
    unzip \
    libzip-dev \
    icu-dev \
    && docker-php-ext-install \
    pdo_mysql \
    zip \
    intl \
    opcache

# Instalace Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Kopírování souborů projektu
COPY . .

# Nastavení proměnné prostředí pro Composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Vytvoření adresáře bin a console souboru
RUN mkdir -p bin && echo '#!/usr/bin/env php' > bin/console && chmod +x bin/console

# Instalace závislostí PHP
RUN composer install --optimize-autoloader --no-scripts

EXPOSE 9000

CMD ["php-fpm"]
