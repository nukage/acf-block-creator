<?php



// $css =  plugin_dir_url(__FILE__) . '/../../css/app.css';

// function gutenberg_css($css)
// {

//     wp_enqueue_style('editor-font-css', $css, []);
// }


// function enqueue_css($css)
// {
//     wp_register_style('google-fonts', $css, array(), null, 'all');
//     wp_enqueue_style('google-fonts');
// }

// add_action('enqueue_block_editor_assets', function () use ($css) {
//     gutenberg_css($css);
// });

// add_action('wp_enqueue_scripts', function () use ($css) {
//     enqueue_css($css);
// });




function my_plugin_enqueue_script()
{
    wp_enqueue_script('my-plugin-script', plugins_url('/js/app.js', __FILE__), array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'my_plugin_enqueue_script');


// function nkg_block_editor_script()
// {
//     // Register the block editor script.
//     wp_register_script('nkg-editor-script', plugins_url('/js/block-editor.js', __FILE__), ['wp-blocks', 'wp-edit-post']);
//     // register block editor script.
//     register_block_type('nkg/editor-script', [
//         'editor_script' => 'nkg-editor-script',
//     ]);
// }
// add_action('enqueue_block_editor_assets', 'nkg_block_editor_script');


function nkg_block_editor_script()
{
    wp_enqueue_script('nkg-editor-script', plugins_url('/js/block-editor.js', __FILE__));
}
add_action('enqueue_block_editor_assets', 'nkg_block_editor_script');



// function my_plugin_enqueue_editor_styles()
// {
//     wp_enqueue_block_editor_asset('my-plugin/editor-styles', plugin_dir_url(__FILE__) . 'css/app.css');
// }
// add_action('enqueue_block_editor_assets', 'my_plugin_enqueue_editor_styles');

// ================== STYLE BUILDER ==================

// $style_builder = get_field('style_builder');
// echo '<pre>';
// var_dump($style_builder);
// echo '</pre>';

// $builder_classes = '';
// $builder_style = '';

// foreach ($style_builder as $style_block) {

//     if ($style_block['acf_fc_layout'] == 'class_list') {

//         $builder_classes .= ' ' . $style_block['class_list'];
//     }
// }

// return array(trim($builder_classes), trim($builder_style));







// ================== HELPER FUNCTIONS FOR EASIER CODE WRITING ==================


/**
 * Generate an opening HTML tag with attributes
 *
 * @param string $elem The tag name (e.g. 'div', 'p', 'span', etc.)
 * @param array $attrs An array of attributes to add to the tag, with keys as the attribute name and values as the attribute value
 * @param bool $self_closing Whether the tag should be self-closing or not
 *
 * @return string The generated opening HTML tag
 */
function opening_tag(string $elem = 'div', array $attrs = array(), bool $self_closing = false)
{

    $json_attrs = array('data-acf', 'data-json', 'data-block-json');
    $tag = '<' . $elem;
    foreach ($attrs as $key => $value) {
        $tag .= ' ' . $key . (in_array($key, $json_attrs, true) ? "='" . trim($value) . "'" : "=\"" . trim($value) . '"');
    }
    $tag .= $self_closing ? ' />' : '>';
    return $tag;
}








function generateLoremIpsum($minLength = 50, $maxLength = 100)
{
    $loremIpsum = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
    $words = explode(' ', $loremIpsum);
    $randomLength = rand($minLength, $maxLength);
    $randomText = '';
    for ($i = 0; $i < $randomLength; $i++) {
        $randomText .= $words[array_rand($words)] . ' ';
    }
    return trim($randomText);
}


function my_get_theme_json()
{

    // Fetch the global theme.json settings
    $theme_settings = wp_get_global_settings();
    // echo '<pre>';
    // var_dump(get_intermediate_image_sizes());
    // var_dump($theme_settings['custom']['fontWeight']);
    // echo '</pre>';
    // Check if the spacing settings exist
    if (isset($theme_settings['spacing']['spacingSizes']['theme'])) {
        $spacing_options = $theme_settings['spacing']['spacingSizes']['theme'];
    } else {
        $spacing_options = array(); // Fallback if no spacing options are found
    }

    // Output the spacing options in a select box
    if (! empty($spacing_options)) {
        echo '<select name="spacing-options">';
        foreach ($spacing_options as $spacing) {
            echo '<option value="' . esc_attr($spacing['slug']) . '">' . esc_html($spacing['name']) . '</option>';
        }
        echo '</select>';
    } else {
        echo 'No spacing options found.';
    }
}
