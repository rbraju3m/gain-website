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
                display: ['"Fraunces"', '"Playfair Display"', 'Georgia', 'serif'],
            },
            colors: {
                brand: {
                    // Burgundy / rose red — sampled from "Our Impact" heading (#9C2245)
                    red: {
                        50:  '#FCEFF2',
                        100: '#F9DEE5',
                        200: '#F1B7C5',
                        300: '#E48BA0',
                        400: '#C4506E',
                        500: '#9C2245',
                        600: '#8A1B3C',
                        700: '#73152F',
                        800: '#5D1126',
                    },
                    // Vibrant medium green — sampled from "Communities" / "Our Vision" (#87B558)
                    green: {
                        50:  '#F3F8ED',
                        100: '#E3F0D4',
                        300: '#B5D78F',
                        500: '#87B558',
                        600: '#6E9B43',
                        700: '#577A37',
                    },
                    // Peach orange — sampled from "Our Values" (#FFA268)
                    orange: {
                        50:  '#FFF4ED',
                        100: '#FFE5D3',
                        300: '#FFC59E',
                        500: '#FFA268',
                        600: '#E8864A',
                    },
                    cream: '#FAF1ED',
                    ink:   '#1F1B22',
                    muted: '#6B6470',
                },
            },
            boxShadow: {
                pill: '0 12px 24px -10px rgba(156, 34, 69, 0.45)',
                card: '0 25px 60px -25px rgba(31, 27, 34, 0.18)',
                soft: '0 10px 40px -20px rgba(31, 27, 34, 0.20)',
            },
            backgroundImage: {
                'hero-wash': 'linear-gradient(180deg, #FCE5E0 0%, #FAF1ED 60%, #ffffff 100%)',
                'brand-line': 'linear-gradient(90deg, #9C2245 0%, #87B558 50%, #FFA268 100%)',
                'cta-burgundy': 'linear-gradient(135deg, #9C2245 0%, #73152F 100%)',
            },
        },
    },

    plugins: [forms],
};
