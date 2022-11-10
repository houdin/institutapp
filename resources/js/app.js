import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp, Link, Head } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m.js";
import Layout from "@/Layouts/Layout.vue";

import Lang from "lang.js";
import { fr, enGB as en } from "date-fns/locale";
import { format, formatDistance, formatRelative, subDays } from "date-fns";

import filters from "./frontend/filters/vueFilters";

import modelsFilters from "./frontend/filters/modelsFilters";

const default_locale = window.default_locale;
const fallback_locale = window.fallback_locale;
const messages = window.messages;

const LANG = new Lang({
    messages,
    locale: default_locale,
    fallback: fallback_locale,
});
///// DATE ////////////
const DATE_FNS = {
    format,
    formatDistance,
    formatRelative,
    subDays,
};

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "FXinsitut";

//app.provide("$date", DATE_FNS);


//app.provide("trans", LANG);



createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const page = resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        );
        page.then((module) => {
            if(module.default.layout !== null){
                module.default.layout = module.default.layout || Layout;
            }
        });
        return page;
    },
    setup({ el, app, props, plugin }) {
        const VueApp = createApp({ render: () => h(app, props) });

        VueApp.config.globalProperties.$route = route;

        VueApp.config.globalProperties.$filters = filters;
        VueApp.config.globalProperties.$models = modelsFilters;
        VueApp.config.globalProperties.trans = LANG;
        VueApp.config.globalProperties.$locale = (lang = window.default_locale) => {
            const objLang = { fr, en };
            return objLang[lang];
        };
        VueApp.config.globalProperties.$date = DATE_FNS;

        VueApp.use(plugin)
            .use(ZiggyVue, Ziggy)
            .component("Link", Link)
            .component("Head", Head)
            .mount(el);
    },
});

InertiaProgress.init({
    // The delay after which the progress bar will
    // appear during navigation, in milliseconds.
    delay: 250,

    // The color of the progress bar.
    color: "#f59e0b",

    // Whether the NProgress spinner will be shown.
    showSpinner: true,
});
