import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import react from '@vitejs/plugin-react';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import { defineConfig } from 'vite';
import glob from 'glob';
const pages = glob.sync('resources/js/pages/*.js');
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/admin/app.tsx',
                ...pages,
            ],
            refresh: true,
        }),
        react(),
        tailwindcss(),
        wayfinder({
            formVariants: true,
            patterns: ['app/Http/Controllers/Auth/*.php', 'app/Http/Controllers/Admin/*.php'],
            path: 'resources/admin',
            command: 'php artisan wayfinder:generate-user --routes-name=admin,photos --with-form',
        }),
        wayfinder({
            formVariants: true,
            path: 'resources/js/',
            actions: false,
            command: 'php artisan wayfinder:generate-user --routes-name=client,user-profile-information,verification.send,user-password.update --with-form',
        }),
    ],
    resolve: {
        extensions: ['.js', '.ts', '.jsx', '.tsx', '.d.ts'],
        alias: {
            '@': path.resolve(__dirname, 'resources/admin'),
            '@client': path.resolve(__dirname, 'resources/js'),
            '@fonts': path.resolve(__dirname, 'resources/fonts'),
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
