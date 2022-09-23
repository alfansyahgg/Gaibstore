/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./resources/views/**/*.blade.php", "./resources/js/**/*.vue"],
    theme: {
        extend: {
            fontFamily: {
                poppins: "Poppins",
                roboto: "Roboto",
                montserrat: "Montserrat",
            },
            colors: {
                primary: {
                    50: "#7ee182",
                    100: "#74d778",
                    200: "#6acd6e",
                    300: "#60c364",
                    400: "#56b95a",
                    500: "#4caf50",
                    600: "#42a546",
                    700: "#389b3c",
                    800: "#2e9132",
                    900: "#248728",
                },
                carousel: {
                    DEFAULT: "#efefef",
                },
            },
        },
    },
    plugins: [],
};
