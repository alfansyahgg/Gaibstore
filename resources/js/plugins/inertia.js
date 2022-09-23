import { Inertia } from "@inertiajs/inertia";
import { useForm, usePage } from "@inertiajs/inertia-vue3";

export default {
    install: (app) => {
      	app.config.globalProperties.$form = useForm;
		app.config.globalProperties.$visit = Inertia.visit;

		app.provide('$page', ref(usePage()));
      	app.provide('$form', useForm);
      	app.provide('$visit', Inertia.visit);
    }
}
