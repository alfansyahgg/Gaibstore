import { resolve } from "path";
import { defineConfig } from "vite";
import Laravel from "laravel-vite-plugin";
import Vue from "@vitejs/plugin-vue";
import Components from "unplugin-vue-components/vite";
import { NaiveUiResolver } from "unplugin-vue-components/resolvers";
import Eslint from "vite-plugin-eslint";
import Icons from "unplugin-icons/vite";
import IconsResolver from "unplugin-icons/resolver";
import AutoImport from "unplugin-auto-import/vite";
import { hash } from "./resources/js/helpers/functions";
export default defineConfig({
    server: {
        hmr: {
            host: "localhost",
        },
    },
    plugins: [
        Laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: [
                "app/View/Components/**",
                "routes/**",
                resolve(`${__dirname}/resources/**`),
            ],
        }),

        Vue({
            template: {
                transformAssetUrls: {
                    // The Vue plugin will re-write asset URLs, when referenced
                    // in Single File Components, to point to the Laravel web
                    // server. Setting this to `null` allows the Laravel plugin
                    // to instead re-write asset URLs to point to the Vite
                    // server instead.
                    base: null,

                    // The Vue plugin will parse absolute URLs and treat them
                    // as absolute paths to files on disk. Setting this to
                    // `false` will leave absolute URLs un-touched so they can
                    // reference assets in the public directly as expected.
                    includeAbsolute: false,
                },
            },
        }),

        Components({
            dirs: [resolve(`${__dirname}/resources/js/components`)],
            extensions: ["vue"],
            deep: true,
            directoryAsNamespace: true,
            dts: resolve(`${__dirname}/resources/js/components.d.ts`),
            resolvers: [
                // Naive UI
                NaiveUiResolver(),
                // Icons
                IconsResolver({
                    prefix: false,
                    enabledCollections: ["mdi"],
                }),
            ],
        }),

        AutoImport({
            imports: ["vue", "vue/macros"],
            dts: resolve(`${__dirname}/resources/js/helpers.d.ts`),
            dirs: [resolve(`${__dirname}/resources/js/helpers`)],
            vueTemplate: true,
            eslintrc: {
                enabled: true,
            },
        }),
    ],

    resolve: {
        alias: {
            "@": resolve(`${__dirname}/resources/js`),
            "@css": resolve(`${__dirname}/resources/css`),
            "@images": resolve(`${__dirname}/resources/images`),
            "@markdown": resolve(`${__dirname}/resources/markdown`),
            tailwindConfig: resolve(`${__dirname}/tailwind.config.js`),
        },
    },

    optimizeDeps: {
        include: ["tailwindConfig"],
    },

    build: {
        commonjsOptions: {
            transformMixedEsModules: true,
        },
        rollupOptions: {
            output: {
                entryFileNames: `[name]` + hash + `.js`,
                chunkFileNames: `[name]` + hash + `.js`,
                assetFileNames: `[name]` + hash + `.[ext]`,
            },
        },
    },
});
