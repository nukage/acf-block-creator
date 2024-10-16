# **ACF Block Builder**

ACF Block Builder is a plugin that was designed to quickly and easily create ACF blocks from sub-components.  As Wordpress becomes more block-based, we need tools to make block creation more efficient, more modular, and also allow us developers to take advantage of some of the newer block editing and site editing features, while still giving clients a curated experience.

Problems to solve:

- **Modularity / Reusability of code -** I needed a system to ensure that custom code written in a current project could be easily re-used in a future project.
- **Speed to develop new blocks** - There was a lot of boiler plate and setup required that I had to keep doing for every single block added - I wanted to cut down on this
- **Modern Wordpress Workflow** - I wanted to take advantage of modern Wordpress building, while offering the same curated experience to clients

Use cases:

- As a repository of blocks that can be easily changed to match a given site theme's colors, fonts, spacing options, with little to no change to the block code or settings
- As a system to build new blocks, so they can be rapidly prototyped

Features/Benefits:

- Developers can visually create re-usable ACF blocks, from more basic block sub-elements
- Automatic generation of CSS based on theme variables, preventing the need to manually apply new styling when bringing code into a new site
- By using built-in Wordpress features like synced blocks, block sub-elements like buttons can be easily defined in a single location and used across multiple blocks
- Supports more advanced options like creating repeater fields, and query loops, without writing custom code
- Provides a system to modularize and automatically load blocks into the site theme, cutting down on time required to set up boiler plate code
- Automatic creation of ACF fields, allowing us to set 'good defaults' across every field on a project
- Automatic creation of Block.json and other boilerplate needed for blocks
- All dependencies will exist in the site theme, so the plug-in can be disabled after site development
- Allows us as developers to take advantage of the latest Wordpress tools for rapid development, while providing the same tried-and-tested user experience to clients
- Allows us to provide a set of basic site blocks without adding additional development time to a project
- Allows us to quickly adapt our set of blocks to match a client's content, even after initial development is complete
- Preserves the PHP template workflow where block code is compiled at run time, instead of when the user saves the page
- Provides a system that allows additional block sub-elements yet to be developed (galleries, slideshows, etc) that can be easily added to over time
- Creates opportunity for lower budget projects that can be comprised entirely of premade blocks - even headers/footers can be created to be modular
- Includes a build process with a [custom script](https://github.com/nukage/tailthemer) that automatically generates Tailwind classes from variables defined in Theme.json allowing developers or designers to visually define theme settings using FSE site editor
- Includes a script that automatically creates required files for blocks
- Designed to work with an icon repository so blocks will always have unique icons from the start ([separate plugin/repo](https://github.com/nukage/svg-library))

### TO DO:

- Create basic block repository
    - Accordion (Done)
    - Checkerboard (Done)
    - Standard Content
    - Icon List
    - Image Pathways
    - Mainstage/Hero
    - Blog Loop (Done)

Potential Roadmap (Very tentative):

- Add additional sub-blocks like gallery, slideshow, gravity forms
- Support for block styling - use FSE to style buttons or other components and have those automatically generate utility classes that can be applied to our own buttons
- One-click generation of block files instead of having to copy+paste code
- Create easier system to safelist tailwind classes - block styler class fields could be automatically added to the safelist for example
- Improve block editing interface in any way possible - Interface of WP Core Framework could be inspiration
- Re-build ACF Block Builder blocks without use of ACF blocks - this would allow me to have full control over interface, so I could implement interface similar to Core Framework
- Potentially support building Wordpress native blocks - this would probably require a huge overhaul
- Think of a better name for the plugin :D

## **Setup**

Requirements:

- Node Package Manager
- Advanced Custom Fields Pro
- A local install of Wordpress is recommended but not required.

1.  Git clone the Block Builder plugin into your /wp-content/plugins folder.
2.  Ensure that ACF Pro is installed and activated, as it is a requirement for this plugin.
3.  This plugin uses your Wordpress theme's Theme.json file to generate the tailwind classes needed. It will look for certain customizations in your theme.json, and it is highly recommended that all of these are defined, otherwise you will be missing certain style options. I have listed these below.
4.  If you are using a block theme and you have used the site editor to customize your theme, ensure your theme customizations have been exported from the database into theme.json. You can use the Create Block Theme plugin to do this automatically.
5.  In the plugin directory, the tailwind file must be built, and it needs to be able to find your theme's theme.json file. You can either just copy theme.json into the plugin folder, or you can edit the first few lines of tailwind.config.js to point it at the theme.json within your theme's folder (recommended).
6.  Install required packages by running 'npm install' in the plugin directory
7.  Type 'npm run dev' to compile the required CSS

## Theme Options

These theme option settings are required for all features to work properly.  You can use the included theme.json as an example of how to structure these.

1.  Content Size - settings.layout.contentSize
2.  Wide Size - settings.layout.wideSize
3.  Color Palette - settings.color.palette
4.  Line Height - settings.custom.lineHeight
5.  Font Weight - settings.custom.fontWeight
6.  Font Sizes - settings.typography.fontSizes
7.  Font Families - settings.typography.fontFamilies

Additional settings can be defined under settings.custom, and added to Tailwind using tailthemer.customMapper.

I designed this plugin to help me create sites in a more modular way.  In order to facilitate this, I recommend using generic names where it makes sense. Things like 'primary' and 'secondary' for fonts and colors helps with this. I also recommend taking advantage of the fluid font size and clamping options to help with mobile and tablet views.