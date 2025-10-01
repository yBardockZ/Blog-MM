<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- 1. Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">

    {{-- **NOVO: Bootstrap Icons CSS** --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <title>@yield('title')</title>
</head>
<body class="d-flex flex-column min-vh-100">

    @include('include.header')

    {{-- **BLOCO DE NOTIFICAÇÃO FLASH (NOVO)** --}}
    @if(session('msg'))
        <div class="container mt-3"> {{-- Garante que a notificação fique centralizada e formatada --}}
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('msg') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif
    {{-- **FIM BLOCO DE NOTIFICAÇÃO** --}}

    <main class="container my-5 flex-grow-1">
        @yield('content')
    </main>

    @include('include.footer')
    
    @yield('scripts')

    {{-- 2. Bootstrap JS **NOVO** --}}
    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
        crossorigin="anonymous">
    </script>
</body>
</html>