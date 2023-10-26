/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.{html,php,js}"],
  theme: {
    extend: {},
  },
  daisyui: {
    themes: [
      {
        "miamiam-light": {
          primary: "#ff8a00",
          "primary-content": "#ffffff",
          secondary: "#ff7a01",
          accent: "#f93b09",
          neutral: "#ff7a01",
          "base-100": "#ffffff",
        },
      },
      "dark",
    ],
  },
  plugins: [require("daisyui")],
};
