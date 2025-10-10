{{-- resources/views/includes/header.blade.php --}}
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                Laravel Blog
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                {{-- Links de Navegação --}}
                {{-- GRUPO 1: LINKS PRINCIPAIS (Esquerda) --}}
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('posts.index') ? 'active' : '' }}" aria-current="page"
                            href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contato</a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Cadastrar</a>
                        </li>
                    @endguest

                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('posts.create') }}">Criar Post</a>
                        </li>
                        <li class="nav-item">
                            {{-- Mudei para Dashboard/Profile do Breeze --}}
                            <a class="nav-link text-warning" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.edit') }}">Perfil</a>
                        </li>
                        
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-flex">
                                @csrf
                                <button type="submit" 
                                class="btn btn-link nav-link"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    Logout
                                </button>
                            </form>
                        </li>
                    @endauth

                </ul>

                {{-- FIM FORMULÁRIO DE PESQUISA --}}

            </div>
        </div>
    </nav>
</header>
