# Blog-MM

Blog desenvolvido com **Laravel 12**, **Tailwind CSS 4**, **Alpine.js** e **Vite**, com sistema de autenticação, CRUD de posts, comentários, likes, categorias e tags.

## Tech Stack

### Backend
- **PHP 8.2** + **Laravel 12**
- **Laravel Breeze** — autenticação scaffolding
- **Intervention Image 3** — redimensionamento e geração de thumbnails
- **MySQL 8.0** — banco de dados

### Frontend
- **Tailwind CSS 4** — estilização
- **Alpine.js 3** — interatividade
- **AOS** — animações de scroll
- **Vite 7** — bundler de assets
- **Blade Templates** — views

### Infraestrutura
- **Docker** + **Docker Compose** — PHP-FPM + Nginx + MySQL
- **Multi-stage build** — otimizado para deploy em produção

---

## Funcionalidades

- **Autenticação** — registro, login, logout, verificação de email, redefinição de senha (via Laravel Breeze)
- **Posts** — criar, editar, excluir e visualizar posts com imagem de capa
- **Dashboard** — painel do autor com listagem dos seus posts
- **Comentários** — criar, editar e excluir comentários em posts (autor do post pode moderar)
- **Likes** — sistema de curtidas polimórfico (funciona em posts e comentários)
- **Categorias** — associação de posts a categorias
- **Tags** — associação many-to-many de posts a tags
- **Busca** — pesquisa por título e conteúdo dos posts
- **Processamento de imagens** — upload com redimensionamento automático (1200px) e geração de thumbnail (800×500)
- **Perfil** — editar informações, senha e excluir conta
- **Internacionalização** — suporte a traduções via `laravel-lang/common`

---

## Requisitos

- PHP >= 8.2
- Composer
- Node.js >= 20
- MySQL 8.0

Ou apenas **Docker** + **Docker Compose**.

---

## Instalação Local

### 1. Clonar o repositório

```bash
cd "C:\Users\Thalles\Desktop\Projetos\projeto blog\Blog-MM"
```

### 2. Copiar e configurar o `.env`

```bash
cp .env.example .env
```

Ajuste as variáveis no `.env`:

```env
APP_NAME=Blog-MM
APP_URL=http://localhost:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blog_mm
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Instalar dependências

```bash
composer install
npm install
```

### 4. Gerar chave da aplicação e rodar migrations

```bash
php artisan key:generate
php artisan migrate
```

### 5. Build dos assets

```bash
npm run dev      # desenvolvimento (hot reload)
npm run build    # produção (minificado)
```

### 6. Iniciar o servidor

```bash
# Modo simples
php artisan serve

# Ou modo completo com concurrent (server, queue, logs, vite)
composer run dev
```

Acesse em `http://localhost:8000`

---

## Executando com Docker

### Build e inicialização

```bash
docker compose build
docker compose up -d
```

O app estará disponível em `http://localhost:8000` e o MySQL em `localhost:3306`.

### Rodar migrations dentro do container

```bash
docker exec laravel_app php artisan migrate
docker exec laravel_app php artisan key:generate
```

### Parar os containers

```bash
docker compose down
# ou para remover volumes também:
docker compose down -v
```

---

## Estrutura do Projeto

```
Blog-MM/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/           # Controllers de autenticação (Breeze)
│   │   │   ├── PostController.php   # CRUD + dashboard + upload de imagens
│   │   │   ├── CommentController.php # Comentários em posts
│   │   │   ├── LikeController.php    # Likes polimórficos (API JSON)
│   │   │   └── ProfileController.php # Gestão de perfil
│   │   └── Requests/
│   │       └── PostRequest.php # Validação de formulários
│   ├── Models/
│   │   ├── User.php            # Modelo de usuário
│   │   ├── Post.php            # Posts do blog
│   │   ├── Comment.php         # Comentários
│   │   ├── Like.php            # Likes (polimórfico)
│   │   ├── Category.php        # Categorias
│   │   └── Tag.php             # Tags
│   ├── Providers/
│   └── View/
├── config/
├── database/
│   ├── migrations/             # Schema do banco
│   └── seeders/
├── docker/
│   ├── nginx/default.conf      # Configuração do Nginx
│   ├── php/custom.ini          # Configurações customizadas do PHP
│   ├── start.sh                # Script dev
│   └── start-render.sh         # Script para deploy (Render)
├── public/
│   └── images/posts/           # Imagens dos posts (originals + thumbnails)
├── resources/
│   ├── css/                    # Tailwind CSS + estilos customizadas
│   ├── js/
│   └── views/
│       ├── layouts/            # Layouts blade (app, guest, main)
│       ├── include/            # Partials (header, footer, hero)
│       ├── components/         # Blade components (post-card, comments-card)
│       ├── auth/               # Views de autenticação
│       ├── posts/              # Views de posts (create, edit, show)
│       ├── profile/            # Views de perfil
│       ├── welcome.blade.php   # Home / listagem de posts
│       ├── dashboard.blade.php # Dashboard do autor
│       └── contact.blade.php   # Página de contato
├── routes/
│   ├── web.php                 # Rotas principais
│   └── auth.php                # Rotas de autenticação
├── storage/
├── tests/
├── docker-compose.yml
├── Dockerfile
├── vite.config.js
├── package.json
└── composer.json
```

