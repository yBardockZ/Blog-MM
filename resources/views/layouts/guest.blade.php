@extends('layouts.main')

@section('title', 'Autenticação')

@section('content')

     {{-- Container para centralizar o formulário no Bootstrap --}}
    <div class="row justify-content-center mt-5">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg p-4">
                <div class="card-body">
                    {{-- O $slot é onde o conteúdo da view (login.blade.php) será injetado --}}
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

@endsection