module.exports = {
  mode: 'jit',
  content: [],
  theme: {
    extend: {},
    colors: ({ colors }) => ({
      transparent: 'transparent',
      current: 'currentColor',

      black: '#000',
      white: '#fff',
      light: '#f2f2f2',

      primary: '#07f',

      'primary-darker': '#3312A0',
      'primary-dark': '#4B23D0',
      'primary-light': '#363944',
      'gray-dark': '#23262e',
      'gray-darker': '#1d1f25',
      'gray-darkest': '#191b21',
      'gray-light': '#21222B',
      'gray-lighter': '#323441',
      'gray-lightest': '#92909C',

      gray: colors.gray,
      indigo: colors.indigo,
      sky: colors.sky
    })
  },
  plugins: [require('@tailwindcss/forms')],
}
