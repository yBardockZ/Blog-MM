@extends('layouts.main')

@section('title', 'Dashboard de posts')

@section('content')

    <h1 class="mb-4">Seus Posts</h1>

    {{-- BARRA DE PESQUISA --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Buscar e Gerenciar Posts</h5>
            
            <form class="d-flex" action="{{ route('dashboard') }}" method="GET">
                <input 
                    class="form-control me-2" 
                    type="search" 
                    placeholder="Pesquisar em seus posts..." 
                    aria-label="Pesquisar" 
                    name="search" 
                    value="{{ request('search') }}"
                >
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            @if(request('search'))
                <p class="mt-2 mb-0 text-muted">Mostrando resultados para: **{{ request('search') }}**</p>
            @endif

        </div>
    </div>

    <div class="row">
        @forelse ($posts as $post)
                @php
                    $dashboardActions = '
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <a href="'.route('posts.show', $post->id).'" class="btn btn-sm btn-info text-white">
                            <i class="bi bi-eye"></i> Visualizar
                        </a>
                        <div class="d-flex gap-2">
                            <a href="'.route('posts.edit', $post->id).'" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                            
                            <form action="'.route('posts.destroy', $post->id).'" method="POST" class="d-inline">
                                '.csrf_field().'
                                '.method_field('DELETE').'
                                <button type="submit" class="btn btn-sm btn-danger" 
                                        onclick="return confirm(\'Tem certeza que deseja deletar o post: '.$post->title.'?\');">
                                    <i class="bi bi-trash"></i> Deletar
                                </button>
                            </form>
                        </div>
                    </div>
                    ';
                @endphp

                @include('components.post-card', [
                'post' => $post,
                'actions' => $dashboardActions
                ])
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    @if(request('search'))
                        Nenhum post encontrado com o termo "{{ request('search') }}"
                    @else
                        Você ainda não publicou nenhum post.
                    @endif
                </div>
            </div>
            
        @endforelse
    </div>

    {{-- PAGINAÇÃO --}}
    <div class="d-flex justify-content-center mt-5">
        {{ $posts->withQueryString()->links('pagination::bootstrap-5') }}
    </div>

@endsection