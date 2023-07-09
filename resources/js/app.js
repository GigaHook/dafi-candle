import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

//vuetify
import { createVuetify } from 'vuetify'
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

//mixins
import { router } from '@inertiajs/vue3';

//components
import BtnPrimary from './Components/BtnPrimary.vue'
import BtnSecondary from './Components/BtnSecondary.vue'
import FormInput from './Components/FormInput.vue'

//layput
import AppLayout from './Layouts/AppLayout.vue'

const mainTheme = {
    dark: false,
    colors: {
        primary: '#FFFF33',
        secondary: '#fff0dd',
        accent: '#774141',
        info: '#34312a',
        warning: '#625f58'
    }
}

const vuetify = createVuetify({ 
    components, 
    directives, 
    theme: {
        defaultTheme: "mainTheme",
        themes: { mainTheme }
    },
    icons: { defaultSet: 'mdi' }
});

const appName = 'Dafi Candle'

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app =  createApp({ render: () => h(App, props) })
        .use(plugin)
        .use(ZiggyVue, Ziggy)
        .use(vuetify)
        
        .component('BtnPrimary', BtnPrimary)
        .component('BtnSecondary', BtnSecondary)
        .component('FormInput', FormInput)

        app.config.globalProperties.$router = router

        app.mount(el)

        return app
        
    },
    progress: false,
});
