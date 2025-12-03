const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    safelist: [
        'bg-yellow-500', 'hover:bg-yellow-600',
        'bg-red-500', 'hover:bg-red-600',
         'animate-blink',  'animate-blinkStep',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },

            // ➤ Tambahan animasi blinking
            keyframes: {
                blink: {
                    '0%, 100%': { opacity: '0' },
                    '50%': { opacity: '1' },
                },
                blinkStep: {
                    '0%, 50%': { visibility: 'hidden' },
                    '50.01%, 100%': { visibility: 'visible' },
                },
            },

            animation: {
                blink: 'blink 1s linear infinite',
                blinkStep: 'blinkStep 1s steps(1, start) infinite',
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
};
