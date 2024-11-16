import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

//console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
//configuracion de vue
import { createApp } from 'vue';
import app from './components/app.vue';

//configuracion de vuetify
import { createVuetify } from 'vuetify';
import 'vuetify/styles';
import '@mdi/font/css/materialdesignicons.css'
//estilos de vuetify
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: 'mdi',
        
    },
});

//importar vueRoastify
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

createApp(app).use(vuetify).use(toast, { autoClose: 3000 }).mount('#app');
