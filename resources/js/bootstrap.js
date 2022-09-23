import _ from "lodash";
window._ = _;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
// window.axios.defaults.headers.common["Access-Control-Allow-Origin"] = "*";
// window.axios.defaults.headers.common["Content-Type"] = "application/json";
// window.axios.defaults.headers.common["Access-Control-Allow-Credentials"] = true;

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });

// Naive UI
// About Tailwind's Preflight Style Override
// You may find adding a meta tag to your static html files doesn't work (naive's style would still be overriden), since your toolchain may always insert tailwind's style at the end of the head tag. In this situation, you need to insert the meta tag dynamically right before the app is mounted.
document.head.appendChild(createElement("meta", { name: "naive-ui-style" }));
document.head.appendChild(createElement("meta", { name: "vueuc-style" }));
// document.body.appendChild(
//     createElement("script", {
//         src: "https://app.sandbox.midtrans.com/snap/snap.js",
//         dataClientKey: "SB-Mid-client-RN-YUnJ46LDBImxv",
//     })
// );

function createElement(tag, attributes = {}) {
    const element = document.createElement(tag);
    for (let attribute in attributes) {
        element.setAttribute(attribute, attributes[attribute]);
    }

    return element;
}
