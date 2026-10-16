/** @type {import('tailwindcss').Config} */
const token = (name) => `rgb(var(--c-${name}) / <alpha-value>)`

module.exports = {
    darkMode: 'class',
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue'
    ],
    theme: {
        extend: {
            colors: {
                canvas: token('canvas'),
                panel: token('panel'),
                subtle: token('subtle'),
                chip: token('chip'),
                line: token('line'),
                ink: token('ink'),
                muted: token('muted'),
                accent: token('accent'),
                'on-accent': token('on-accent'),
                danger: token('danger')
            },
            fontFamily: {
                sans: ['"Instrument Sans"', 'system-ui', 'sans-serif'],
                serif: ['"Instrument Serif"', 'Georgia', 'serif'],
                mono: ['"IBM Plex Mono"', 'ui-monospace', 'monospace']
            },
            borderRadius: {
                control: '8px',
                panel: '12px'
            }
        }
    },
    plugins: []
}
