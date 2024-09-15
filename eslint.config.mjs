import react from "eslint-plugin-react";
import typescriptEslint from "@typescript-eslint/eslint-plugin";
import simpleImportSort from "eslint-plugin-simple-import-sort";
import prettier from "eslint-plugin-prettier";
import globals from "globals";
import tsParser from "@typescript-eslint/parser";
import path from "node:path";
import { fileURLToPath } from "node:url";
import js from "@eslint/js";
import { FlatCompat } from "@eslint/eslintrc";

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const compat = new FlatCompat({
    baseDirectory: __dirname,
    recommendedConfig: js.configs.recommended,
    allConfig: js.configs.all
});

export default [{
    ignores: ["**/bootstrap.js"],
}, ...compat.extends(
    "eslint:recommended",
    "plugin:react/recommended",
    "plugin:@typescript-eslint/recommended",
), {
    plugins: {
        react,
        "@typescript-eslint": typescriptEslint,
        "simple-import-sort": simpleImportSort,
        prettier,
    },

    languageOptions: {
        globals: {
            ...globals.browser,
        },

        parser: tsParser,
        ecmaVersion: "latest",
        sourceType: "module",
    },

    settings: {
        react: {
            pragma: "React",
            version: "16.12.0",
        },
    },

    rules: {
        "jsx-quotes": "error",
        quotes: "error",
        semi: "error",
        "react/react-in-jsx-scope": "off",
        "simple-import-sort/imports": "error",

        "prettier/prettier": ["warn", {
            singleQuote: false,
            semi: true,
            trailingComma: "all",
        }],
    },
}];
