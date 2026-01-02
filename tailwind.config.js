import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import designConfig from './resources/js/design-config.js';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                primary: designConfig.colors.primary,
                secondary: designConfig.colors.secondary,
                accent: designConfig.colors.accent,
                neutral: designConfig.colors.neutral,
            },
            fontFamily: {
                sans: designConfig.typography.fontFamily.sans,
                display: designConfig.typography.fontFamily.display,
                mono: designConfig.typography.fontFamily.mono,
            },
            fontSize: designConfig.typography.fontSize,
            spacing: designConfig.spacing,
            borderRadius: designConfig.borderRadius,
            boxShadow: designConfig.boxShadow,
            animation: designConfig.animation,
            keyframes: designConfig.keyframes,
            backdropBlur: designConfig.backdropBlur,
        },
    },

    plugins: [forms],
};
