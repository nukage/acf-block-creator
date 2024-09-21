<?php

/**
 * Load Blocks
 */

$plugin_dir = plugin_dir_path(__FILE__);
function nkg_load_blocks()
{
    $theme  = wp_get_theme();
    $blocks = nkg_get_blocks();
    foreach ($blocks as $block) {
        if (file_exists(plugin_dir_path(__FILE__) . '/' . $block . '/block.json')) {
            register_block_type(plugin_dir_path(__FILE__) . '/' . $block . '/block.json');
            //wp_register_style( 'block-' . $block, get_template_directory_uri() . '/' . $block . '/style.css', null, $theme->get( 'Version' ) );

            if (file_exists(plugin_dir_path(__FILE__) . '/' . $block . '/init.php')) {
                include_once plugin_dir_path(__FILE__) . '/' . $block . '/init.php';
            }
        }
    }
}
add_action('init', 'nkg_load_blocks', 5);

/**
 * Load ACF field groups for blocks
 */
function nkg_load_acf_field_group($paths)
{
    $blocks = nkg_get_blocks();
    foreach ($blocks as $block) {
        $paths[] = plugin_dir_path(__FILE__) . '/' . $block;
    }
    return $paths;
}
add_filter('acf/settings/load_json', 'nkg_load_acf_field_group');

/**
 * Get Blocks
 */
function nkg_get_blocks()
{
    $theme   = wp_get_theme();
    $blocks  = get_option('nkg_blocks');
    $version = get_option('nkg_blocks_version');
    if (empty($blocks) || version_compare($theme->get('Version'), $version) || (function_exists('wp_get_environment_type') && 'production' !== wp_get_environment_type())) {
        $blocks = scandir(plugin_dir_path(__FILE__) . '/');
        $blocks = array_values(array_diff($blocks, array('..', '.', '.DS_Store', '_base-block')));

        update_option('nkg_blocks', $blocks);
        update_option('nkg_blocks_version', $theme->get('Version'));
    }
    return $blocks;
}


function nkg_block_categories($categories)
{

    return array_merge(
        [
            [
                'slug' => 'nkg-blocks',
                'title' => __('ACF Blockmaker Blocks', 'qntm'),
            ],

        ],
        $categories
    );
}
add_action('block_categories_all', 'nkg_block_categories', 10, 2);
