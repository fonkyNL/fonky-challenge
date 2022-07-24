const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
                primary: {
                    50: "#f4d0f1",
                    100: "#ebbaf6",
                    200: "#ae8ef8",
                    300: "#6376f5",
                    400: "#3f90ec",
                    500: "#24a1da",
                    600: "#1498be",
                    700: "#0d7698",
                    800: "#0a486d",
                    900: "#071e3d",
                }
            },
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
