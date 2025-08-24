import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: false, // Deshabilitar refresh en producción
        }),
    ],
    build: {
        // Optimizaciones para producción
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true,
                drop_debugger: true,
                pure_funcs: ['console.log', 'console.info', 'console.debug'],
            },
            mangle: {
                safari10: true,
            },
        },
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['axios'],
                    tailwind: ['tailwindcss'],
                },
                // Optimizar nombres de archivos
                chunkFileNames: 'assets/js/[name]-[hash].js',
                entryFileNames: 'assets/js/[name]-[hash].js',
                assetFileNames: 'assets/[ext]/[name]-[hash].[ext]',
            },
        },
        // Optimizar CSS
        cssCodeSplit: true,
        cssMinify: true,
        // Optimizar assets
        assetsInlineLimit: 4096,
        // Generar source maps solo si es necesario
        sourcemap: false,
        // Optimizar chunking
        chunkSizeWarningLimit: 1000,
        // Optimizar target
        target: 'es2015',
    },
    css: {
        // Optimizaciones de CSS para producción
        devSourcemap: false,
        postcss: {
            plugins: [
                require('tailwindcss'),
                require('autoprefixer'),
                require('cssnano')({
                    preset: ['default', {
                        discardComments: {
                            removeAll: true,
                        },
                        normalizeWhitespace: true,
                        colormin: true,
                        minifyFontValues: true,
                        minifySelectors: true,
                        mergeLonghand: true,
                        mergeRules: true,
                        normalizeUrl: true,
                        orderedValues: true,
                        reduceIdents: true,
                        reduceInitial: true,
                        reduceTransforms: true,
                        uniqueSelectors: true,
                        zindex: true,
                    }]
                }),
            ],
        },
    },
    // Optimizaciones adicionales
    define: {
        __VUE_OPTIONS_API__: false,
        __VUE_PROD_DEVTOOLS__: false,
    },
    // Optimizar dependencias
    optimizeDeps: {
        include: ['axios'],
        exclude: ['laravel-vite-plugin'],
    },
    // Configuración del servidor (solo para desarrollo)
    server: false,
});
