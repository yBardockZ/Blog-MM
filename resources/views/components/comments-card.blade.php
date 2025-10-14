{{-- CONTAINER PRINCIPAL COM O ID PARA JS/JQUERY --}}
<div class="card shadow-sm mb-3">
    <div class="card-body">

        {{-- Metadados --}}
        <p class="card-text fw-bold mb-2">
            {{ $comment->author->name }} -
            {{ $comment->created_at->format('d/m/Y H:i') }}
        </p>

        {{-- 1. VISUALIZAÇÃO DO COMENTÁRIO (Inicialmente visível) --}}
        <div class="comment-view-content" data-comment-id="{{ $comment->id }}">
            <p class="card-text comment-text text-break mb-2">
                {{ $comment->content }}
            </p>
            
            {{-- Container único para TODOS os botões de ação --}}
            <div class="d-flex align-items-center justify-content-between">
                {{-- BOTÃO DE CURTIR (alinhado à esquerda) --}}
                <button
                    class="like-button {{ $comment->likes->contains('user_id', auth()->id()) ? 'liked' : '' }}"
                    data-likeable-id="{{ $comment->id }}" 
                    data-likeable-type="comment">
                    <i class="bi bi-heart{{ $comment->likes->contains('user_id', auth()->id()) ? '-fill' : '' }}"></i>
                    <span class="like-count">{{ $comment->likes->count() }}</span>
                </button>
                
                {{-- BOTÕES DE EDITAR E DELETAR (alinhados à direita) --}}
                @auth
                    @if (auth()->user()->id === $comment->author_id || auth()->user()->id === $comment->post->author_id)
                        <div class="d-flex align-items-center gap-2">
                            {{-- BOTÃO DE EDITAR --}}
                            <button type="button" 
                                    class="btn btn-outline-info p-2 border-0 btn-edit-comment"
                                    data-comment-id="{{ $comment->id }}">
                                <i class="bi bi-pencil-square fs-5"></i>
                            </button>

                            {{-- BOTÃO DE DELETAR --}}
                            <form action="{{ route('comments.destroy', $comment->id) }}" 
                                  method="POST" 
                                  class="d-inline m-0"
                                  onsubmit="return confirm('Tem certeza que deseja remover este comentário? Esta ação é irreversível.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger p-2 border-0">
                                    <i class="bi bi-trash-fill fs-5"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        </div>

        {{-- 2. FORMULÁRIO DE EDIÇÃO (Inicialmente Escondido) --}}
        <div class="comment-edit-form" data-comment-id="{{ $comment->id }}" style="display: none;">
            <form action="{{ route('comments.update', $comment) }}" method="POST">
                @csrf
                @method('PATCH')

                <textarea class="form-control mb-2" rows="3" name="content" required>{{ $comment->content }}</textarea>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="bi bi-check-lg"></i> Salvar
                    </button>

                    {{-- Botão de Cancelar --}}
                    <button type="button" 
                            class="btn btn-sm btn-secondary btn-cancel-edit"
                            data-comment-id="{{ $comment->id }}">
                        <i class="bi bi-x-lg"></i> Cancelar
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>