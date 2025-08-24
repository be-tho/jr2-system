import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        // Optimizaciones para producción
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true,
                drop_debugger: true,
            },
        },
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['axios'],
                },
            },
        },
        // Optimizar CSS
        cssCodeSplit: true,
        // Optimizar assets
        assetsInlineLimit: 4096,
        // Generar source maps solo en desarrollo
        sourcemap: process.env.NODE_ENV !== 'production',
    },
    server: {
        // Configuración del servidor de desarrollo
        hmr: {
            host: 'localhost',
        },
        // Optimizar hot reload
        watch: {
            usePolling: true,
        },
    },
    optimizeDeps: {
        // Pre-bundle de dependencias comunes
        include: ['axios'],
    },
    css: {
        // Optimizaciones de CSS
        devSourcemap: true,
    },
});
