<section>
    <header class="mb-4">
        <h2 class="h5 font-weight-bold text-dark">
            {{ __('Informações do Perfil') }}
        </h2>

        <p class="mt-1 text-muted small">
            {{ __("Atualize as informações de perfil e endereço de e-mail da sua conta.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        {{-- CAMPO NOME --}}
        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Nome') }}</label>
            <input id="name" name="name" type="text" 
                class="form-control" 
                value="{{ old('name', $user->name) }}" 
                required autofocus autocomplete="name" />
            
            @error('name')
                <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror
        </div>

        {{-- CAMPO EMAIL --}}
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" 
                class="form-control" 
                value="{{ old('email', $user->email) }}" 
                required autocomplete="username" />
            
            @error('email')
                <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror

            {{-- VERIFICAÇÃO DE EMAIL (Lógica do Breeze mantida) --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-muted small">
                        {{ __('Seu endereço de e-mail não foi verificado.') }}

                        <button form="send-verification" 
                            class="btn btn-link p-0 m-0 align-baseline text-decoration-none">
                            {{ __('Clique aqui para reenviar o e-mail de verificação.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-weight-bold text-success small">
                            {{ __('Um novo link de verificação foi enviado para o seu endereço de e-mail.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- BOTÃO SALVAR E MENSAGEM DE STATUS --}}
        <div class="d-flex align-items-center gap-4">
            <button type="submit" class="btn btn-primary">{{ __('Salvar') }}</button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-success small m-0">
                    {{ __('Salvo.') }}
                </p>
            @endif
        </div>
    </form>
</section>