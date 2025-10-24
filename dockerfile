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

# Copia os arquivos do Laravel
COPY . .

# Instala dependências PHP
RUN composer install --no-dev --optimize-autoloader

# Gera cache de configuração, rotas e views
RUN php artisan config:clear && php artisan route:clear && php artisan view:clear

# ==============================================
# Etapa 2 — Build do frontend com Vite
# ==============================================
FROM node:20 AS vite-builder

WORKDIR /app
COPY . .

RUN npm install && npm run build

# ==============================================
# Etapa 3 — Imagem final
# ==============================================
FROM php:8.3-fpm

# Instalar dependências necessárias para execução
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql gd

# Diretório de trabalho
WORKDIR /var/www/html

# Copia o build final do Laravel e do Vite
COPY --from=php-builder /var/www/html ./
COPY --from=vite-builder /app/public ./public

# Expor a porta usada pelo PHP
EXPOSE 8000

# Comando de inicialização
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
