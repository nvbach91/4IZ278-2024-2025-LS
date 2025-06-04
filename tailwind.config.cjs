/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
  ],
  theme: { extend: {} },

  // DaisyUI hook
  plugins: [ require('daisyui') ],

  // optional: pick themes
  daisyui: { themes: ['light','dark','cupcake'] },
};