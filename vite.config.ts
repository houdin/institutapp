import { defineConfig } from "vite";
import fs from "fs";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import Components from "unplugin-vue-components/vite";
import AutoImport from "unplugin-auto-import/vite";
import Icons from "unplugin-icons/vite";
import IconsResolver from "unplugin-icons/resolver";
const path = require("path");

const host = "fxinstitut.test";

export default defineConfig({
    plugins: [
        laravel({
            input: "resources/js/app.js",
            ssr: "resources/js/ssr.js",
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        Components({
            // allow auto load markdown components under `./src/components/`
            extensions: ["vue", "md"],

            // allow auto import and register components used in markdown
            include: [/\.vue$/, /\.vue\?vue/, /\.md$/],
            dirs: [
                "resources/js/Components",
                "resources/js/Shared",
                "resources/js/Layouts",
                "resources/js/Pages",
            ],
            dts: "./resources/js/components.d.ts",

            // custom resolvers
            resolvers: [
                // auto import icons
                // https://github.com/antfu/unplugin-icons
                IconsResolver({
                    componentPrefix: "",
                    // enabledCollections: ['carbon']
                }),
            ],
        }),
        // https://github.com/antfu/unplugin-icons
        Icons({
            autoInstall: true,
        }),
        // https://github.com/antfu/unplugin-auto-import
        AutoImport({
            imports: [
                "vue",
                // "vue-router",
                // "vue-i18n",
                "@vueuse/head",
                "@vueuse/core",
                {
                    "@inertiajs/inertia-vue3": [
                        "usePage","useForm"
                    ],
                    "@inertiajs/inertia": [
                        "Inertia",
                    ],
                    axios: [
                        // default imports
                        ["default", "axios"], // import { default as axios } from 'axios',
                    ],
                },
            ],
            dts: "./resources/js/auto-imports.d.ts",
        }),
    ],
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "./resources/js"),
        },
    },
    ssr: {
        noExternal: ["laravel-vite-plugin", "@inertiajs/server"],
    },
    server: {
        host,
        hmr: { host },

    },
});

