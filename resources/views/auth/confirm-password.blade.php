<x-guest-layout>
    
    <h3 class="mb-4 text-center">Confirmar Senha</h3>

    {{-- Texto de instrução --}}
    <div class="mb-4 text-secondary">
        {{ __('Esta é uma área segura da aplicação. Por favor, confirme sua senha antes de continuar.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

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

            {{-- Mensagens de erro com Bootstrap --}}
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Confirmar') }}
            </button>
        </div>
    </form>
</x-guest-layout>