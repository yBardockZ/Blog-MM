import './bootstrap';

import AOS from 'aos';
import 'aos/dist/aos.css';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

AOS.init({
  duration: 800,
  once: true,      
  easing: 'ease-in-out', 
});
