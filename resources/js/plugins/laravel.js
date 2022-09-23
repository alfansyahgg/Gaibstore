export default {
    install: (app) => {
      	app.config.globalProperties.$env = import.meta.env;
		app.config.globalProperties.$route = window.route

      	app.provide('$route', window.route)
      	app.provide('$env', import.meta.env);
    }
}
