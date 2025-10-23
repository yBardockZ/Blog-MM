@extends('layouts.main')

@section('title', 'Verificar E-mail')

@section('content')
<div class="container d-flex justify-content-center align-items-center mt-5">
    <div class="card shadow-sm border-0 w-100" style="max-width: 500px;">
        <div class="card-body p-4 text-center">

            <h4 class="mb-3">Verifique seu E-mail</h4>
            <p class="text-muted">
                Antes de continuar, verifique seu e-mail clicando no link de verificação.
                Se você não recebeu o e-mail, podemos enviá-lo novamente.
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    Um novo link de verificação foi enviado para o e-mail cadastrado.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="d-grid gap-2 mt-4">
                {{-- Reenviar Link --}}
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        Reenviar E-mail de Verificação
                    </button>
                </form>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary">
                        Sair
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
