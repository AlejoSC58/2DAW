FROM php:7.4-apache

# Instalar extensiones necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiar los archivos de la aplicación al contenedor
COPY . /var/www/html/
