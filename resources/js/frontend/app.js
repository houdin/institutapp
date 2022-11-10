/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

require("owl.carousel");

require("./plugins/chosen.jquery.min");
require("jquery-ui-dist/jquery-ui");
require("jarallax/dist/jarallax");
require("magnific-popup");
require("./plugins/jquery.flexslider");
require("./plugins/jquery.meanmenu.js");
require("scrollreveal/dist/scrollreveal");
require("waypoints/lib/jquery.waypoints");

import Alertifyjs from "alertifyjs/build/alertify";
window.alertify = Alertifyjs;

import Lang from "lang.js";

import mitt from "mitt";

import { format, formatDistance, formatRelative, subDays } from "date-fns";

import VueObserveVisibility from "vue-observe-visibility";

require("./script");

import animateCSS from "./animation";

// require('highlight.js/lib/core');

// import hljs from "highlight.js/lib/core";

// window.Vue = require("vue");
const Evn = mitt();
//window.Event = mitt();

window.Event.$on = window.Event.on = Evn.on;
window.Event.$emit = window.Event.emit = Evn.emit;

// import { provideAbility } from "@casl/vue";
// import ability from "@casl/ability";

// Vue.use(provideAbility, ability);

// Vue.component("carousel", carousel);

//Vue.mixin(require("./trans"));

// app.config.performance = true;

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

app.config.globalProperties.$date = DATE_FNS;
app.provide("$date", DATE_FNS);

import { fr, enGB as en } from "date-fns/locale";
app.config.globalProperties.$locale = (lang = window.default_locale) => {
    const objLang = { fr, en };
    return objLang[lang];
};

///////
app.config.globalProperties.trans = LANG;
app.provide("trans", LANG);

app.config.globalProperties.$laravel = window.Laravel;
app.provide("$laravel", window.Laravel);

import filters from "./filters/vueFilters";
app.config.globalProperties.$filters = filters;
app.provide("$filters", filters);

import modelsFilters from "./filters/modelsFilters";
app.config.globalProperties.$models = modelsFilters;
app.provide("$models", modelsFilters);

/// LODASH
app.config.globalProperties.$_ = _;

//////////////////////
/// COMPONENTS //////////////////////////

// const requireComponent = require.context(
//     "./components/",
//     true,
//     /^(?!.*(?:formations)).*\.vue$/
// );

import VueSweetalert2 from "vue-sweetalert2";

const optionsSweet = {
    confirmButtonColor: "#41b882",
    cancelButtonColor: "#ff7674",
};
app.use(VueSweetalert2, optionsSweet);
//////////////////////

app.use(VueObserveVisibility);

// app.use(VueDateFns);

// app.component("ValidationProvider", ValidationProvider);
// app.component("ValidationObserver", ValidationObserver);

router.afterEach((to, from) => {
    if (to.name !== "home") {
        $(function () {
            // $(
            //     "section:not(.footer-area-section, .breadcrumb-section)"
            // ).addClass("_section_page_");
        });
    }

    filters.Utility.segments();
});

// router.beforeEach((to, from, next) => {
//     if (to.name !== "Login" && !isAuthenticated) next({ name: "Login" });
//     else next();
// });

app.directive("focus", {
    mounted(el) {
        el.focus();
    },
    updated(el) {
        el.focus();
    },
});
app.directive("click-outside", {
    beforeMount(el, binding, vnode) {
        // assign event to the element
        el.clickOutsideEvent = function (event) {
            const nav = document.querySelector("#nav");
            // here we check if the click event is outside the element and it's children
            if (
                !(
                    el == event.target ||
                    el.contains(event.target) ||
                    nav.contains(event.target)
                )
            ) {
                // if clicked outside, call the provided method
                binding.value.bind(vnode.context)(event);
                // vnode.context[binding.value](event);
            }
        };

        // register click and touch events
        // if (
        //     !document
        //         .querySelector("#search-wrapper")
        //         .classList.contains("search--hidden")
        // ) {
        document.body.addEventListener("click", (event) => {
            el.clickOutsideEvent(event);
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
});
