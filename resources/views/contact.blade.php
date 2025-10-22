@extends('layouts.main')

@section('title', 'Contato')

@section('content')

<div class="container py-5" id="inner-page">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Cabeçalho --}}
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold mb-3">Entre em Contato</h1>
                <p class="lead text-muted">
                    Vamos conversar! Estou sempre aberto a novas oportunidades e colaborações.
                </p>
            </div>

            <div class="row g-4">
                {{-- GitHub --}}
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100 border-0 contact-card">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-github display-3 text-dark"></i>
                            </div>
                            <h5 class="card-title mb-2">GitHub</h5>
                            <p class="card-text text-muted small mb-3">
                                Confira meus projetos e repositórios
                            </p>
                            <a href="https://github.com/yBardockZ" 
                               target="_blank"
                               rel="noopener noreferrer"
                               class="btn btn-outline-dark btn-sm">
                                <i class="bi bi-box-arrow-up-right me-1"></i>
                                Visitar Perfil
                            </a>
                        </div>
                    </div>
                </div>

                {{-- LinkedIn --}}
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100 border-0 contact-card">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-linkedin display-3 text-primary"></i>
                            </div>
                            <h5 class="card-title mb-2">LinkedIn</h5>
                            <p class="card-text text-muted small mb-3">
                                Conecte-se comigo profissionalmente
                            </p>
                            <a href="https://www.linkedin.com/in/thalles-leopoldino" 
                               target="_blank"
                               rel="noopener noreferrer"
                               class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-box-arrow-up-right me-1"></i>
                                Conectar
                            </a>
                        </div>
                    </div>
                </div>

                {{-- WhatsApp --}}
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100 border-0 contact-card">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-whatsapp display-3 text-success"></i>
                            </div>
                            <h5 class="card-title mb-2">WhatsApp</h5>
                            <p class="card-text text-muted small mb-3">
                                Fale comigo diretamente
                            </p>
                            <a href="https://wa.me/5521965615548?text=Ol%C3%A1!%20Vim%20atrav%C3%A9s%20do%20seu%20portf%C3%B3lio" 
                               target="_blank"
                               rel="noopener noreferrer"
                               class="btn btn-outline-success btn-sm">
                                <i class="bi bi-chat-dots me-1"></i>
                                Enviar Mensagem
                            </a>
                        </div>
                    </div>
                </div>

                {{-- E-mail --}}
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100 border-0 contact-card">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-envelope-at display-3 text-danger"></i>
                            </div>
                            <h5 class="card-title mb-2">E-mail</h5>
                            <p class="card-text text-muted small mb-3">
                                Mande uma mensagem por e-mail
                            </p>
                            <a href="mailto:thalles_leopoldino@outlook.com" 
                               class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-envelope me-1"></i>
                                Enviar E-mail
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Portfólio (Em Breve) --}}
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100 border-0 contact-card">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-globe display-3 text-secondary"></i>
                            </div>
                            <h5 class="card-title mb-2">Portfólio</h5>
                            <p class="card-text text-muted small mb-3">
                                Veja mais sobre meu trabalho
                            </p>
                            <span class="btn btn-outline-secondary btn-sm disabled">
                                <i class="bi bi-clock me-1"></i>
                                Em Breve
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Currículo (Em Breve) --}}
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100 border-0 contact-card">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-file-earmark-person display-3 text-secondary"></i>
                            </div>
                            <h5 class="card-title mb-2">Currículo</h5>
                            <p class="card-text text-muted small mb-3">
                                Baixe meu currículo completo
                            </p>
                            <a href="{{ asset('files/curriculo.pdf') }}" 
                               download 
                               class="btn btn-outline-warning btn-sm">
                            <i class="bi bi-download me-1"></i>
                            Download CV
                        </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Seção Sobre Mim --}}
            <div class="card shadow-sm border-0 mt-5">
                <div class="card-body p-5">
                    <div class="row align-items-center">
                        <div class="col-lg-4 text-center mb-4 mb-lg-0">
                            <div class="avatar-container mx-auto mb-3">
                                <img src="{{ asset('images/avatar.jpg') }}" 
                                     alt="Thalles Leopoldino"
                                     class="avatar-image">
                            </div>
                            <h4 class="mb-2">Thalles Leopoldino</h4>
                            <p class="text-muted">Desenvolvedor Full Stack</p>
                            
                            {{-- Links Rápidos --}}
                            <div class="d-flex justify-content-center gap-3 mt-3">
                                <a href="https://github.com/yBardockZ" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   class="text-dark fs-4"
                                   title="GitHub">
                                    <i class="bi bi-github"></i>
                                </a>
                                <a href="https://www.linkedin.com/in/thalles-leopoldino" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   class="text-primary fs-4"
                                   title="LinkedIn">
                                    <i class="bi bi-linkedin"></i>
                                </a>
                                <a href="https://wa.me/5521965615548?text=Ol%C3%A1!%20Vim%20atrav%C3%A9s%20do%20seu%20portf%C3%B3lio" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   class="text-success fs-4"
                                   title="WhatsApp">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                                <a href="mailto:thalles_leopoldino@outlook.com" 
                                   class="text-danger fs-4"
                                   title="E-mail">
                                    <i class="bi bi-envelope"></i>
                                </a>
                            </div>
                        </div>
                        
                        <div class="col-lg-8">
                            <h3 class="mb-3">Sobre Mim</h3>
                            <p class="text-muted mb-3">
                                Olá! Sou um desenvolvedor apaixonado por tecnologia e inovação. 
                                Este blog é parte do meu portfólio, onde compartilho conhecimentos 
                                e experiências sobre desenvolvimento web, Laravel, PHP e muito mais.
                            </p>
                            <p class="text-muted mb-4">
                                Estou sempre aberto a novos projetos, colaborações e oportunidades 
                                de networking. Se você tem uma ideia interessante ou quer trocar 
                                uma ideia sobre tecnologia, não hesite em entrar em contato!
                            </p>
                            
                            <h5 class="mb-3">Tecnologias que Domino:</h5>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-primary">Java</span>
                                <span class="badge bg-primary">Spring</span>
                                <span class="badge bg-primary">Laravel</span>
                                <span class="badge bg-primary">PHP</span>
                                <span class="badge bg-info">JavaScript</span>
                                <span class="badge bg-success">Vue.js</span>
                                <span class="badge bg-warning text-dark">MySQL</span>
                                <span class="badge bg-danger">Git</span>
                                <span class="badge bg-secondary">Bootstrap</span>
                                <span class="badge bg-dark">Alpine.js</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Call to Action --}}
            <div class="text-center mt-5 p-5 bg-light rounded">
                <h3 class="mb-3">Vamos Trabalhar Juntos?</h3>
                <p class="text-muted mb-4">
                    Estou disponível para freelances, projetos colaborativos e oportunidades full-time.
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="https://wa.me/5521965615548?text=Ol%C3%A1!%20Tenho%20uma%20proposta" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="btn btn-success">
                        <i class="bi bi-whatsapp me-2"></i>
                        Falar no WhatsApp
                    </a>
                    <a href="mailto:thalles_leopoldino@outlook.com" 
                       class="btn btn-primary">
                        <i class="bi bi-envelope me-2"></i>
                        Enviar E-mail
                    </a>
                    <a href="https://www.linkedin.com/in/thalles-leopoldino" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="btn btn-outline-primary">
                        <i class="bi bi-linkedin me-2"></i>
                        Conectar no LinkedIn
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection