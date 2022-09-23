import { Inertia } from "@inertiajs/inertia";

export default function (msg, url, method, params = null, options = null) {
    let statusMessage = window.$message.create(msg, {
        type: "loading",
        duration: 1000,
    });

    let mOptions = {};

    if (options != null) {
        mOptions = options;
    } else {
        mOptions = {
            onFinish: () => {
                statusMessage.destroy();
            },
            onSuccess: () => {
                statusMessage.destroy();
            },
            onError: (errors) => {
                for (const e in errors) {
                    window.$message.error(errors[e], {
                        duration: 2500,
                    });
                }
            },
        };
    }

    options = {
        ...mOptions,
    };

    switch (method) {
        case "DELETE":
        case "delete":
            options = {
                ...{
                    data: params,
                },
                ...options,
            };
            Inertia.delete(url, options);
            break;
        case "POST":
        case "post":
            params = { data: params };
            Inertia.post(url, params, options);
            break;
        case "PUT":
        case "put":
            params = { data: params };
            Inertia.put(url, params, options);
            break;
        case "GET":
        case "get":
            params = { data: params };
            Inertia.get(url, params, options);
            break;
        default:
            break;
    }
}
