/** @type {import('tailwindcss').Config} */
module.exports = {

    darkMode: 'class',
    content: ['./resources/**/*.blade.php', './resources/**/*.js', './resources/**/*.vue'],
    theme: {
        extend: {
            colors: {
                dark: '#1a202c',
            },
        },
    },
    plugins: [],
};

