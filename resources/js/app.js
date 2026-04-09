import './bootstrap';

import Alpine from 'alpinejs';
import { createApp } from 'vue';
import GeneratorApp from './components/App.vue';

window.Alpine = Alpine;

Alpine.start();

const generatorRoot = document.getElementById('app');
if (generatorRoot) {
    createApp(GeneratorApp).mount('#app');
}
