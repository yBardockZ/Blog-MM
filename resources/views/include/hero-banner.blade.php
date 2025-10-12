<section class="hero-banner container-fluid p-0 d-flex flex-column justify-content-center align-items-center text-center text-light">
        <div class="hero-overlay"></div>

        <div class="hero-content position-relative" 
        x-data="{ 
            showTitle: false, 
            showSubtitle: false 
        }" 
        x-init="
            setTimeout(() => showTitle = true, 400);
            setTimeout(() => showSubtitle = true, 400);
        ">
            <h1 x-show="showTitle"
            x-transition:enter="ease-out duration-1000"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="animate-element">
                Bem-vindo ao Blog!
            </h1>
    
            <p x-show="showSubtitle"
            x-transition:enter="ease-out duration-1000"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="animate-element">
                Aqui você encontra as últimas novidades...
            </p>

            {{-- Barra de pesquisa --}}
            <form action="{{ route('posts.index') }}" method="GET" class="d-flex justify-content-center">
                <div class="input-group w-200">
                    <input type="text" name="search" class="form-control" placeholder="Pesquisar posts..."
                        value="{{ request('search') }}">
                    <button class="btn btn-outline-light" type="submit">
                        <i class="bi bi-search"></i> Pesquisar
                    </button>
                </div>
            </form>
        </div>
</section>