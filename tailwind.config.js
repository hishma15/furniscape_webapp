import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            // fontFamily: {
            //     sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            // },
            colors: {
                brown: "#967F71",
                black: "#3B3937",
                beige: "#F5F5F3",
                grayBack: "#F4F4F4",
                // beige: "#EDE8D0",
                btnHoverBrown: "#7e6b61",
                customyellow: "#F8C8DC",
    
            },
  
            fontFamily: {
                fancy: ['"Comic Sans MS"','cursile'],
                lustria: ['Lustria', 'serif'],
                montserrat: ['Montserrat', 'sans-serif'],
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },

            animation: {
                fade: 'fadeOut 4s ease-out forwards'
            },

            keyframes: {
                fadeOut: {
                    '0%': {opacity: 1 },
                    '100%': {opacity: 0 }
                }
            },
        },
    },

    plugins: [forms, typography],
};
