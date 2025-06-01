# Etapa para copiar Composer
FROM composer:latest AS composerstage

# Base de Laravel con PHP 8.2 y Apache
FROM php:8.2-apache

# Copiar configuración personalizada de Apache

# Habilitar mod_rewrite para Laravel
RUN a2enmod rewrite

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copiar Composer desde la imagen anterior
COPY --from=composerstage /usr/bin/composer /usr/bin/composer

# Asignar permisos adecuados para Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Directorio de trabajo por defecto
COPY apache.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html


