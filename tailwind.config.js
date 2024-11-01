import defaultTheme from 'tailwindcss/defaultTheme'; // TailwindCSS now imports its theme by default

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './node_modules/flowbite/**/*.js',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                // sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                // sans: ['InterVariable', ...defaultTheme.fontFamily.sans],
                'body': [
                    'Inter',
                    'ui-sans-serif',
                    'system-ui',
                    '-apple-system',
                    'system-ui',
                    'Segoe UI',
                    'Roboto',
                    'Helvetica Neue',
                    'Arial',
                    'Noto Sans',
                    'sans-serif',
                    'Apple Color Emoji',
                    'Segoe UI Emoji',
                    'Segoe UI Symbol',
                    'Noto Color Emoji'
                  ],
                'sans': [
                    'Inter',
                    'ui-sans-serif',
                    'system-ui',
                    '-apple-system',
                    'system-ui',
                    'Segoe UI',
                    'Roboto',
                    'Helvetica Neue',
                    'Arial',
                    'Noto Sans',
                    'sans-serif',
                    'Apple Color Emoji',
                    'Segoe UI Emoji',
                    'Segoe UI Symbol',
                    'Noto Color Emoji'
                  ],
            },
            colors: {
                primary: {"50":"#eff6ff","100":"#dbeafe","200":"#bfdbfe","300":"#93c5fd","400":"#60a5fa","500":"#3b82f6","600":"#2563eb","700":"#1d4ed8","800":"#1e40af","900":"#1e3a8a","950":"#172554"}
            },
            animation: {
                wobble: 'wobble 2s ease infinite',
                bounce_right: 'bounce_right 1.5s linear infinite',
            },
            keyframes: {
                wobble: {
                    '0%' : {
                        transform: 'translateX(0%)'
                    },
                    '15%' : {
                        transform: 'translateX(-25%) rotate(-5deg)'
                    },
                    '30%' : {
                        transform: 'translateX(20%) rotate(3deg)'
                    },
                    '45%' : {
                        transform: 'translateX(-15%) rotate(-3deg)'
                    },
                    '60%' : {
                        transform: 'translateX(10%) rotate(2deg)'
                    },
                    '75%' : {
                        transform: 'translateX(-5%) rotate(-1deg)'
                    },
                    '100%' : {
                        transform: 'translateX(0%)'
                    },
                },
                bounce_right: {
                    '15%' : {
                        opacity: '140%',
                        transform: 'translateX(4px)',
                        animationTimingFunction: 'ease-in',
                    },
                    '65%' : {
                        transform: 'translateX(2px)',
                        animationTimingFunction: 'ease-in',
                    },
                    '85%' : {
                        transform: 'translateX(4px)',
                        animationTimingFunction: 'ease-in',
                    },
                    '45%, 75%' : {
                        transform: 'translateX(0)',
                        animationTimingFunction: 'ease-out',
                    },
                    '100%' : {
                        transform: 'translateX(0)',
                        animationTimingFunction: 'ease-out',
                        opacity: 1,
                    },
                },
            },
        },
    },
    plugins: [
        require('flowbite/plugin'),
        require('flowbite-typography'),
    ],
    safelist: [
        'bg-cyan-100',
        'bg-teal-100',
        'bg-amber-100',
        'bg-violet-100',
    ],
};
