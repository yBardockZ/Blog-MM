<div class="col-md-6 mb-4">
    <div class="card shadow-sm h-100" id="post-card" data-aos="zoom-in" data-aos-delay="{{ $index * 100 }}">

        <img id = "post-card-image" src="{{ $post->image ? asset('/images/posts/thumbnails/'.$post->image) : 
        'https://via.placeholder.com/400x200/6c757d/ffffff?text=Sem+Imagem' }}">

        <div class="card-body d-flex flex-column">
            {{-- Título da Postagem --}}
            <h5 class="card-title">{{ $post->title }}</h5>

            {{-- Resumo / Corpo da Postagem --}}
            <p class="card-text text-muted" id="text-truncate-lines">
                {{ $post->content }}
            </p>

            {{-- Rodapé do Card (Alinhado ao final) --}}
            <div class="mt-auto d-flex justify-content-between align-items-center">

                @if (isset($actions))
                    {!! $actions !!}
                @else
                    {{-- Botão para Ler Mais --}}
                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-primary">
                        Ler Post
                    </a>

                    <button class="like-button {{ $post->likes->contains('user_id', auth()->id()) ? 'liked' : '' }}"
                        data-likeable-id="{{ $post->id }}" data-likeable-type="post">
                        <i class="bi bi-heart{{ $post->likes->contains('user_id', auth()->id()) ? '-fill' : '' }}"></i>
                        <span class="like-count">{{ $post->likes->count() }}</span>
                    </button>
                @endif
                {{-- Ícone e Contador de Comentários --}}
                <small class="text-secondary d-flex align-items-center">
                    {{-- O ícone desejado (bi-chat-dots para balão de fala) --}}
                    <i class="bi bi-chat-dots me-1"></i>
                    {{-- Número de comentários (Exemplo: 5) --}}
                    <span href="#">{{ $post->comments->count() }} Comentários</span>
                </small>
            </div>
        </div>
    </div>
</div>
