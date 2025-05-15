// Set the Preflight flag based on the build target.
const includePreflight = 'editor' === process.env._TW_TARGET ? false : true;

module.exports = {
	presets: [
		// Manage Tailwind Typography's configuration in a separate file.
		require('./tailwind-typography.config.js'),
	],
	content: [
		// Ensure changes to PHP files trigger a rebuild.
		'./theme/**/*.php',
	],
	theme: {
		// Extend the default Tailwind theme.
		extend: {
			letterSpacing: {
				'custom': '0.5em', // Defina o valor desejado
			},
			colors: {
				'borda-laranja': '#fbc79d',
				'borda-verde': '#9dd4b0',
				'cor-motivacao': '#8080ff',
				'cor-impressao': '#ff8080',
				'cor-expressao': '#80ffff',
				'somatoria-motivacao': '#80ff00',
				'somatoria-expressao': '#ffff00',
				'botao-rosa': '#F7D9D9',
				'botao-lilas': '#D8CAE5',
				'cor-numera': '#43265F'
			}
		},
	},
	corePlugins: {
		// Disable Preflight base styles in builds targeting the editor.
		preflight: includePreflight,
	},
	plugins: [
		// Add Tailwind Typography (via _tw fork).
		require('@_tw/typography'),

		// Extract colors and widths from `theme.json`.
		require('@_tw/themejson'),

		// Uncomment below to add additional first-party Tailwind plugins.
		// require('@tailwindcss/forms'),
		// require('@tailwindcss/aspect-ratio'),
		// require('@tailwindcss/container-queries'),
	],
};
