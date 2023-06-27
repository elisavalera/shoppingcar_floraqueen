FROM php:8.1-fpm-alpine

# Instalar las dependencias necesarias para la aplicación
RUN apk add --no-cache \
    git \
    zlib-dev \
    libzip-dev \
    && docker-php-ext-install zip pdo_mysql

COPY custom.ini /usr/local/etc/php/conf.d/

# Instalar las dependencias de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configurar el directorio de trabajo
WORKDIR /var/www/html

# Copiar el código de la aplicación a la imagen
COPY . .

# Exponer el puerto 9000 para conectarse con el servidor web
EXPOSE 9000