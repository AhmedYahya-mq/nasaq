import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import react from '@vitejs/plugin-react';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/admin/app.tsx'],
            ssr: 'resources/admin/ssr.tsx',
            refresh: true,
        }),
        react(),
        tailwindcss(),
        wayfinder({
            formVariants: true,
            patterns: ['app/Http/Controllers/Auth/*.php', 'app/Http/Controllers/Admin/*.php'],
            path: 'resources/admin/',
            command: 'php artisan wayfinder:generate --with-form',
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/admin') // أو resources/js/app

        },
    },
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    react: ['react', 'react-dom'],
                    vendors: ['axios', 'alpinejs', 'swiper', 'intl-tel-input'],
                },
            },
        },
    },
    esbuild: {
        jsx: 'automatic',
    },
});
