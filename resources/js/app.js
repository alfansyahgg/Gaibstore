import "./bootstrap";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { laravel, inertia, theme, images } from "@/plugins";
import store from "./stores/index.js";

InertiaProgress.init();

createInertiaApp({
    title: (title) => `${title} - Gaib Store`,
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob("./pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(laravel)
            .use(inertia)
            .use(theme)
            .use(images)
            .use(store)
            .mount(el);
    },
});
