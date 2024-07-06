import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css',
                'resources/js/app.js',
                'resources/css/bootstrap.min.css',
                'resources/js/jquery-3.7.1.min.js',
                'resources/js/tinymce.min.js',
                'resources/js/bootstrap.min.js',
                'resources/js/popper.min.js',
            ],
            refresh: true,
        })
    ],
});
