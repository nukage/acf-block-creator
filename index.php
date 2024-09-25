<?php
/*
Plugin Name: ACF Block Maker
Plugin URI: https://nukage.net
Description: A series of blocks that can be used together to automate the process of building ACF blocks
Version: 1.0
Author: QNTM Marketing
Author URI: https://nukage.net
*/

require_once __DIR__ . '/resources/blocks/blocks.php'; // Blocks
require_once __DIR__ . '/resources/functions.php'; // Functions
require_once __DIR__ . '/resources/acf-populate.php'; // ACF Auto-populate fields with options from theme.json
require_once __DIR__ . '/resources/style-builder.php'; // ACF Style Builder to create Tailwind classes
require_once __DIR__ . '/resources/acf-fields.php'; // ACF field loader, but using php to load it means we can check uer perms first
