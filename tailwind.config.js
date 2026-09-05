export default {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                pine: {
                    950: '#0d1f15',
                    900: '#12281b',
                    800: '#1a3a27',
                    700: '#22503a',
                },
                emerald: {
                    DEFAULT: '#166534',
                    600: '#16a34a',
                    700: '#15803d',
                    800: '#166534',
                    900: '#14532d',
                },
                gold: {
                    DEFAULT: '#c9952d',
                    50: '#fbf5e7',
                    100: '#f5e6c3',
                    200: '#ecd394',
                    300: '#e2bd5f',
                    400: '#d6ab3d',
                    500: '#c9952d',
                    600: '#a67a22',
                    700: '#855e1c',
                },
                paper: {
                    DEFAULT: '#f4f6f2',
                    50: '#fafbf9',
                    100: '#f4f6f2',
                    200: '#e9edE6',
                },
            },
            fontFamily: {
                sans: ['SolaimanLipi', 'Hind Siliguri', 'Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                serif: ['SolaimanLipi', '"Noto Serif Bengali"', 'Georgia', 'serif'],
            },
            boxShadow: {
                card: '0 1px 3px rgba(16, 44, 30, 0.06), 0 1px 2px rgba(16, 44, 30, 0.05)',
                lift: '0 8px 24px -6px rgba(16, 44, 30, 0.18)',
            },
        },
    },
    plugins: [],
};