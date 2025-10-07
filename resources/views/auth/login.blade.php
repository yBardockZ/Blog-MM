<x-guest-layout>
    
    {{-- Removendo o componente Session Status, se não for usar --}}
    @if (session('status'))
        <div class="alert alert-success mb-4" role="alert">
            {{ session('status') }}
        </div>
    @endif

    {{-- Título opcional --}}
    <h3 class="mb-4 text-center">Acessar Conta</h3>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input 
                id="email" 
                class="form-control @error('email') is-invalid @enderror" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autofocus 
                autocomplete="username" 
            />
            {{-- Substituído por mensagens de erro nativas do Laravel/Bootstrap --}}
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">{{ __('Senha') }}</label>

            <input 
                id="password" 
                class="form-control @error('password') is-invalid @enderror"
                type="password"
                name="password"
                required 
                autocomplete="current-password" 
            />

            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3 form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
            <label class="form-check-label" for="remember_me">
                {{ __('Lembrar de mim') }}
            </label>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            
            {{-- Link Esqueci a Senha --}}
            @if (Route::has('password.request'))
                <a class="text-decoration-none" href="{{ route('password.request') }}">
                    {{ __('Esqueceu sua senha?') }}
                </a>
            @endif

            {{-- Botão de Login --}}
            <button type="submit" class="btn btn-primary">
                {{ __('Entrar') }}
            </button>
        </div>
    </form>
    
</x-guest-layout>