FROM node:20 AS build

WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# ... (etapa de build de node igual)

FROM php:8.2-fpm

# Instalar dependencias del sistema (Añadimos dependencias para dompdf y limpieza)
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    libpq-dev libzip-dev libicu-dev nginx supervisor \
    libfontconfig1 libxrender1 # Requerido por dompdf

# Instalar extensiones PHP
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd opcache zip intl sockets

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# --- ESTRATEGIA DE INSTALACIÓN LIMPIA ---
# 1. Copiamos solo los archivos de composer
COPY composer.json composer.lock ./

# 2. Instalamos SIN ejecutar scripts (esto evita el error de artisan package:discover)
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# 3. Copiamos el resto de la aplicación
COPY . .

# 4. Copiamos los assets de Node
COPY --from=build /app/public/build /var/www/html/public/build

# 5. Ahora que el código está, generamos el autoload real
RUN composer dump-autoload --optimize --no-dev

# Ajuste de permisos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Nginx configuration
COPY docker/nginx/conf.d/app.conf /etc/nginx/conf.d/default.conf
RUN echo "daemon off;" >> /etc/nginx/nginx.conf

# Entrypoint
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
