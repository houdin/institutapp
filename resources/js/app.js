import "./bootstrap";
import "v-calendar/dist/style.css";
import "../css/app.css";

import { createApp, h, ref } from "vue";
import { createInertiaApp, Link, Head } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m.js";
import Layout from "@/Layouts/Layout.vue";

import { DatePicker } from "v-calendar";

import Lang from "lang.js";
import { fr, enGB as en } from "date-fns/locale";
import { format, formatDistance, formatRelative, subDays } from "date-fns";

import filters from "@/Helpers/vueFilters";

import modelsFilters from "@/Helpers/modelsFilters";

window.routeBack = false;
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
            if (module.default.layout !== null) {
                module.default.layout = module.default.layout || Layout;
            }
        });
        return page;
    },
    setup({ el, app, props, plugin }) {
        const LANG = new Lang({
            messages: props.initialPage.props.lang,
            locale: "fr",
            fallback: "en",
        });
        const VueApp = createApp({ render: () => h(app, props) });

        VueApp.config.globalProperties.$route = route;

        VueApp.directive("click-outside", clickOut());

        const $routeBack = ref(false);
        VueApp.config.globalProperties.$routeBack = $routeBack;
        VueApp.directive("route-back", routeBack());
        VueApp.provide("$routeBack", $routeBack);

        VueApp.config.globalProperties.$helpers = filters;
        VueApp.config.globalProperties.$models = modelsFilters;
        VueApp.config.globalProperties.trans = LANG;
        VueApp.config.globalProperties.$locale = (
            lang = window.default_locale
        ) => {
            const objLang = { fr, en };
            return objLang[lang];
        };
        VueApp.config.globalProperties.$date = DATE_FNS;

        VueApp.use(plugin)
            .use(ZiggyVue, Ziggy)
            .component("Link", Link)
            .component("Head", Head)
            .component("DatePicker", DatePicker)
            .mount(el);
    },
});

InertiaProgress.init({
    // The delay after which the progress bar will
    // appear during navigation, in milliseconds.
    delay: 250,

    // The color of the progress bar.
    color: "#ffc565",

    // Whether the NProgress spinner will be shown.
    showSpinner: false,
});

function clickOut() {
    return {
        beforeMount(el, binding, vnode) {
            // assign event to the element
            el.clickOutsideEvent = function (event) {
                const header = document.querySelector("#header");
                const modal = document.querySelector("#modal");
                // here we check if the click event is outside the element and it's children
                if (
                    !(
                        el == event.target ||
                        el.contains(event.target) ||
                        header.contains(event.target) ||
                        modal.contains(event.target)
                    )
                ) {
                    // if clicked outside, call the provided method
                    binding.value.bind(vnode.context)(event);
                }
            };
            document.body.addEventListener("click", (event) => {
                if (document.body.classList.contains("modal-open")) {
                    el.clickOutsideEvent(event);
                }
            });
            // document.body.addEventListener("touchstart", el.clickOutsideEvent);
            // }
        },
        unmounted(el) {
            // unregister click and touch events before the element is unmounted
            document.body.removeEventListener("click", (event) => {
                el.clickOutsideEvent(event);
            });
            // document.body.removeEventListener("touchstart", el.clickOutsideEvent);
        },
        stopProp() {
            Event.stopPropagation();
        },
    };
}

function can() {
    return {
        beforeMount(el, binding, vnode) {
            // var permissions = store.state.permissions;
            // if (permissions.includes(binding.value)) {
            //     return (vnode.el.hidden = false);
            // } else {
            //     return (vnode.el.hidden = true);
            // }
        },
    };
}
function routeBack() {
    return {
        beforeMount(el, binding, vnode) {
            el.addEventListener("click", (event) => {
                console.log("//// CLICK ROUTE BACK");
                vnode.ctx.provides.routeBack.value = true;
            });
        },
        unmounted(el) {
            // unregister click and touch events before the element is unmounted
            el.removeEventListener("click", (event) => {
                el.routeBackEvent(event);
            });
            // document.body.removeEventListener("touchstart", el.clickOutsideEvent);
        },
        stopProp() {
            Event.stopPropagation();
        },
    };
}

function addClassHover() {
    return {
        mounted(el, binding, vnode) {
            const { value = "" } = binding;
            el.addEventListener("mouseenter", () => {
                el.classList.add(value);
            });
            el.addEventListener("mouseleave", () => {
                el.classList.remove(value);
            });
        },
    };
    // Vue.directive("add-class-hover", {
    //     bind(el, binding, vnode) {
    //         const { value = "" } = binding;
    //         el.addEventListener("mouseenter", () => {
    //             el.classList.add(value);
    //         });
    //         el.addEventListener("mouseleave", () => {
    //             el.classList.remove(value);
    //         });
    //     },
    //     unbind(el, binding, vnode) {
    //         el.removeEventListener("mouseenter");
    //         el.removeEventListener("mouseleave");
    //     },
    // });
}
// <h1 v-add-class-hover="'hoverClass'">Text</h1>;
