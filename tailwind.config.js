// const theme = require("../../themes/qntm-zero/theme.json"); // Change to the location of your theme.json and remove the line below
const theme = require("./theme.json");
const tailthemer = require("@nukage/tailthemer");
// const qntmMapper = require("./qntm-modules/tailwind-mapper.js");
// const plugin = require("tailwindcss/plugin");

/** @type {import('tailwindcss').Config} */
module.exports = {
    corePlugins: {
		backgroundOpacity: false,
		placeholderOpacity: false,
		textOpacity: false,
		divideOpacity: false,
		// borderOpacity: false,
	},
    content: [
        './*.php',
        './**/*.php',
        './resources/css/*.css',
        './resources/js/*.js',
        './safelist.txt'
    ],
	safelist: [
		'text-2xl',
		'text-3xl',
		{
			pattern: /^p(?:x|y|t|b|l|r)?-[a-z0-9-]+$/i, // Padding
		  },
		  {
			pattern: /^m(?:x|y|t|b|l|r)?-[a-z0-9-]+$/i, // Margin
		  },
		{
			pattern: /^text-[^\/]*$/,
		},
		{
			pattern: /^bg-[^\/]*$/,
		},
		{
			pattern: /^font-[^\/]+$/,
		},
		{
			pattern: /^leading-[^\/]*$/,
		},
		{
			pattern: /^grid-cols-\d+$/i,
		},
		{
			pattern: /^(w|min-w|max-w)-[a-z0-9\/-]+$/i,
		  }
	  ],
    theme: {
        container: {
			center: true,
			padding: {
				DEFAULT: "20px",
			},
		},
        extend: {
            zIndex: {
				1: "1",
				2: "2",
				3: "3",
				4: "4",
				5: "5",
				6: "6",
				7: "7",
				8: "8",
				9: "9",
			},
            spacing: {
				"1/10": "10%",
				"2/10": "20%",
				"3/10": "30%",
				"4/10": "40%",
				"5/10": "50%",
				"6/10": "60%",
				"7/10": "70%",
				"8/10": "80%",
				"9/10": "90%",
			},

        },
		colors: {
			bordergray: "#626E6D52", 
			...tailthemer.colorMapper(
				tailthemer.theme("settings.color.palette", theme)
			),
		},
		// width: tailthemer.customMapper(tailthemer.theme('settings.custom.width', theme)),
		screens: {
			// xs: "480px",
			// sm: "600px",
			// md: "782px",
			// lg: "960px", // 960px
			// xl: "1064px", // 1064px
			// "2xl": "1240px",
			// "3xl": "1440px",
			// "4xl": "1920px",
			'xs': '480px',
            'sm': '600px',
            'md': '782px',
			'lg': '960px',
            'xl': tailthemer.theme('settings.layout.contentSize', theme),
            '2xl': tailthemer.theme('settings.layout.wideSize', theme),
          
		},
		lineHeight: {...tailthemer.customMapper(tailthemer.theme('settings.custom.lineHeight', theme)),
			normal: "1.5",
			none: "none",
			tight: "1.15",
			snug: "1.2",
		},
		fontSize: tailthemer.fontSizeMapper(tailthemer.theme('settings.typography.fontSizes', theme)),
		fontWeight: tailthemer.customMapper(tailthemer.theme('settings.custom.fontWeight', theme)),
		spacing: {
			...tailthemer.spacingMapper(tailthemer.theme('settings.spacing.spacingSizes', theme)),
			0: '0',
			4: '0.25rem',

		},
        fontFamily: tailthemer.fontFamMapper(tailthemer.theme('settings.typography.fontFamilies', theme)),
    },
	plugins: [
		tailthemer.tailwind,
        require("@tailwindcss/forms"),
	],
};
