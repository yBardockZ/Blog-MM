#!/bin/bash
set -e

echo "=== Iniciando aplicação Laravel ==="

# Aguardar banco de dados
echo "Aguardando banco de dados..."
sleep 10

# Verificar se .env existe
if [ ! -f .env ]; then
    echo "Criando arquivo .env..."
    cp .env.example .env
    php artisan key:generate
fi

# Limpar cache
echo "Limpando cache..."
php artisan config:clear || true
php artisan cache:clear || true

# Migrations (comentado - rode manualmente)
# echo "Rodando migrations..."
# php artisan migrate --force || echo "Migrations já executadas"

# Permissões
echo "Ajustando permissões..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Iniciar PHP-FPM
echo "Iniciando PHP-FPM..."
php-fpm -D

# Testar configuração do Nginx
echo "Testando configuração do Nginx..."
nginx -t

# Iniciar Nginx
echo "Iniciando Nginx..."
nginx -g 'daemon off;'