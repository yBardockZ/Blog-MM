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
                    @foreach ($post->tags as $tag)
                        <span class="badge bg-primary text-decoration-none link-light me-1">{{ $tag->name }}</span>
                    @endforeach
                </header>

                {{-- Imagem Principal --}}
                <figure class="mb-4">
                    <img class="img-fluid rounded" src=""
                        alt="{{ $post->title }}" />
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
                    <form method="POST" action="{{ route('comments.store') }}" class="mb-4">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">

                        <textarea class="form-control" rows="3" placeholder="Junte-se à conversa..." name="content"></textarea>

                        <button type="submit" class="btn btn-primary mt-2">Enviar Comentário</button>
                    </form>

                    <div class="text-dark">
                        @if ($post->comments->count() == 0)
                            <p>Ainda não há comentários.</p>
                        @else
                            @foreach ($post->comments as $comment)
                                {{-- CONTAINER PRINCIPAL COM O ID PARA JS/JQUERY --}}
                                <div class="card shadow-sm mb-3">
                                    <div class="card-body">

                                        {{-- Metadados --}}
                                        <p class="card-text fw-bold">
                                            {{ $comment->author->name }} -
                                            {{ $comment->created_at->format('d/m/Y') }}
                                        </p>

                                        {{-- 1. VISUALIZAÇÃO DO COMENTÁRIO (Inicialmente visível) --}}
                                        <div class="comment-view-content" data-comment-id="{{ $comment->id }}">
                                            <p class="card-text comment-text">
                                                {{ $comment->content }}
                                            </p>

                                            <div class="d-flex gap-2 mt-2">
                                                {{-- BOTÃO DE EDITAR (Adicionado) --}}
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-info p-1 border-0 btn-edit-comment"
                                                    data-comment-id="{{ $comment->id }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>

                                                {{-- SEU BOTÃO DE DELETAR (Já Existente) --}}
                                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Tem certeza que deseja remover este comentário? Esta ação é irreversível.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger p-1 border-0">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        {{-- 2. FORMULÁRIO DE EDIÇÃO (Inicialmente Escondido) --}}
                                        <div class="comment-edit-form" data-comment-id="{{ $comment->id }}"
                                            style="display: none;">
                                            <form action="{{ route('comments.update', $comment) }}" method="POST">
                                                @csrf
                                                @method('PATCH')

                                                <textarea class="form-control mb-2" rows="3" name="content">{{ $comment->content }}</textarea>

                                                <button type="submit" class="btn btn-sm btn-success">Salvar</button>

                                                {{-- Botão de Cancelar --}}
                                                <button type="button" class="btn btn-sm btn-secondary btn-cancel-edit"
                                                    data-comment-id="{{ $comment->id }}">
                                                    Cancelar
                                                </button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    {{-- ⚠️ NÃO ESQUEÇA DE INCLUIR O JQUERY E O SCRIPT DE ALTERNÂNCIA (PRÓXIMO PASSO) --}}
                </div>
        </div>
        </section>
    </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $('.btn-edit-comment').on('click', function() {
                const commentId = $(this).data('comment-id');

                $(`.comment-view-content[data-comment-id="${commentId}"]`).hide();
                $(`.comment-edit-form[data-comment-id="${commentId}"]`).show();
            });

            $('.btn-cancel-edit').on('click', function() {
                const commentId = $(this).data('comment-id');

                // Mostra a visualização e esconde o formulário
                $(`.comment-view-content[data-comment-id="${commentId}"]`).show();
                $(`.comment-edit-form[data-comment-id="${commentId}"]`).hide();
            });

        });
    </script>

@endsection
