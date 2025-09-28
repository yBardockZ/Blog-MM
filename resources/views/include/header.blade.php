{{-- resources/views/includes/header.blade.php --}}
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                Laravel Blog
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                {{-- Links de Navegação --}}
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contato</a>
                    </li>
                    {{-- Links de Autenticação --}}
                    @auth
                        <li class="nav-item">
                            <a class="nav-link text-warning" href="#">Dashboard</a>
                        </li>
                    @endauth
                </ul>

                {{-- FORMULÁRIO DE PESQUISA (NOVO) --}}
                <form class="d-flex" action="#" method="GET"> {{-- Substitua '#' pela rota de busca --}}
                    <input 
                        class="form-control me-2" 
                        type="search" 
                        placeholder="Pesquisar posts..." 
                        aria-label="Pesquisar" 
                        name="query" {{-- O nome do parâmetro que será enviado na URL (ex: ?query=laravel) --}}
                    >
                    <button class="btn btn-outline-success" type="submit">
                        <i class="bi bi-search"></i> Pesquisar
                    </button>
                </form>
                {{-- FIM FORMULÁRIO DE PESQUISA --}}
            </div>
        </div>
    </nav>
</header>