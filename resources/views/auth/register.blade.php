<x-guest-layout>

    <h3 class="mb-4 text-center">Criar Conta</h3>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Nome') }}</label>
            <input 
                id="name" 
                class="form-control @error('name') is-invalid @enderror" 
                type="text" 
                name="name" 
                value="{{ old('name') }}" 
                required 
                autofocus 
                autocomplete="name" 
            />
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input 
                id="email" 
                class="form-control @error('email') is-invalid @enderror" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autocomplete="username" 
            />
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
                autocomplete="new-password" 
            />

            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">{{ __('Confirmar Senha') }}</label>

            <input 
                id="password_confirmation" 
                class="form-control"
                type="password"
                name="password_confirmation"
                required 
                autocomplete="new-password" 
            />
        </div>

        <div class="d-flex justify-content-end align-items-center mt-4">
            
            {{-- Link para Login --}}
            <a class="text-decoration-none me-3" href="{{ route('login') }}">
                {{ __('Já tem uma conta?') }}
            </a>

            {{-- Botão de Registro --}}
            <button type="submit" class="btn btn-success">
                {{ __('Cadastrar') }}
            </button>
        </div>
    </form>

</x-guest-layout>