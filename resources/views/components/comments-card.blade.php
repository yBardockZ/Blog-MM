{{-- CONTAINER PRINCIPAL COM O ID PARA JS/JQUERY --}}
<div class="card shadow-sm mb-3">
    <div class="card-body">

        {{-- Metadados --}}
        <p class="card-text fw-bold">
            {{ $comment->author->name }} -
            {{ $comment->created_at->format('d/m/Y  H:i') }}
        </p>

        {{-- 1. VISUALIZAÇÃO DO COMENTÁRIO (Inicialmente visível) --}}
        <div class="comment-view-content" data-comment-id="{{ $comment->id }}">
            <p class="card-text comment-text">
                {{ $comment->content }}
            </p>

            <div class="d-flex gap-2 mt-2">
                {{-- BOTÃO DE EDITAR (Adicionado) --}}
                <button type="button" class="btn btn-sm btn-outline-info p-1 border-0 btn-edit-comment"
                    data-comment-id="{{ $comment->id }}">
                    <i class="bi bi-pencil-square"></i>
                </button>

                {{-- SEU BOTÃO DE DELETAR (Já Existente) --}}
                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Tem certeza que deseja remover este comentário? Esta ação é irreversível.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger p-1 border-0">
                        <i class="bi bi-trash-fill"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- 2. FORMULÁRIO DE EDIÇÃO (Inicialmente Escondido) --}}
        <div class="comment-edit-form" data-comment-id="{{ $comment->id }}" style="display: none;">
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
