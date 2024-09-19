/** @type {import('tailwindcss').Config} */
export default {
  content: ["./resources/**/*.{html,js,tsx}"],
  theme: {
    extend: {},
  },
    plugins: [
        // ...
        require('@tailwindcss/forms'),
    ],
}

