import { defineConfig, loadEnv } from 'vite';
import tailwindcss from '@tailwindcss/vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin'
import basicSsl from '@vitejs/plugin-basic-ssl';

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), '');
    const hmrHost = env.VITE_HMR_HOST || 'localhost';

    return {
        plugins: [
            laravel({
                input: [
                    'resources/css/app.css',
                    'resources/js/app.js',
                ],
                refresh: [
                    ...refreshPaths,
                    "app/Livewire/**",
                    "app/Filament/**",
                    "app/Providers/Filament/**",
                    "resources/views/**"
                ],
                detectTls: false,
            }),
            tailwindcss(),
            basicSsl(),
        ],
        server: {
            host: "0.0.0.0",
            port: 5173,
            strictPort: true,
            hmr: {
                protocol: 'wss',
                host: hmrHost,
            },
        },
    };
});
