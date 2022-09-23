export default {
    install: (app) => {
        app.config.globalProperties.$images = new URL(`../../images/`, import.meta.url).href;

        app.provide(
            "$images",
            new URL(`../../images/`, import.meta.url).href
        );
    },
};
