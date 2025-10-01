@extends('layouts.main')

@section('title', $post->title)

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <article>
                {{-- Título --}}
                <header class="mb-4">
                    <h1 class="fw-bolder mb-1">{{ $post->title }}</h1>
                    <div class="text-muted fst-italic mb-2">
                        Postado em {{ $post->created_at->format('d/m/Y') }}
                    </div>
                    
                    {{-- Tags (Você implementará isso depois) --}}
                    <span class="badge bg-primary text-decoration-none link-light me-1">Tecnologia</span>
                    <span class="badge bg-secondary text-decoration-none link-light">Laravel</span>
                </header>
                
                {{-- Imagem Principal --}}
                <figure class="mb-4">
                    <img class="img-fluid rounded" src="https://via.placeholder.com/900x400?text=Imagem+do+Post" alt="{{ $post->title }}" />
                </figure>
                
                {{-- Corpo do Post --}}
                <section class="mb-5 fs-5">
                    {!! nl2br(e($post->content)) !!}
                </section>
            </article>

            {{-- Área de Comentários (Próximo passo importante!) --}}
            <section class="mb-5">
                <div class="card bg-light p-4">
                    <h4 class="card-title text-dark">Comentários ({{ $post->comments->count() }})</h4>
                    <form method="POST" action="/comments" class="mb-4">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">

                        <textarea class="form-control" rows="3" placeholder="Junte-se à conversa..." name="content"></textarea>

                        <button type="submit" class="btn btn-primary mt-2">Enviar Comentário</button>
                    </form>
                    
                    <div class="text-dark">
                        @if($post->comments->count() == 0)
                            <p>Ainda não há comentários.</p>
                        @else
                            @foreach($post->comments as $comment)
                                <div class="card shadow-sm mb-3">
                                    <div class="card-body">
                                        <p class="card-text fw-bold">{{ $comment->author->name }} - {{ $comment->created_at->format('d/m/Y') }}></p>
                                        <p class="card-text">
                                            {{ $comment->content }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection