@extends('layouts.main')

@section('title', 'Meu blog laravel')

@section('content')
    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Bem-vindo ao Blog!</h1>
            <p class="col-md-8 fs-4">Aqui você encontra as últimas novidades sobre tecnologia e programação.</p>
            {{-- FORMULÁRIO DE PESQUISA (NOVO) --}}
            <form class="d-flex" action="/" method="GET"> {{-- Substitua '#' pela rota de busca --}}
                <input class="form-control me-2" type="search" placeholder="Pesquisar posts..." aria-label="Pesquisar"
                    name="search" {{-- O nome do parâmetro que será enviado na URL (ex: ?query=laravel) --}}>
                <button class="btn btn-outline-success" type="submit">
                    <i class="bi bi-search"></i> Pesquisar
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        @if ($posts->isEmpty() && $search)
            <p>Nenhum post encontrado para "{{ $search }}"! <a href="/" class="btn btn-primary">Ver todos</a>
            </p>
        @elseif($posts->isEmpty())
            <p>Nenhum post cadastrado</p>
        @endif

        @foreach ($posts as $post)
            @include('components.post-card', ['post' => $post])
        @endforeach

        {{-- PAGINAÇÃO --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $posts->withQueryString()->links('pagination::bootstrap-5') }}
        </div>

    </div>

@endsection
