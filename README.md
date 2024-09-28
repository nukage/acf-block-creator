**Block Builder Setup**

Requirements:

- Node Package Manager
- Advanced Custom Fields Pro
- A local install of Wordpress is recommended but not required.

1.  Install the Block Builder plugin. Currently the easiest way is to use [WP Pusher](https://wppusher.com/) which allows you to install themes and plugins from Git, or just download direct from git.
2.  Ensure that ACF Pro is installed and activated, as it is a requirement for this plugin.
3.  This plugin uses your Wordpress theme's Theme.json file to generate the tailwind classes needed. It will look for certain customizations in your theme.json, and it is highly recommended that all of these are defined, otherwise you will be missing certain style options. I have listed these below.
4.  If you are using a block theme and you have used the site editor to customize your theme, ensure your theme customizations have been exported from the database into theme.json. You can use the Create Block Theme plugin to do this automatically.
5.  In the plugin directory, the tailwind file must be built, and it needs to be able to find your theme's theme.json file. You can either just copy theme.json into the plugin folder, or you can edit the first few lines of tailwind.config.js to point it at the theme.json within your theme's folder.
6.  Install required packages by running 'npm install' in the plugin directory
7.  Type 'npm run dev' to compile the required CSS

&nbsp;

&nbsp;

&nbsp;

1.  Content Size - settings.layout.contentSize
2.  Wide Size - settings.layout.wideSize
3.  Color Palette - settings.color.palette
4.  Line Height - settings.custom.lineHeight
5.  Font Weight - settings.custom.fontWeight
6.  Font Sizes - settings.typography.fontSizes
7.  Font Families - settings.typography.fontFamilies

Additional settings can be defined under settings.custom, and added to Tailwind using tailthemer.customMapper.  

I designed this plugin to help me create sites in a more modular way.  In order to facilitate this, I recommend using generic names where it makes sense. Things like 'primary' and 'secondary' for fonts and colors helps with this. I also recommend taking advantage of the fluid font size and clamping options to help with mobile and tablet views.