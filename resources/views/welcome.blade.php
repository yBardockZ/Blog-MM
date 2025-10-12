@extends('layouts.main')

@section('title', 'Meu blog laravel')

@section('hero')
    @include('include.hero-banner')
@endsection

@section('content')

    <div class="row">
        @if ($posts->isEmpty() && $search)
            <p>Nenhum post encontrado para "{{ $search }}"! <a href="/" class="btn btn-primary">Ver todos</a>
            </p>
        @elseif($posts->isEmpty())
            <p>Nenhum post cadastrado</p>
        @endif

        @foreach ($posts as $index => $post)
            @include('components.post-card', ['post' => $post, 'index' => $index])
        @endforeach

        {{-- PAGINAÇÃO --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $posts->withQueryString()->links('pagination::bootstrap-5') }}
        </div>

    </div>

@endsection
