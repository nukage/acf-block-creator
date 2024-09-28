<?php



$render_mode_css =  plugin_dir_url(__FILE__) . '/../../css/render-mode.css';

// function gutenberg_css($css)
// {

//     wp_enqueue_style('editor-font-css', $css, []);
// }



function enqueue_css($css, $cssname)
{
    wp_register_style($cssname, $css, array(), null, 'all');
    wp_enqueue_style($cssname);
}

// add_action('enqueue_block_editor_assets', function () use ($css) {
//     gutenberg_css($css);
// });

add_action('wp_enqueue_scripts', function () use ($render_mode_css) {
    enqueue_css($render_mode_css, 'render-mode');
});






function nkg_plugin_enqueue_script()
{
    wp_enqueue_script('nkg-plugin-script', plugins_url('/js/app.js', __FILE__), array('jquery'), '1.0.0', true);

    wp_register_script('alpine', "//cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js", array(), '1.0.0', array('in_footer' => false, 'strategy' => 'defer'));
}
add_action('wp_enqueue_scripts', 'nkg_plugin_enqueue_script');

function nkg_dequeue_scripts()
{
    // Get the ACF option
    $dequeue_script = get_field('nkg_render_mode', 'option');

    if ($dequeue_script) {
        wp_dequeue_script('alpine'); // Dequeue alpine so that text/classes are not rendered
    }
}
add_action('wp_enqueue_scripts', 'nkg_dequeue_scripts');



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

    $json_attrs = array('data-acf', 'data-json', 'data-block-json', 'data-attributes');
    $tag = '<' . $elem;
    foreach ($attrs as $key => $value) {
        $tag .= ' ' . $key . (in_array($key, $json_attrs, true) ? "='" . trim($value) . "'" : "=\"" . trim($value) . '"');
    }
    $tag .= $self_closing ? ' />' : '>';
    return $tag;
};




/**
 * Generates an <img> tag with the image from the given ACF image field.
 *
 * @param string $image_field The name of the ACF image field to use (default: 'image')
 * @param string $image_size The size of the image to fetch (default: 'full')
 * @param string $image_class The class attribute to add to the <img> tag (default: '')
 *
 * @return string The generated <img> tag
 */
function  nkg_create_image_tag(array $image, string $image_size = 'full', string $image_class = '')
{
    if (!$image) {
        return 'Please select an image.';
    }

    $image_id = $image && $image['id'] ? $image['id'] : '';
    $src = wp_get_attachment_image_url($image_id, $image_size, false);
    $opening_tag_attrs = $image_id ?  array('src' => $src, 'class' => $image_class) : array();
    return opening_tag('img', $opening_tag_attrs, true);
};










function generateLoremIpsum($minLength = 50, $maxLength = 100)
{

    // TODO: Output always starts with a capital letter
    $loremIpsum = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
    $words = explode(' ', $loremIpsum);
    $randomLength = rand($minLength, $maxLength);
    $randomText = '';
    for ($i = 0; $i < $randomLength; $i++) {
        if ($i == 0) {
            $randomText .= ucfirst($words[array_rand($words)]) . ' ';
        } else {
            $randomText .= $words[array_rand($words)] . ' ';
        }
    }
    return trim($randomText);
}





function add_entry_content_class_for_dev_mode($classes)
{
    $classList = '';

    if (!get_field('nkg_render_mode', 'option')) {
        $classList .= 'nkg-dev-mode'; // Replace 'your-custom-class' with your desired class namespace

    } else {

        $classes[] = 'nkg-render-mode';
        if (get_field('css_mode', 'option')) {
            $classList .= 'nkg-css-mode';
        }
    }

    $classes[] = $classList;
    return $classes;
}

function add_entry_content_class_for_dev_mode_filter()
{

    add_filter('body_class', 'add_entry_content_class_for_dev_mode');
}
add_action('acf/init', 'add_entry_content_class_for_dev_mode_filter');
