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

/**
 * Block functions used by the generated blocks, 
 * so these functions need to be available in the theme 
 * if this plugin is disabled, otherwise the blocks will not work.
 * If this plugin is enabled and these functions are also in the theme, 
 * these ones will take precedence.
 */


function nkg_acf_block_id($block)
{
    $blockName = str_replace('acf/', '', $block['name']);
    $id = '';
    $id = isset($block['anchor']) && !empty($block['anchor']) ? $block['anchor'] : $blockName . '-' . $block['id'];
    return $id;
}

function nkg_acf_block_classes($block, $classes = '')
{
    $utility_classes = get_field('utility_classes') ? ' ' . implode(' ', get_field('utility_classes')) . ' ' : '';
    $new_classes = '';
    $new_classes .= isset($block['className']) ? $block['className'] . ' ' : '';
    $new_classes .= $block['align'] ? 'align' . $block['align'] . ' ' : '';
    $new_classes .= $classes;
    $new_classes .= $utility_classes;
    return trim($new_classes);
}


/********************************
 ADVANCED CUSTOM FIELDS TINYMCE TOOLBARS
 ********************************/

function my_toolbars($toolbars)
{

    $toolbars['Full'] = array();
    $toolbars['Full'][1] = array('bold', 'italic', 'underline', 'bullist', 'numlist', 'alignleft', 'aligncenter', 'alignright', 'alignjustify', 'link', 'unlink', 'hr', 'spellchecker', 'wp_more', 'wp_adv');
    $toolbars['Full'][2] = array('styleselect', 'formatselect', 'fontselect', 'fontsizeselect', 'forecolor', 'pastetext', 'removeformat', 'charmap', 'outdent', 'indent', 'undo', 'redo', 'wp_help');

    $toolbars['Balanced'] = array();
    $toolbars['Balanced'][1] = array('bold', 'italic', 'underline', 'bullist', 'numlist', 'alignleft', 'aligncenter', 'alignright', 'alignjustify', 'link', 'unlink', 'hr', 'spellchecker', 'wp_more', 'wp_adv');
    $toolbars['Balanced'][2] = array('styleselect', 'formatselect', 'fontselect', 'fontsizeselect', 'forecolor', 'pastetext', 'removeformat', 'charmap', 'outdent', 'indent', 'undo', 'redo', 'wp_help');

    $toolbars['Minimal'] = array();
    $toolbars['Minimal'][1] = array('bold', 'italic', 'underline', 'bullist', 'numlist', 'link', 'unlink');

    // remove the 'Basic' toolbar completely (if you want)
    // unset($toolbars['Basic']);

    // return $toolbars - IMPORTANT!
    return $toolbars;
}
add_filter('acf/fields/wysiwyg/toolbars', 'my_toolbars');

/**
 * Add Gutenburg classes to outputs from WYSIWYG editors so they automatically match what is defined in theme.json
 */

add_filter('acf/format_value/type=wysiwyg', 'add_custom_classes_to_acf_wysiwyg', 10, 3);

function add_custom_classes_to_acf_wysiwyg($value, $post_id, $field)
{
    // Add class to headings
    $value = preg_replace('/<h([1-6]?)\s?([^>]*)>/', '<h$1 class="wp-block-heading" $2>', $value);

    // Add class to lists (both ordered and unordered)
    $value = preg_replace('/<(ul|ol)\s?([^>]*)>/', '<$1 class="wp-block-list" $2>', $value);

    return $value;
}
