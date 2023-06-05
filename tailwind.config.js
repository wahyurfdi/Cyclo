/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'gray-dark': '#797979',
        'gray': '#DBDBDB',
        'gray-light': '#F2F3EE',
        'green-dark': '#364E1D',
        'green': '#609966',
        'yellow': '#F7C04A',
        'blue': '#0084A4'
      }
    }
  },
  plugins: [],
}

