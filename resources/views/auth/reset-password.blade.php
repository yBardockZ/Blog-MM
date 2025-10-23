@extends('layouts.main')

@section('title', 'Redefinir Senha')

@section('content')
<div class="container d-flex justify-content-center align-items-center mt-5">
    <div class="card shadow-sm border-0 w-100" style="max-width: 500px;">
        <div class="card-body p-4">
            <h4 class="mb-4 text-center">Redefinir Senha</h4>

            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                {{-- Token obrigatório --}}
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input id="email" 
                           type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           name="email" 
                           value="{{ old('email', $request->email) }}" 
                           required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Senha --}}
                <div class="mb-3">
                    <label for="password" class="form-label">Nova Senha</label>
                    <input id="password" 
                           type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           name="password" 
                           required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirmação --}}
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                    <input id="password_confirmation" 
                           type="password" 
                           class="form-control" 
                           name="password_confirmation" 
                           required>
                </div>

                {{-- Botão --}}
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        Redefinir Senha
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
