<section class="hero-banner container-fluid p-0 d-flex flex-column justify-content-center align-items-center text-center text-light">
    <div class="hero-overlay"></div>
    
    <div class="hero-content position-relative">
        
        @if(!request('search') && !request('page'))
            {{-- COM ANIMAÇÃO - Apenas quando NÃO há busca --}}
            
            {{-- Título --}}
            <div x-data="{ show: false }" 
                 x-init="setTimeout(() => show = true, 200)"
                 x-cloak>
                <h1 x-show="show"
                    x-transition.opacity.duration.1000ms
                    style="transition: opacity 1s ease-out;">
                    Bem-vindo ao MM!
                </h1>
            </div>
            
            {{-- Parágrafo --}}
            <div x-data="{ show: false }" 
                 x-init="setTimeout(() => show = true, 600)"
                 x-cloak>
                <p x-show="show"
                   x-transition.opacity.duration.1000ms
                   style="transition: opacity 1s ease-out;">
                    Aqui você encontra as últimas novidades...
                </p>
            </div>
            
            {{-- Barra de pesquisa --}}
            <form action="{{ route('posts.index') }}" 
                  method="GET" 
                  class="d-flex justify-content-center">
                
                <div x-data="{ show: false }" 
                     x-init="setTimeout(() => show = true, 1000)"
                     x-cloak
                     class="input-group w-200"
                     x-show="show"
                     x-transition.opacity.duration.1000ms
                     style="transition: opacity 1s ease-out;">
                    
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Pesquisar posts..."
                           value="{{ request('search') }}">
                    <button class="btn btn-outline-light" type="submit">
                        <i class="bi bi-search"></i> Pesquisar
                    </button>
                </div>
            </form>
            
        @else
            {{-- SEM ANIMAÇÃO - Quando há busca ativa --}}
            
            <h1>Bem-vindo ao Blog!</h1>
            <p>Aqui você encontra as últimas novidades...</p>
            
            <form action="{{ route('posts.index') }}" 
                  method="GET" 
                  class="d-flex justify-content-center">
                
                <div class="input-group w-200">
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Pesquisar posts..."
                           value="{{ request('search') }}">
                    <button class="btn btn-outline-light" type="submit">
                        <i class="bi bi-search"></i> Pesquisar
                    </button>
                </div>
            </form>
        @endif
    </div>
</section>