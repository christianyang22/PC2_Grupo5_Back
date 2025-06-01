# Etapa para copiar Composer
FROM composer:latest AS composerstage

# Base de Laravel con PHP 8.2 y Apache
FROM php:8.2-apache

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

# Copiar configuración personalizada de Apache
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar el proyecto al contenedor
COPY . .

# Crear el archivo .env si no existe
RUN cp .env.example .env

# Instalar dependencias y generar la clave de Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && php artisan key:generate

# Asignar permisos adecuados para Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache
