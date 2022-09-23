module.exports = {
    root: true,
    env: {
        browser: true,
        node: true,
        es6: true,
    },
	parser: 'vue-eslint-parser',
    parserOptions: {
        ecmaVersion: 'latest',
        sourceType: 'module',
		vueFeatures: {
            filter: true,
            interpolationAsNonHTML: true,
            styleCSSVariableInjection: true,
        }
    },
    extends: [
        'eslint:recommended',
        'plugin:vue/vue3-recommended',
		'./.eslintrc-auto-import.json',
        "prettier",
    ],
    rules: {
        "vue/multi-word-component-names": "off",
        "vue/script-setup-uses-vars": "error",
    }
}
