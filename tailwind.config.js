import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                display: ['"Plus Jakarta Sans"', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: {
                'mesh-radial':
                    'radial-gradient(ellipse 80% 50% at 50% -20%, rgba(16, 185, 129, 0.15), transparent), radial-gradient(ellipse 50% 40% at 100% 0%, rgba(14, 116, 144, 0.12), transparent)',
            },
            colors: {
                irdc: {
                    green: '#14532d',
                    'green-light': '#166534',
                    cream: '#fef9e7',
                },
                'irdc-burgundy': '#3d2319',
            },
        },
    },

    plugins: [forms],
};
