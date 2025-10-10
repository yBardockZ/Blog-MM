@extends('layouts.main')

@section('title', $post->title)

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <article>
                {{-- Título --}}
                <header class="mb-4">
                    <h1 class="fw-bolder mb-1">{{ $post->title }}</h1>
                    <p class="fw-bolder mb-2">Por: {{ $post->author->name }}</p>
                    <div class="text-muted fst-italic mb-2">
                        Postado em {{ $post->created_at->format('d/m/Y  H:i') }}
                    </div>

                    {{-- Tags (Você implementará isso depois) --}}
                    @foreach ($post->tags as $tag)
                        <span class="badge bg-primary text-decoration-none link-light me-1">{{ $tag->name }}</span>
                    @endforeach
                </header>

                {{-- Imagem Principal --}}
                <figure class="mb-4">
                    <img class="img-fluid rounded" src="{{ asset('/images/posts/'.$post->image) }}"
                        alt="{{ $post->title }}" />
                </figure>

                {{-- Corpo do Post --}}
                <section class="mb-5 fs-5 text-break overflow-auto">
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
                                @include('components.comments-card', ['comment' => $comment])
                            @endforeach
                        @endif
                    </div>
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

                $(`.comment-view-content[data-comment-id="${commentId}"]`).show();
                $(`.comment-edit-form[data-comment-id="${commentId}"]`).hide();
            });

        });
    </script>

@endsection
