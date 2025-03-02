import defaultTheme from 'tailwindcss/defaultTheme'; // TailwindCSS now imports its theme by default
import colors from 'tailwindcss/colors';

const plugin = require('tailwindcss/plugin') // Import TailwindCSS plugin

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
                  satoshi: ['Satoshi', 'sans-serif'],
            },
            screens: {
                '2xsm': '375px',
                xsm: '425px',
                '3xl': '2000px',
                '1l': '1024px',
                ...defaultTheme.screens,
            },
            colors: {
                primary: {
                    "50":"#eff6ff",
                    "100":"#dbeafe",
                    "200":"#bfdbfe",
                    "300":"#93c5fd",
                    "400":"#60a5fa",
                    "500":"#3b82f6",
                    "600":"#2563eb",
                    "700":"#1d4ed8",
                    "800":"#1e40af",
                    "900":"#1e3a8a",
                    "950":"#172554"
                },
                current: 'currentColor',
                transparent: 'transparent',
                white: '#FFFFFF',
                black: {
                  ...colors.black,
                  DEFAULT: '#1C2434',
                  2: '#010101',
                },
                red: {
                  ...colors.red,
                  DEFAULT: '#FB5454',
                },
                body: '#64748B',
                bodydark: '#AEB7C0',
                bodydark1: '#DEE4EE',
                bodydark2: '#8A99AF',
                // primary: '#3C50E0',
                secondary: '#80CAEE',
                stroke: '#E2E8F0',
                gray: {
                  ...colors.gray,
                  DEFAULT: '#EFF4FB',
                  2: '#F7F9FC',
                  3: '#FAFAFA',
                },
                graydark: '#333A48',
                whiten: '#F1F5F9',
                whiter: '#F5F7FD',
                boxdark: '#24303F',
                'boxdark-2': '#1A222C',
                strokedark: '#2E3A47',
                'form-strokedark': '#3d4d60',
                'form-input': '#1d2a39',
                meta: {
                  1: '#DC3545',
                  2: '#EFF2F7',
                  3: '#10B981',
                  4: '#313D4A',
                  5: '#259AE6',
                  6: '#FFBA00',
                  7: '#FF6766',
                  8: '#F0950C',
                  9: '#E5E7EB',
                  10: '#0FADCF',
                },
                success: '#219653',
                danger: '#D34053',
                warning: '#FFA70B',
            },
            fontSize: {
                'title-xxl': ['44px', '55px'],
                'title-xl': ['36px', '45px'],
                'title-xl2': ['33px', '45px'],
                'title-lg': ['28px', '35px'],
                'title-md': ['24px', '30px'],
                'title-md2': ['26px', '30px'],
                'title-sm': ['20px', '26px'],
                'title-xsm': ['18px', '24px'],
              },
            spacing: {
                4.5: '1.125rem',
                5.5: '1.375rem',
                6.5: '1.625rem',
                7.5: '1.875rem',
                8.5: '2.125rem',
                9.5: '2.375rem',
                10.5: '2.625rem',
                11: '2.75rem',
                11.5: '2.875rem',
                12.5: '3.125rem',
                13: '3.25rem',
                13.5: '3.375rem',
                14: '3.5rem',
                14.5: '3.625rem',
                15: '3.75rem',
                15.5: '3.875rem',
                16: '4rem',
                16.5: '4.125rem',
                17: '4.25rem',
                17.5: '4.375rem',
                18: '4.5rem',
                18.5: '4.625rem',
                19: '4.75rem',
                19.5: '4.875rem',
                21: '5.25rem',
                21.5: '5.375rem',
                22: '5.5rem',
                22.5: '5.625rem',
                24.5: '6.125rem',
                25: '6.25rem',
                25.5: '6.375rem',
                26: '6.5rem',
                27: '6.75rem',
                27.5: '6.875rem',
                29: '7.25rem',
                29.5: '7.375rem',
                30: '7.5rem',
                31: '7.75rem',
                32.5: '8.125rem',
                34: '8.5rem',
                34.5: '8.625rem',
                35: '8.75rem',
                36.5: '9.125rem',
                37.5: '9.375rem',
                39: '9.75rem',
                39.5: '9.875rem',
                40: '10rem',
                42.5: '10.625rem',
                44: '11rem',
                45: '11.25rem',
                46: '11.5rem',
                47.5: '11.875rem',
                49: '12.25rem',
                50: '12.5rem',
                52: '13rem',
                52.5: '13.125rem',
                54: '13.5rem',
                54.5: '13.625rem',
                55: '13.75rem',
                55.5: '13.875rem',
                59: '14.75rem',
                60: '15rem',
                62.5: '15.625rem',
                65: '16.25rem',
                67: '16.75rem',
                67.5: '16.875rem',
                70: '17.5rem',
                72.5: '18.125rem',
                73: '18.25rem',
                75: '18.75rem',
                90: '22.5rem',
                94: '23.5rem',
                95: '23.75rem',
                100: '25rem',
                115: '28.75rem',
                125: '31.25rem',
                132.5: '33.125rem',
                150: '37.5rem',
                171.5: '42.875rem',
                180: '45rem',
                187.5: '46.875rem',
                203: '50.75rem',
                230: '57.5rem',
                242.5: '60.625rem',
            },
            maxWidth: {
                2.5: '0.625rem',
                3: '0.75rem',
                4: '1rem',
                11: '2.75rem',
                13: '3.25rem',
                14: '3.5rem',
                15: '3.75rem',
                22.5: '5.625rem',
                25: '6.25rem',
                30: '7.5rem',
                34: '8.5rem',
                35: '8.75rem',
                40: '10rem',
                42.5: '10.625rem',
                44: '11rem',
                45: '11.25rem',
                60: '15rem',
                70: '17.5rem',
                90: '22.5rem',
                94: '23.5rem',
                125: '31.25rem',
                132.5: '33.125rem',
                142.5: '35.625rem',
                150: '37.5rem',
                180: '45rem',
                203: '50.75rem',
                230: '57.5rem',
                242.5: '60.625rem',
                270: '67.5rem',
                280: '70rem',
                292.5: '73.125rem',
            },
            maxHeight: {
                35: '8.75rem',
                70: '17.5rem',
                90: '22.5rem',
                550: '34.375rem',
                300: '18.75rem',
            },
            minWidth: {
                22.5: '5.625rem',
                42.5: '10.625rem',
                47.5: '11.875rem',
                75: '18.75rem',
            },
            width: {
                '85': '21.25rem',
                'customWidth1': 'calc(100% - 0.6em)',
            },
            zIndex: {
                999999: '999999',
                99999: '99999',
                9999: '9999',
                999: '999',
                99: '99',
                9: '9',
                1: '1',
            },
            opacity: {
                65: '.65',
              },
            transitionProperty: { width: 'width', stroke: 'stroke' },
            borderWidth: {
                6: '6px',
            },
            boxShadow: {
                default: '0px 8px 13px -3px rgba(0, 0, 0, 0.07)',
                card: '0px 1px 3px rgba(0, 0, 0, 0.12)',
                'card-2': '0px 1px 2px rgba(0, 0, 0, 0.05)',
                switcher:
                  '0px 2px 4px rgba(0, 0, 0, 0.2), inset 0px 2px 2px #FFFFFF, inset 0px -1px 1px rgba(0, 0, 0, 0.1)',
                'switch-1': '0px 0px 5px rgba(0, 0, 0, 0.15)',
                1: '0px 1px 3px rgba(0, 0, 0, 0.08)',
                2: '0px 1px 4px rgba(0, 0, 0, 0.12)',
                3: '0px 1px 5px rgba(0, 0, 0, 0.14)',
                4: '0px 4px 10px rgba(0, 0, 0, 0.12)',
                5: '0px 1px 1px rgba(0, 0, 0, 0.15)',
                6: '0px 3px 15px rgba(0, 0, 0, 0.1)',
                7: '-5px 0 0 #313D4A, 5px 0 0 #313D4A',
                8: '1px 0 0 #313D4A, -1px 0 0 #313D4A, 0 1px 0 #313D4A, 0 -1px 0 #313D4A, 0 3px 13px rgb(0 0 0 / 8%)',
            },
            dropShadow: {
                1: '0px 1px 0px #E2E8F0',
                2: '0px 1px 4px rgba(0, 0, 0, 0.12)',
            },
            animation: {
                wobble: 'wobble 2s ease infinite',
                bounce_right: 'bounce_right 1.5s linear infinite',
                linspin: 'linspin 1568.2353ms linear infinite',
                easespin: 'easespin 5332ms cubic-bezier(0.4, 0, 0.2, 1) infinite both',
                'left-spin':
                  'left-spin 1333ms cubic-bezier(0.4, 0, 0.2, 1) infinite both',
                'right-spin':
                  'right-spin 1333ms cubic-bezier(0.4, 0, 0.2, 1) infinite both',
                'ping-once': 'ping 5s cubic-bezier(0, 0, 0.2, 1)',
                rotating: 'rotating 30s linear infinite',
                topbottom: 'topbottom 60s infinite alternate linear',
                bottomtop: 'bottomtop 60s infinite alternate linear',
                'spin-1.5': 'spin 1.5s linear infinite',
                'spin-2': 'spin 2s linear infinite',
                'spin-3': 'spin 3s linear infinite',
                sway: 'sway 1s linear infinite',
                spin: 'spin 1.5s linear infinite',
                gentle_tilt: 'tilt_shaking 0.5s infinite',

                // Confetti for Like Button
                confetti_cone: 'confetti_cone1 0.75s ease infinite',
                confdash: 'confdash 0.75s ease infinite',
                a1: 'confa 0.75s ease-out infinite',
                a2: 'confa 0.75s ease-out infinite',
            
                b1: 'confb 0.75s ease-out infinite',
                b2: 'confb 0.75s ease-out infinite',
                b3: 'confb 0.75s ease-out infinite',
                b4: 'confb 0.75s ease-out infinite',
                b5: 'confb 0.75s ease-out infinite',
            
                c1: 'confc 0.75s ease-out infinite',
                c2: 'confc 0.75s ease-out infinite',
                c3: 'confc 0.75s ease-out infinite',
                c4: 'confc 0.75s ease-out infinite',
            
                d1: 'confd 0.75s ease-out infinite',
                d2: 'confd 0.75s ease-out infinite',
                d3: 'confd 0.75s ease-out infinite',

                // Loading Spinner Grow
                blink: 'blink 1s linear infinite, custom_bounce 0.8s linear infinite',
                custom_bounce: 'custom_bounce 1s infinite',
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
                    '0%, 20%, 50%, 80%, 100%' : {
                      transform: 'translateX(0)',
                    },
                    '40%' : {
                      transform: 'translateX(-6px)',
                    },
                    '60%' : {
                      transform: 'translateX(-3px)',
                    }
                },
                linspin: {
                    '100%': { transform: 'rotate(360deg)' },
                },
                easespin: {
                    '12.5%': { transform: 'rotate(135deg)' },
                    '25%': { transform: 'rotate(270deg)' },
                    '37.5%': { transform: 'rotate(405deg)' },
                    '50%': { transform: 'rotate(540deg)' },
                    '62.5%': { transform: 'rotate(675deg)' },
                    '75%': { transform: 'rotate(810deg)' },
                    '87.5%': { transform: 'rotate(945deg)' },
                    '100%': { transform: 'rotate(1080deg)' },
                },
                'left-spin': {
                    '0%': { transform: 'rotate(130deg)' },
                    '50%': { transform: 'rotate(-5deg)' },
                    '100%': { transform: 'rotate(130deg)' },
                },
                'right-spin': {
                    '0%': { transform: 'rotate(-130deg)' },
                    '50%': { transform: 'rotate(5deg)' },
                    '100%': { transform: 'rotate(-130deg)' },
                },
                rotating: {
                    '0%, 100%': { transform: 'rotate(360deg)' },
                    '50%': { transform: 'rotate(0deg)' },
                },
                topbottom: {
                    '0%, 100%': { transform: 'translate3d(0, -100%, 0)' },
                    '50%': { transform: 'translate3d(0, 0, 0)' },
                },
                bottomtop: {
                    '0%, 100%': { transform: 'translate3d(0, 0, 0)' },
                    '50%': { transform: 'translate3d(0, -100%, 0)' },
                },
                sway:  {
                    '0%': { transform: 'rotate(8deg)' },
                    '50%': { transform: 'rotate(-8deg)' },
                    '100%': { transform: 'rotate(8deg)' },
                },
                spin: {
                    '0%': { transform: 'rotate(0deg)' },
                    '100%': { transform: 'rotate(360deg)' },
                },
                tilt_shaking: {
                    '0%': { transform: 'rotate(0deg)' },
                    '25%': { transform: 'rotate(5deg)' },
                    '50%': { transform: 'rotate(0eg)' },
                    '75%': { transform: 'rotate(-5deg)' },
                    '100%': { transform: 'rotate(0deg)' },
                },
                //---------------------
                // Confetti Keyframes
                // --------------------
                confetti_cone1: {
                    '0%': { transform: 'translate(40px, 40px) rotate(45deg) scale(1, 1)' },
                    '15%': { transform: 'translate(10px, 90px) rotate(45deg) scale(1.1, 0.85)' },
                    '100%': { transform: 'translate(40px, 50px) rotate(45deg) scale(1, 1)' },
                },
                confa: {
                    '0%': {
                      opacity: '0',
                      transform: 'translate(-30px, -20px) rotate(0)',
                    },
                    '15%': {
                      opacity: '1',
                      transform: 'translate(25px, -30px) rotate(60deg)',
                    },
                    '80%': {
                      opacity: '1',
                      transform: 'translate(33px, -38px) rotate(180deg)',
                    },
                    '100%': {
                      opacity: '0',
                      transform: 'translate(37px, -46px) scale(0.5)rotate(230deg)',
                    },
                },
                confb: {
                    '0%': {
                      opacity: '0',
                      transform: 'translate(-30px, -20px) rotate(0)',
                    },
                    '12%': {
                      opacity: '1',
                      transform: 'translate(25px, -30px) rotate(60deg)',
                    },
                    '76%': {
                      opacity: '1',
                      transform: 'translate(33px, -38px) rotate(180deg)',
                    },
                    '100%': {
                      opacity: '0',
                      transform: 'translate(37px, -46px) scale(0.5) rotate(240deg)',
                    },
                },
                confc: {
                    '0%': {
                      opacity: '0.7',
                      transform: 'translate(-30px, -20px) rotate(0)',
                    },
                    '18%': {
                      opacity: '1',
                      transform: 'translate(5px, -30px) rotate(60deg)',
                    },
                    '76%': {
                      opacity: '1',
                      transform: 'translate(13px, -38px) rotate(180deg)',
                    },
                    '100%': {
                      opacity: '0',
                      transform: 'translate(17px, -46px) scale(0.5) rotate(230deg)',
                    },
                },
                confd: {
                    '0%': {
                      opacity: '0.7',
                      transform: 'translate(-20px, -20px) rotate(0)',
                    },
                    '18%': {
                      opacity: '1',
                      transform: 'translate(-5px, -30px) rotate(60deg)',
                    },
                    '76%': {
                      opacity: '1',
                      transform: 'translate(-8px, -38px) rotate(180deg)',
                    },
                    '100%': {
                      opacity: '0',
                      transform: 'translate(-10px, -46px) scale(0.5) rotate(230deg)',
                    },
                },
                //---------------------
                // Loading Blink Keyframes
                // --------------------
                blink: { '50%': { opacity: '0' } },
                custom_bounce: {
                  '0%, 100%': {
                      transform: 'none',
                      animationTimingFunction: 'cubic-bezier(0.8,0,1,1)',
                  },
                  '50%': {
                      transform: 'translateY(-75%)',
                      animationTimingFunction: 'cubic-bezier(0,0,0.2,1)',
                  },
              },
            },
            aspectRatio: {
                '16/9': '16 / 9',
                '4/3': '4 / 3',
            },
            content: {
              'downwardArrowIcon': 'url("/public/storage/IMG/core/arrow-down-svgrepo-com.svg")',
            },
        },
    },
    plugins: [
        require('flowbite/plugin'),
        require('flowbite-typography'),
        plugin(function({ matchUtilities, theme }) {
          matchUtilities(
            {
              "animation-delay": (value) => {
                return {
                  "animation-delay": value,
                };
              },
            },
            {
              values: theme("transitionDelay"),
            }
          );
        }),
    ],
    safelist: [
        // ------------------
        // Background Colors
        // ------------------
        'bg-cyan-100',
        'bg-teal-100',
        'bg-amber-100',
        'bg-violet-100',
        'bg-red-100',
        'bg-red-200',
        'bg-green-200',
        'bg-orange-200',
        'bg-blue-200',
        'bg-slate-200',
        'bg-gray-200',
        'bg-zinc-200',
        'bg-neutral-200',
        'bg-stone-200',
        'bg-amber-200',
        'bg-yellow-200',
        'bg-lime-200',
        'bg-emerald-200',
        'bg-teal-200',
        'bg-cyan-200',
        'bg-sky-200',
        'bg-indigo-200',
        'bg-violet-200',
        'bg-purple-200',
        'bg-fuchsia-200',
        'bg-pink-200',
        'bg-rose-200',
        'bg-red-400',
        'bg-green-400',
        'bg-orange-400',
        'bg-blue-400',
        'bg-slate-400',
        'bg-gray-400',
        'bg-zinc-400',
        'bg-neutral-400',
        'bg-stone-400',
        'bg-amber-400',
        'bg-yellow-400',
        'bg-lime-400',
        'bg-emerald-400',
        'bg-teal-400',
        'bg-cyan-400',
        'bg-sky-400',
        'bg-indigo-400',
        'bg-violet-400',
        'bg-purple-400',
        'bg-fuchsia-400',
        'bg-pink-400',
        'bg-rose-400',
        // ------------
        // Text Colors
        // ------------
        'text-green-400',
        'text-teal-300',
        'text-red-500',
        'text-rose-300',
    ],
};
