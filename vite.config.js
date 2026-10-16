import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import { VitePWA } from 'vite-plugin-pwa'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // 'resources/sass/app.scss',
                'resources/js/app.js'
            ],
            refresh: true
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false
                }
            }
        }),
        VitePWA({
            // the worker is built into public/build but served from /sw.js by
            // a Laravel route (routes/web.php) so it can control the whole site
            base: '/',
            scope: '/',
            strategies: 'injectManifest',
            srcDir: 'resources/js',
            filename: 'sw.js',
            registerType: 'prompt',
            injectRegister: false,
            includeManifestIcons: false,
            injectManifest: {
                globPatterns: ['**/*.{js,css,woff2,svg,png}']
            },
            manifest: {
                id: '/',
                name: 'Linker',
                short_name: 'Linker',
                description: 'Link everything',
                start_url: '/',
                scope: '/',
                display: 'standalone',
                background_color: '#1c1c1c',
                theme_color: '#1c1c1c',
                icons: [
                    { src: '/icons/icon-192.png', sizes: '192x192', type: 'image/png' },
                    { src: '/icons/icon-512.png', sizes: '512x512', type: 'image/png' },
                    { src: '/icons/maskable-512.png', sizes: '512x512', type: 'image/png', purpose: 'maskable' }
                ]
            }
        })
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js'
        }
    }
})
