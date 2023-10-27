/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.{html,php,js}"],
  theme: {
    colors: {
      admin: "#e05765",
      "admin-secondary": "#933942",
      users: "#2f96ff",
      "users-secondary": "#2068b2",
      categories: "#32b75f",
      "categories-secondary": "#1d6a37",
      foods: "#f6c935",
      "foods-secondary": "#a98a24",
      orders: "#929292",
      "orders-secondary": "#5c5c5c",
      white: "#ffffff",
    },
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
          "base-200": "#f9f9f9",
          "base-300": "#f3f3f3",
        },
      },
      "dark",
    ],
  },
  plugins: [require("daisyui")],
};
