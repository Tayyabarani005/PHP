/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js}"],
  theme: {
    extend: { backgroundImage: {
      'hero': "url('background.jpg')",
      'aero':"url('img1.jpg')"
    }},
  },
  plugins: [],
}

