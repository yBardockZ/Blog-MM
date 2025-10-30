#!/bin/bash
set -e

echo "=== Iniciando Laravel no Render ==="

# Aguardar banco de dados (Render pode demorar)
echo "Aguardando banco de dados..."
for i in {1..30}; do
    if php artisan db:show &>/dev/null; then
        echo "Banco de dados conectado!"
        break
    fi
    echo "Tentativa $i/30..."
    sleep 2
done

# Limpar cache
echo "Limpando cache..."
php artisan config:clear || true
php artisan cache:clear || true

# Migrations (apenas se necessário)
echo "Rodando migrations..."
php artisan migrate --force || echo "Migrations já executadas"

# Seeds (comentado - rode manualmente se precisar)
php artisan db:seed --force || echo "Seeds já executados"

# Permissões
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Otimizar
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Iniciar PHP-FPM
php-fpm -D

# Render usa variável de ambiente PORT
# Atualizar Nginx para usar a porta correta
if [ ! -z "$PORT" ]; then
    sed -i "s/listen 80;/listen $PORT;/" /etc/nginx/sites-available/default
fi

# Testar Nginx
nginx -t

# Iniciar Nginx
nginx -g 'daemon off;'