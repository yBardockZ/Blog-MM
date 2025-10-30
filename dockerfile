# ================================
# Etapa 1 — Build do Laravel + Vite
# ================================
FROM php:8.2-fpm AS builder

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd zip mbstring exif pcntl bcmath intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Node.js 20.x (versão LTS)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar APENAS arquivos de dependências primeiro
COPY composer.json composer.lock ./

# Instalar dependências (SEM --no-dev ainda)
RUN composer install --no-scripts --no-autoloader --ansi --no-interaction

# Copiar arquivos do Node
COPY package.json package-lock.json* ./
RUN npm ci

# Agora copiar TODO o projeto
COPY . .

# Gerar autoload completo
RUN composer dump-autoload --optimize --classmap-authoritative

# Criar arquivo .env se não existir (usa .env.example ou cria vazio)
RUN if [ -f .env.example ]; then \
        cp .env.example .env; \
    else \
        touch .env && \
        echo "APP_NAME=Laravel" >> .env && \
        echo "APP_ENV=production" >> .env && \
        echo "APP_DEBUG=false" >> .env && \
        echo "APP_KEY=" >> .env; \
    fi

# Gerar chave
RUN php artisan key:generate --ansi

# Build do Vite
RUN npm run build

# Agora SIM remover dependências de dev
RUN composer install --no-dev --optimize-autoloader --classmap-authoritative --ansi --no-interaction

# Criar diretórios necessários
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache

# Limpar cache anterior
RUN php artisan optimize:clear || true

# Otimizar Laravel (pode falhar se .env estiver incompleto, por isso || true)
RUN php artisan config:cache || true
RUN php artisan route:cache || true
RUN php artisan view:cache || true

# ================================
# Etapa 2 — Nginx + PHP-FPM
# ================================
FROM php:8.2-fpm

# Instalar extensões necessárias
RUN apt-get update && apt-get install -y \
    nginx \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Copiar aplicação buildada
COPY --from=builder /var/www/html .

# COPIAR CONFIGURAÇÃO PHP CUSTOMIZADA
COPY docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini

# Configurar permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Configurar Nginx
COPY docker/nginx/default.conf /etc/nginx/sites-available/default
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Expor porta
EXPOSE 80

# Script de inicialização
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh \
    && sed -i 's/\r$//' /usr/local/bin/start.sh  # Remove \r do Windows

CMD ["/usr/local/bin/start.sh"]