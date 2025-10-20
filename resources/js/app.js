import './bootstrap';

import AOS from 'aos';
import 'aos/dist/aos.css';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Inicialização centralizada do AOS e lógica de scroll
(function () {
  // Inicializa AOS quando o DOM estiver pronto (config básica)
  document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
      once: true,
      offset: 0,
      duration: 800,
      easing: 'ease-in-out',
    });
  });

  // Ao carregar toda a página (imagens/fontes), força recalcular o AOS
  window.addEventListener('load', () => {
    // Força re-calculo com a árvore DOM já totalmente renderizada
    AOS.refreshHard();
  });

  // Navbar: registra o listener de scroll **somente se a navbar existir**
  document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.querySelector('.transparent-navbar') || document.querySelector('.navbar');

    if (!navbar) {
      // nada a fazer se não houver navbar
      return;
    }

    // Função que adiciona/remova a classe scrolled
    const updateNavbarOnScroll = () => {
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    };

    // Atualiza já (caso a página carregue com scroll)
    updateNavbarOnScroll();

    // Escuta o evento scroll de forma eficiente
    window.addEventListener('scroll', updateNavbarOnScroll, { passive: true });
  });
})();

document.addEventListener('DOMContentLoaded', () => {
    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    const token = tokenMeta ? tokenMeta.content : '';

    document.querySelectorAll('.like-button').forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();

            const likeableId = button.dataset.likeableId;
            const likeableType = button.dataset.likeableType; // <— importante!

            try {
                const response = await fetch(`/like/toggle`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ 
                        likeable_id: likeableId,
                        likeable_type: likeableType
                    })
                });

                const data = await response.json();

                if (data.status) {
                    const count = button.querySelector('.like-count');
                    count.textContent = data.likes_count;

                    button.classList.toggle('liked', data.status === 'liked');
                }

            } catch (error) {
                console.error('Erro ao enviar like:', error);
            }
        });
    });
});




