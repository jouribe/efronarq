const defaultTheme = require('tailwindcss/defaultTheme')
const colors = require('tailwindcss/colors')
const efron = {
    'colors': {
        'blue': {
            '50': '#3e8dbd',
            '100': '#3483b3',
            '200': '#2a79a9',
            '300': '#206f9f',
            '400': '#166595',
            '500': '#0c5b8b',
            '600': '#025181',
            '700': '#004777',
            '800': '#003d6d',
            '900': '#003363',
        },
    },
}

module.exports = {
    purge: [
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        colors: {
            white: colors.white,
            yellow: colors.yellow,
            gray: colors.blueGray,
            blue: efron.colors.blue,
            red: colors.red,
            indigo: colors.indigo,
            green: colors.green,
            black: colors.black,
        },
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
}
