module.exports = {
    purge: {
        enabled: true,
        content: [
            './resources/**/*.blade.php',
            './resources/**/*.js',
            './resources/**/*.jsx',
            './resources/**/*.vue',
        ],
    },
    darkMode: false,
    future: {
        removeDeprecatedGapUtilities: true,
    },
    theme: {
        screens: {
            'sm': '640px',
            'md': '950px',
            'lg': '1024px',
            'xl': '1280px',
        },
        extend: {
            fontSize: {
                '7xl': '5rem',
            },
            colors: {
                'navy-blue': '#005cb8',
                'apple-green': '#3aa546',
                'dark-apple-green': '#2E8438'
            }
        },
    },
    variants: {},
    plugins: [],
}
