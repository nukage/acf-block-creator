**Block Builder Setup**

Requirements: 

- Node Package Manager
- Advanced Custom Fields Pro
- A local install of Wordpress is recommended but not required.

1.  Install the Block Builder plugin. Currently the easiest way is to use [WP Pusher](https://wppusher.com/) which allows you to install themes and plugins from Git, or just download direct from git.
2.  Ensure that ACF Pro is installed and activated, as it is a requirement for this plugin.
3.  This plugin uses your Wordpress theme's Theme.json file to generate the tailwind classes needed.   
    Make sure that:
    1.  If you are using a block theme and you have used the site editor to customize your theme, ensure your theme customizations have been exported from the database into theme.json. You can use the Create Block Theme plugin to do this automatically.
    2.  In the plugin directory, the tailwind file must be built, and it needs to be able to find your theme's theme.json file. You can either just copy theme.json into the plugin folder, or you can edit the first few lines of tailwind.config.js to point it at the theme.json within your theme's folder.
    3.  Install required packages by running 'npm install' in the plugin directory
    4.  Type 'npm run dev' to compile the required CSS