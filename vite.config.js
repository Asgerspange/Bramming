import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'path';
import { chunkSplitPlugin } from 'vite-plugin-chunk-split'
import viteCompression from 'vite-plugin-compression';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/js/app.js'],
      refresh: true, // Enables HMR
    }),
    vue(),
    chunkSplitPlugin({
      strategy: 'single-vendor',
      customSplitting: {
        // 'primevue': [/node_modules\/primevue/],
        'lodash': [/node_modules\/lodash-es/],
        'axios': [/node_modules\/lodash-es/]
      }
    }),
    viteCompression({
      algorithm: 'gzip',
      filter: /\.(js|json|html)$/i, // Specify file types to gzip
      threshold: 10240,
    }),
  ],
  resolve: {
    alias: {
      '@': resolve(__dirname, 'resources'),
    },
  }
});