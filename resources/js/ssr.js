import { createSSRApp, h } from "vue";
import { renderToString } from "@vue/server-renderer";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import createServer from "@inertiajs/server";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import Layout from "@/Layouts/Layout.vue";

import filters from "./frontend/filters/vueFilters";

import modelsFilters from "./frontend/filters/modelsFilters";


const appName = "FXinstitut";

createServer((page) =>
    createInertiaApp({
        page,
        render: renderToString,
        title: (title) => `${title} - ${appName}`,
        resolve: (name) =>{
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
        setup({ app, props, plugin }) {


        const VueApp = createSSRApp({ render: () => h(app, props) });

        VueApp.config.globalProperties.$route = route
        VueApp.config.globalProperties.$filters = filters;
        VueApp.config.globalProperties.$models = modelsFilters;

        VueApp.use(plugin)
            .component("Link", Link)
            .component("Head", Head)
            .use(ZiggyVue, {
                    ...page.props.ziggy,
                    location: new URL(page.props.ziggy.location),
                });

        },
    })
);
