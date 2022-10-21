import { defineConfig } from "vite";
import fs from "fs";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import Components from "unplugin-vue-components/vite";
import AutoImport from "unplugin-auto-import/vite";
import Icons from "unplugin-icons/vite";
import IconsResolver from "unplugin-icons/resolver";

const host = "fxinstitut.test";

export default defineConfig({
    plugins: [
        laravel({
            input: "resources/js/app.ts",
            ssr: "resources/js/ssr.ts",
            valetTls: host,
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
            dirs: ["resources/js"],
            dts: "./resources/js/components.d.ts",
            types: [
                {
                    from: "@inertiajs/inertia-vue3",
                    names: ["Link"],
                },
            ],
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
                    // "@inertiajs/inertia-vue3": [
                    //     // named imports
                    //     "Link", // import { useMouse } from '@vueuse/core',
                    // ],
                    axios: [
                        // default imports
                        ["default", "axios"], // import { default as axios } from 'axios',
                    ],
                },
            ],
            dts: "./resources/js/auto-imports.d.ts",
        }),
    ],
    ssr: {
        noExternal: ["laravel-vite-plugin", "@inertiajs/server"],
    },
    server: {
        host,
        hmr: { host },
        https: {
            key: fs.readFileSync(
                `/Users/houdini/.config/valet/Certificates/${host}.key`
            ),
            cert: fs.readFileSync(
                `/Users/houdini/.config/valet/Certificates/${host}.crt`
            ),
        },
    },
});