---

## Modelo de Dados

### Tabelas

| Tabela | Descrição |
|---|---|
| `users` | Usuários (autores) do blog |
| `posts` | Posts com título, conteúdo, imagem, autor e categoria |
| `categories` | Categorias dos posts |
| `tags` | Tags organizacionais |
| `post_tag` | Pivot many-to-many entre posts e tags |
| `comments` | Comentários associados a posts |
| `likes` | Likes polimórficos (`likeable_type` + `likeable_id`) |
| `cache` / `jobs` | Cache e filas do Laravel |

### Relacionamentos principais

```
User          1 ←→ N  Post
Post          1 ←→ N  Comment
Post          N ←→ N  Tag (via post_tag)
Post          N ←→ 1  Category
Post/Comment  1 ←→ N  Like (polimórfico)
User          1 ←→ N  Comment
```

---

## Rotas da API

| Método | Rota | Nome | Descrição | Auth |
|---|---|---|---|---|
| `GET` | `/` | `posts.index` | Listagem de posts (home) | Não |
| `GET` | `/contact` | `contact` | Página de contato | Não |
| `GET` | `/posts/{id}` | `posts.show` | Visualizar post | Não |
| `GET` | `/posts/create` | `posts.create` | Formulário de criação | Sim |
| `POST` | `/posts` | `posts.store` | Criar post | Sim |
| `GET` | `/posts/edit/{id}` | `posts.edit` | Formulário de edição | Sim |
| `PUT` | `/posts/{id}` | `posts.update` | Atualizar post | Sim |
| `DELETE` | `/posts/{id}` | `posts.destroy` | Excluir post | Sim |
| `POST` | `/comments` | `comments.store` | Adicionar comentário | Sim |
| `PATCH` | `/comments/{id}` | `comments.update` | Editar comentário | Sim |
| `DELETE` | `/comments/{id}` | `comments.destroy` | Excluir comentário | Sim |
| `POST` | `/like/toggle` | `like.toggle` | Toggle like (JSON) | Sim |
| `GET` | `/dashboard` | `dashboard` | Dashboard do autor | Sim |
| `GET/PUT/PATCH/DELETE` | `/profile` | `profile.*` | Gestão do perfil | Sim |

Rotas de **autenticação** (`/login`, `/register`, `/forgot-password`, etc.) são gerenciadas pelo Laravel Breeze.

---

## Upload de Imagens

Ao enviar uma imagem em um post:

1. O nome é gerado como hash MD5 + timestamp
2. A imagem original é redimensionada para **1200px** de largura (qualidade 90%)
3. Uma thumbnail é gerada em **800×500** (qualidade 85%)
4. Ambas são salvas em `public/images/posts/` e `public/images/posts/thumbnails/`
5. Ao editar excluir, a imagem antiga é removida automaticamente

---

## Comandos Úteis

```bash
# Testes
composer run test

# Formatação de código
./vendor/bin/pint

# Limpar caches
php artisan optimize:clear

# Otimizar para produção
php artisan optimize           # Config + route + view cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Criar link simbólico para storage
php artisan storage:link

# Seeder (se disponível)
php artisan db:seed
```

---

## Deploy

### Render (ou plataformas similares)

O `dockerfile` multi-stage está configurado para produção:

- **Stage 1 (builder)**: Instala dependências, gera autoload, faz build do Vite, otimiza
- **Stage 2 (runtime)**: PHP-FPM 8.2 + Nginx, copia apenas o necessário do builder

O script `docker/start-render.sh` inicia o Nginx e o PHP-FPM.

---

## Licença

MIT
