<section>
    <header class="mb-4">
        <h2 class="h5 font-weight-bold text-dark">
            {{ __('Atualizar Senha') }}
        </h2>

        <p class="mt-1 text-muted small">
            {{ __('Certifique-se de que sua conta esteja usando uma senha longa e aleatória para se manter segura.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4 space-y-4">
        @csrf
        @method('put')

        {{-- SENHA ATUAL --}}
        <div class="mb-3">
            <label for="current_password" class="form-label">{{ __('Senha Atual') }}</label>
            <input id="current_password" name="current_password" type="password" 
                class="form-control" 
                autocomplete="current-password" />
            
            @error('current_password', 'updatePassword')
                <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror
        </div>

        {{-- NOVA SENHA --}}
        <div class="mb-3">
            <label for="password" class="form-label">{{ __('Nova Senha') }}</label>
            <input id="password" name="password" type="password" 
                class="form-control" 
                autocomplete="new-password" />
            
            @error('password', 'updatePassword')
                <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror
        </div>

        {{-- CONFIRMAR NOVA SENHA --}}
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">{{ __('Confirmar Senha') }}</label>
            <input id="password_confirmation" name="password_confirmation" type="password" 
                class="form-control" 
                autocomplete="new-password" />
            
            @error('password_confirmation', 'updatePassword')
                <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror
        </div>

        {{-- BOTÃO SALVAR E MENSAGEM DE STATUS --}}
        <div class="d-flex align-items-center gap-4 pt-2">
            <button type="submit" class="btn btn-primary">{{ __('Salvar') }}</button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-success small m-0">
                    {{ __('Salvo.') }}
                </p>
            @endif
        </div>
    </form>
</section>