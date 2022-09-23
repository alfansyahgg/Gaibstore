import resolveConfig from "tailwindcss/resolveConfig";
import tailwindConfig from "tailwindConfig";

export default {
    install: (app) => {
        app.provide("$theme", resolveConfig(tailwindConfig))
    }
}