<x-guest-layout>
    
    <h3 class="mb-4 text-center">Recuperar Senha</h3>

    {{-- Texto de instrução --}}
    <div class="mb-4 text-secondary">
        {{ __('Esqueceu sua senha? Sem problemas. Basta nos informar seu endereço de e-mail e enviaremos um link de redefinição de senha que permitirá que você escolha uma nova.') }}
    </div>

    {{-- Session Status (Mensagem de sucesso após envio) --}}
    @if (session('status'))
        <div class="alert alert-success mb-4" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
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
            />
            
            {{-- Mensagens de erro com Bootstrap --}}
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Enviar Link de Redefinição de Senha por E-mail') }}
            </button>
        </div>
    </form>
    
</x-guest-layout>