<section>
    <header class="mb-4">
        <h2 class="h5 font-weight-bold text-dark">
            {{ __('Deletar Conta') }}
        </h2>

        <p class="mt-1 text-muted small">
            {{ __('Uma vez que sua conta for excluída, todos os seus recursos e dados serão apagados permanentemente.') }}
        </p>
    </header>

    {{-- BOTÃO QUE ABRE O MODAL --}}
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
        {{ __('Deletar Conta') }}
    </button>


    {{-- 🛑 MODAL DO BOOTSTRAP PARA CONFIRMAÇÃO 🛑 --}}
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmUserDeletionModalLabel">
                            {{ __('Tem certeza de que deseja excluir sua conta?') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <p class="text-muted small">
                            {{ __('Uma vez que sua conta for excluída, todos os seus recursos e dados serão apagados permanentemente. Por favor, insira sua senha para confirmar que deseja excluir permanentemente sua conta.') }}
                        </p>

                        {{-- CAMPO SENHA --}}
                        <div class="mt-3">
                            <label for="password_delete" class="form-label sr-only">{{ __('Senha') }}</label>
                            <input
                                id="password_delete"
                                name="password"
                                type="password"
                                class="form-control"
                                placeholder="{{ __('Senha') }}"
                            />
                            
                            @error('password', 'userDeletion')
                                {{-- Este erro geralmente é tratado no back-end após a submissão --}}
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('Cancelar') }}
                        </button>

                        <button type="submit" class="btn btn-danger ms-3">
                            {{ __('Deletar Conta') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</section>