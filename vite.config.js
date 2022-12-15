import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import fs from "fs";
import Components from "unplugin-vue-components/vite";
import AutoImport from "unplugin-auto-import/vite";
import Icons from "unplugin-icons/vite";
import IconsResolver from "unplugin-icons/resolver";

import { homedir } from "os";
import { resolve } from "path";

const host = "fxinstitut.test";

export default defineConfig({
    define: {
        global: {},
    },
    plugins: [
        laravel({
            input: [
                "resources/js/app.js",
                "resources/js/backend/app_backend.js",
            ],
            // ssr: "resources/js/ssr.js",
            valetTls: true,
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
                "resources/js/Jetstream",
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
                    "@inertiajs/inertia-vue3": ["usePage", "useForm"],
                    "@inertiajs/inertia": ["Inertia"],
                    axios: [
                        // default imports
                        ["default", "axios"], // import { default as axios } from 'axios',
                    ],
                    "@/Helpers/indexFilters": [["default", "Helpers"]],
                },
            ],
            dts: "./resources/js/auto-imports.d.ts",
        }),
    ],
    resolve: {
        alias: {
            "@": resolve(__dirname, "./resources/js"),
        },
    },
    // ssr: {
    //     noExternal: ["laravel-vite-plugin", "@inertiajs/server"],
    // },
    server: detectServerConfig(host),
});

function detectServerConfig(host) {
    let keyPath = resolve(homedir(), `.config/valet/Certificates/${host}.key`);
    let certificatePath = resolve(
        homedir(),
        `.config/valet/Certificates/${host}.crt`
    );

    if (!fs.existsSync(keyPath)) {
        return {};
    }

    if (!fs.existsSync(certificatePath)) {
        return {};
    }

    return {
        hmr: { host },
        host,
        https: {
            key: fs.readFileSync(keyPath),
            cert: fs.readFileSync(certificatePath),
        },
    };
}
