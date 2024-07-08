/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
  theme: {
    extend: {
        //agregar el font family Monserrat
        fontFamily: {
            'sans': ['Montserrat', 'sans-serif'],

        },
    },
  },
  plugins: [
  ],
}

