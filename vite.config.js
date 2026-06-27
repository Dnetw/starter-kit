import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'vendor/dnetw/core/resources/js/passkeys.js',
                'vendor/dnetw/core/resources/js/photo-cropper.js',
                'vendor/dnetw/core/resources/js/leaflet.js',
                'vendor/dnetw/core/resources/js/maplibre.js',
                'vendor/dnetw/core/resources/js/gridstack.js',
            ],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
    ],
    build: {
        chunkSizeWarningLimit: 1500,
    },
    server: {
        cors: true,
        watch: {
            // Symlinked path repos (vendor/dnetw/*, vendor/piscpr/*) drag
            // their own vendor/, node_modules/, tests/, .git/ trees through
            // the watcher; without these excludes the FS watch grows unbounded
            // and OOMs Vite mid-dev.
            ignored: [
                '**/storage/framework/views/**',
                '**/storage/logs/**',
                '**/vendor/**/vendor/**',
                '**/vendor/**/node_modules/**',
                '**/vendor/**/tests/**',
                '**/vendor/**/.git/**',
                '**/vendor/**/database/migrations/**',
                '**/vendor/**/lang/**',
                '**/.git/**',
                '**/node_modules/.vite/**',
            ],
            usePolling: false,
        },
    },
    resolve: {
        preserveSymlinks: true,
    },
});
