@extends('layouts.main')

@section('title', 'Criar post')

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="mb-4">Criar novo post</h1>

            <hr>

            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- TÍTULO --}}
                <div class="mb-3">
                    <label for="title" class="form-label">Título</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                        name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- CONTEÚDO --}}
                <div class="mb-3">
                    <label for="content" class="form-label">Conteúdo</label>
                    <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="6"
                        required>{{ old('content') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- IMAGEM --}}
                <div class="mb-3">
                    <label for="image" class="form-label">Imagem Principal</label>
                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image"
                        name="image">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- CATEGORIA (Relacionamento 1:N) --}}
                <div class="mb-3">
                    <label for="category_id" class="form-label">Categoria</label>
                    <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                        name="category_id" required>
                        <option value="" disabled selected>Selecione uma Categoria</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- TAGS (Relacionamento N:M) - A MELHOR FORMA --}}
                <div class="mb-3">
                    <label class="form-label">Tags (Selecione uma ou mais)</label>
                    <div class="row">
                        @foreach ($tags as $tag)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tags[]"
                                        value="{{ $tag->id }}" id="tag-{{ $tag->id }}"
                                        {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
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

                <button type="submit" class="btn btn-primary mt-3">Publicar Post</button>


            </form>
        </div>
    </div>


@endsection
