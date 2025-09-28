@extends('layouts.main')

@section('title', 'Meu blog laravel')

@section('content')
    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Bem-vindo ao Blog!</h1>
            <p class="col-md-8 fs-4">Aqui você encontra as últimas novidades sobre tecnologia e programação.</p>
            <a href="#" class="btn btn-primary btn-lg" role="button">Começar a ler</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <h2>Últimos Posts</h2>
            <p>Conteúdo dinâmico de posts entrará aqui.</p>
        </div>
        <div class="col-md-4">
            <h2>Sobre Nós</h2>
            <p>Mais informações sobre o projeto.</p>
        </div>
        <div class="col-md-4">
            <h2>Contato</h2>
            <p>Fale conosco.</p>
        </div>
    </div>

@endsection
