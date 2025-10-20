@extends('layouts.main')

@section('title', $post->title)

@section('content')

<div class="container py-4">
    <div class="row">
        {{-- COLUNA PRINCIPAL --}}
        <div class="col-lg-8">
            <article>
                {{-- Cabeçalho do Post --}}
                <header class="mb-4">
                    {{-- Tags no topo --}}
                    <div class="mb-3">
                        @foreach ($post->tags as $tag)
                            <span class="badge bg-primary me-2">
                                <i class="bi bi-tag-fill"></i> {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>

                    {{-- Título --}}
                    <h1 class="display-4 fw-bold mb-3">{{ $post->title }}</h1>

                    {{-- Metadados com ícones --}}
                    <div class="d-flex flex-wrap align-items-center text-muted mb-3 gap-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-circle me-2"></i>
                            <span>Por <strong class="text-dark">{{ $post->author->name }}</strong></span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar3 me-2"></i>
                            <span>{{ $post->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-chat-dots me-2"></i>
                            <span>{{ $post->comments->count() }} comentários</span>
                        </div>
                    </div>
                </header>

                {{-- Imagem Principal --}}
                @if($post->image)
                    <figure class="mb-4 post-featured-image">
                        <img class="img-fluid rounded shadow-lg w-100" 
                             src="{{ asset('/images/posts/'.$post->image) }}"
                             alt="{{ $post->title }}"
                             style="max-height: 500px; object-fit: cover;" />
                    </figure>
                @endif

                {{-- Barra de Ações (Like e Compartilhar) --}}
                <div class="d-flex justify-content-between align-items-center border-top border-bottom py-3 mb-4">
                    <div class="d-flex gap-2">
                        {{-- Botão de Like --}}
                        <button class="like-button {{ $post->likes->contains('user_id', auth()->id()) ? 'liked' : '' }}"
                                data-likeable-id="{{ $post->id }}" 
                                data-likeable-type="post">
                            <i class="bi bi-heart{{ $post->likes->contains('user_id', auth()->id()) ? '-fill' : '' }}"></i>
                            <span class="like-count">{{ $post->likes->count() }}</span>
                        </button>

                        {{-- Botão scroll para comentários --}}
                        <button class="btn btn-outline-secondary btn-sm" 
                                onclick="document.getElementById('comments-section').scrollIntoView({behavior: 'smooth'})">
                            <i class="bi bi-chat-dots"></i>
                            {{ $post->comments->count() }}
                        </button>
                    </div>

                    {{-- Compartilhar --}}
                    <div class="d-flex gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                        target="_blank"
                        class="btn btn-outline-primary btn-sm"
                        title="Compartilhar no Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>

                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}"
                        target="_blank"
                        class="btn btn-outline-info btn-sm" 
                        title="Compartilhar no X">
                            <i class="bi bi-twitter-x"></i>
                        </a>

                        <a href="https://wa.me/send?text={{ urlencode($post->title) }} - {{ urlencode(url()->current()) }}"
                        target="_blank" 
                        class="btn btn-outline-success btn-sm" 
                        title="Compartilhar no WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <button class="btn btn-outline-secondary btn-sm" title="Copiar link" onclick="copyLink()">
                            <i class="bi bi-link-45deg"></i>
                        </button>
                    </div>
                </div>

                <hr class="my-4">

                {{-- Corpo do Post --}}
                <section class="mb-5 post-content fs-5 lh-lg text-break">
                    {!! nl2br(e($post->content)) !!}
                </section>

                <hr class="my-5">

                {{-- Área de Comentários --}}
                <section class="mb-5" id="comments-section">
                    <div class="card bg-light shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="card-title text-dark mb-4">
                                <i class="bi bi-chat-square-text"></i>
                                Comentários ({{ $post->comments->count() }})
                            </h4>

                            {{-- Formulário de Comentário --}}
                            @auth
                                <form method="POST" action="{{ route('comments.store') }}" class="mb-4">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">

                                    <textarea class="form-control mb-3" 
                                              rows="4" 
                                              placeholder="Junte-se à conversa..." 
                                              name="content"
                                              required></textarea>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-send"></i> Enviar Comentário
                                    </button>
                                </form>
                            @else
                                <div class="alert alert-info mb-4">
                                    <i class="bi bi-info-circle"></i>
                                    <a href="{{ route('login') }}" class="alert-link">Faça login</a> para comentar.
                                </div>
                            @endauth

                            {{-- Lista de Comentários --}}
                            <div class="text-dark">
                                @if ($post->comments->count() == 0)
                                    <div class="text-center text-muted py-5">
                                        <i class="bi bi-chat-dots display-1"></i>
                                        <p class="mt-3">Nenhum comentário ainda. Seja o primeiro a comentar!</p>
                                    </div>
                                @else
                                    @foreach ($post->comments as $comment)
                                        @include('components.comments-card', ['comment' => $comment])
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </section>
            </article>
        </div>

        {{-- SIDEBAR --}}
        <div class="col-lg-4">
            <div class="sidebar-sticky" style="margin-top: 200px;">
                {{-- Você Também Pode Gostar --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0">
                            <i class="bi bi-stars"></i>
                            Você Também Pode Gostar
                        </h5>
                    </div>
                    <div class="list-group list-group-flush">
                        @php
                            // Busca posts relacionados (mesmas tags ou mesmo autor, exceto o atual)
                            $relatedPosts = \App\Models\Post::where('id', '!=', $post->id)
                                ->where(function($query) use ($post) {
                                    $query->where('author_id', $post->author_id)
                                          ->orWhereHas('tags', function($q) use ($post) {
                                              $q->whereIn('tags.id', $post->tags->pluck('id'));
                                          });
                                })
                                ->latest()
                                ->take(3)
                                ->get();
                        @endphp

                        @forelse($relatedPosts as $related)
                            <a href="{{ route('posts.show', $related->id) }}" 
                               class="list-group-item list-group-item-action">
                                <div class="d-flex">
                                    @if($related->image)
                                        <div class="flex-shrink-0 me-3">
                                            <img src="{{ asset('/images/posts/'.$related->image) }}" 
                                                 alt="{{ $related->title }}"
                                                 class="rounded"
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                        </div>
                                    @else
                                        <div class="flex-shrink-0 me-3">
                                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                                                 style="width: 60px; height: 60px;">
                                                <i class="bi bi-image text-white"></i>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 text-truncate">{{ $related->title }}</h6>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar3"></i> 
                                            {{ $related->created_at->format('d/m/Y') }}
                                        </small>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="list-group-item text-center text-muted">
                                <i class="bi bi-inbox"></i>
                                <p class="mb-0 mt-2 small">Nenhum post relacionado encontrado</p>
                            </div>
                        @endforelse
                    </div>
                    
                    {{-- Link para ver todos os posts --}}
                    @if($relatedPosts->count() > 0)
                        <div class="card-footer bg-white text-center">
                            <a href="{{ route('posts.index') }}" class="btn btn-link btn-sm text-decoration-none">
                                Ver todos os posts <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Editar comentário
            $('.btn-edit-comment').on('click', function() {
                const commentId = $(this).data('comment-id');
                $(`.comment-view-content[data-comment-id="${commentId}"]`).hide();
                $(`.comment-edit-form[data-comment-id="${commentId}"]`).show();
            });

            // Cancelar edição
            $('.btn-cancel-edit').on('click', function() {
                const commentId = $(this).data('comment-id');
                $(`.comment-view-content[data-comment-id="${commentId}"]`).show();
                $(`.comment-edit-form[data-comment-id="${commentId}"]`).hide();
            });
        });

        // Função para copiar link
        function copyLink() {
            navigator.clipboard.writeText(window.location.href).then(function() {
                alert('Link copiado para a área de transferência!');
            }, function() {
                alert('Erro ao copiar o link.');
            });
        }
    </script>
@endsection