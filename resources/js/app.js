import './bootstrap'
import '../css/app.css'

import { createApp, h } from 'vue'
import { createInertiaApp, Head } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'

//vuetify
import { createVuetify } from 'vuetify'
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles';
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

//vue mask
import VueTheMask from 'vue-the-mask'

//notifications
import Toast, { POSITION } from "vue-toastification"
import "vue-toastification/dist/index.css"

//compoents 
import BtnPrimary from './Components/BtnPrimary.vue'
import BtnSecondary from './Components/BtnSecondary.vue'
import FormInput from './Components/FormInput.vue'
import Modal from './Components/Modal.vue'
import BtnBack from './Components/BtnBack.vue'

const mainTheme = {
    dark: false,
    colors: {
        primary: '#FFFF33',
        background: '#181818',
        surface: '#232323',
    }
}

const vuetify = createVuetify({ 
    components, 
    directives, 
    theme: {
        defaultTheme: "mainTheme",
        themes: { mainTheme }
    },
    icons: { defaultSet: 'mdi' },
    ssr: true,
});

const appName = 'Dafi Candle'

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue',)),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
        .use(plugin)
        .use(ZiggyVue, Ziggy)
        .use(vuetify)
        .use(VueTheMask)
        .use(Toast, { position: POSITION.BOTTOM_RIGHT })

        .component('Head', Head)
        .component('BtnPrimary', BtnPrimary)
        .component('BtnSecondary', BtnSecondary)
        .component('FormInput', FormInput)
        .component('Modal', Modal)
        .component('BtnBack', BtnBack)
        
        app.mount(el)

        return app
    },
    
    progress: false,
});
