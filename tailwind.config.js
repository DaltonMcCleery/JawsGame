module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    theme: {
        fontFamily: {
            'demi': ['Souvenir Demi', 'Arial', 'sans-serif'],
            'demi-italic': ['Souvenir DemiItalic', 'Arial', 'sans-serif'],
        },
        extend: {
            colors: {
                red: '#e40403',
                quint: '#85b65b',
                hooper: '#6b9cd1',
                brody: '#020609',
                lightgray: '#969799',
                black: '#292C29',
            },
            zIndex: {
                '-1': '-1',
                '1': '1',
            },
        },
    },
    plugins: [
        require('@tailwindcss/typography'),
        require('@tailwindcss/forms'),
    ],
}
