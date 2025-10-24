# ==============================================
# Etapa 1 — Build PHP + dependências Composer
# ==============================================
FROM php:8.3-fpm AS php-builder

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libjpeg-dev libfreetype6-dev libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql gd

# Instalar Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia os arquivos do Laravel (primeiro só os necessários para composer)
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copia o restante do código
COPY . .

# Gera cache de configuração (AGUARDA as variáveis de ambiente)
RUN php artisan config:clear

# ==============================================
# Etapa 2 — Build do frontend com Vite
# ==============================================
FROM node:20 AS vite-builder

WORKDIR /app

# Copia arquivos do package.json primeiro (para cache de camadas)
COPY package.json package-lock.json* ./
RUN npm install

# Copia o restante e faz o build
COPY . .
COPY --from=php-builder /var/www/html/vite.config.js ./
RUN npm run build

# ==============================================
# Etapa 3 — Imagem final
# ==============================================
FROM php:8.3-fpm

# Instalar dependências necessárias para execução
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev libpq-dev nginx \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql gd

# Instalar Composer para comandos adicionais
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Configurar Nginx (opcional)
COPY docker/nginx.conf /etc/nginx/sites-available/default

# Diretório de trabalho
WORKDIR /var/www/html

# Copia o build final do Laravel
COPY --from=php-builder /var/www/html ./

# Copia o build final do Laravel + assets do Vite
COPY --from=php-builder /var/www/html ./ 
COPY --from=vite-builder /app/public/build ./public/build

# Corrige permissões
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8000

# Inicia com cache e servidor
CMD php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=8000
