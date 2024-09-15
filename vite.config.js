import { defineConfig } from 'vite';
import react from "@vitejs/plugin-react";
import laravel from 'laravel-vite-plugin';
import path from "path";
import tailwindcss from "tailwindcss";
import autoprefixer from "autoprefixer";

const spaPath = "./resources/spa/src";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/spa/src/index.tsx"],
            refresh: ["resources/spa/**"],
        }),
        react(),
    ],
    resolve: {
        alias: {
            "@components": path.resolve(__dirname, `${spaPath}/components`),
            "@pages": path.resolve(__dirname, `${spaPath}/pages`),
            "@config": path.resolve(__dirname, `${spaPath}/config`),
            "@contexts": path.resolve(__dirname, `${spaPath}/contexts`),
            "@hooks": path.resolve(__dirname, `${spaPath}/hooks`),
            "@api": path.resolve(__dirname, `${spaPath}/api`),
            "@web-services": path.resolve(
                __dirname,
                `${spaPath}/web-services`,
            ),
            "@spa": path.resolve(__dirname, `${spaPath}`),
            "@images": path.resolve(__dirname, `${spaPath}/images`),
            "@public": path.resolve(__dirname, "./public"),
        },
    },
    css: {
        postcss: {
            plugins: [tailwindcss(), autoprefixer()],
        },
    },
});
