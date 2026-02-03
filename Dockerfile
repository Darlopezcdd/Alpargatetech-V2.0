# --- ETAPA 1: Build de Assets (Node) ---
FROM node:20 AS build

WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# --- ETAPA 2: Runtime de PHP ---
FROM php:8.2-fpm

# Instalar dependencias del sistema requeridas
# Se añade libfontconfig1 y libxrender1 para dompdf
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    nginx \
    supervisor \
    libfontconfig1 \
    libxrender1

# Limpiar cache de apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones de PHP necesarias para Laravel 12, Reverb y DomPDF
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd opcache zip intl sockets

# Obtener la versión más reciente de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar directorio de trabajo
WORKDIR /var/www/html

# --- ESTRATEGIA PARA EVITAR EXIT CODE 2 ---

# 1. Copiar primero solo los archivos de dependencias
COPY composer.json composer.lock ./

# 2. Instalar dependencias SIN ejecutar scripts de Laravel ni plugins
# Usamos COMPOSER_MEMORY_LIMIT=-1 para evitar que Render mate el proceso por falta de RAM
# Sustituye tu comando de composer por este:
RUN COMPOSER_MEMORY_LIMIT=-1 composer install \
    --no-dev \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader

# 3. Ahora copiar el resto del código de la aplicación
COPY . .

# 4. Copiar los assets compilados desde la etapa 'build'
# Asegúrate de que la carpeta de destino coincida con lo que espera Laravel
COPY --from=build /app/public/build /var/www/html/public/build

# 5. Generar el autoload final ahora que ya existe el código (sin ejecutar scripts pesados)
RUN composer dump-autoload --optimize --no-dev

# 6. Configurar permisos de carpetas críticas
# Esto es vital para que Laravel pueda escribir logs y cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# --- CONFIGURACIÓN DE SERVIDORES ---

# Configuración de Nginx
COPY docker/nginx/conf.d/app.conf /etc/nginx/conf.d/default.conf
RUN echo "daemon off;" >> /etc/nginx/nginx.conf

# Configuración de Supervisor
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf


# Configuración del Entrypoint
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]