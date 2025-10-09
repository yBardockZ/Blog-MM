@extends('layouts.main')

@section('title', 'Editando: '. $post->title)

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="mb-4">Editar Post</h1>

            {{-- Formulário de Edição --}}
            {{-- Ação: posts.update (PUT). Método POST no HTML é necessário. --}}
            <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">

                @csrf
                {{-- 🛑 IMPORTANTE: Blade Directive para simular o método PUT 🛑 --}}
                @method('PUT')

                {{-- TÍTULO --}}
                <div class="mb-3">
                    <label for="title" class="form-label">Título</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                        name="title" {{-- Preenche com dados antigos (old()) ou com o dado atual ($post) --}} value="{{ old('title', $post->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- CONTEÚDO --}}
                <div class="mb-3">
                    <label for="content" class="form-label">Conteúdo</label>
                    <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="6"
                        required>{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- IMAGEM ATUAL (Opcional: mostrar a imagem existente) --}}
                @if ($post->image)
                    <div class="mb-3">
                        <label class="form-label d-block">Imagem Atual</label>
                        <img src="{{ asset('images/posts/' . $post->image) }}" alt="Imagem atual"
                            style="max-width: 200px; height: auto;">
                        <small class="text-muted d-block mt-1">Envie um novo arquivo para substituir.</small>
                    </div>
                @endif

                {{-- NOVA IMAGEM --}}
                <div class="mb-3">
                    <label for="image" class="form-label">Nova Imagem</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                        name="image">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                {{-- CATEGORIA --}}
                <div class="mb-3">
                    <label for="category_id" class="form-label">Categoria</label>
                    <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                        name="category_id" required>
                        <option value="">Selecione uma categoria</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{-- Verifica se a categoria está selecionada no OLD ou no POST --}}
                                {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- TAGS (Relacionamento N:M) --}}
                <div class="mb-3">
                    <label class="form-label">Tags (Selecione uma ou mais)</label>
                    <div class="row">
                        @foreach ($tags as $tag)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tags[]"
                                        value="{{ $tag->id }}" id="tag-{{ $tag->id }}" {{-- 🛑 Verifica se a tag está selecionada (OLD ou já vinculada ao POST) 🛑 --}}
                                        @php
// Converte as tags atuais do post para um array de IDs
                                            $postTags = $post->tags->pluck('id')->toArray();
                                            $checked = in_array($tag->id, old('tags', $postTags)) ? 'checked' : ''; @endphp
                                        {!! $checked !!}>
                                    <label class="form-check-label" for="tag-{{ $tag->id }}">
                                        {{ $tag->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('tags')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-warning mt-3">Atualizar Post</button>
            </form>
        </div>
    </div>

@endsection
