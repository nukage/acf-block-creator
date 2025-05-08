<?php



$dev = !get_field('nkg_render_mode', 'option');
$dev = $is_preview ? true  : $dev;
$css_mode =  !$dev && get_field('css_mode', 'option') ? get_field('css_mode', 'option') : '';

$blockName = str_replace('acf/', '', $block['name']);
$id = isset($block['anchor']) ? $block['anchor'] : $blockName . '-' . $block['id'];

// NAME SETUP
$acf_name = get_field('acf_name');


$acf_mode = get_field('acf_mode');
$acf_id = get_field('acf_id');
$acf_instructions = get_field('acf_instructions');
$acf_title = get_field('acf_title');
$acf_fields = '';



// This doesn't work if the block is inside of a synced pattern, when this is on the front-end,
// making the context thing kind of useless...
// if ($acf_parent_name && !$acf_id && $acf_mode == 'child') {
//     if (strpos($acf_parent_name, '__') !== false) {
//         $acf_name = $acf_parent_name . '-' . $acf_name;
//     } else {
//         $acf_name = $acf_parent_name . '__' . $acf_name;
//     }
// }
// echo 'NAME:';
// echo $acf_name;
// var_dump($context);

if (get_field('acf_mode') == 'child') {
    $acf_fields =  array(
        'key' => 'field_' . $acf_id,
        'label' => $acf_title,
        'name' => $acf_name,
        'aria-label' => '',
        'type' => 'link',
        'instructions' => $acf_instructions,
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'default_value' => '',
        'maxlength' => '',
        'allow_in_bindings' => 0,
        'rows' => '',
        'placeholder' => '',
        'new_lines' => '',
    );
}

$align_class = $block['align'] ? 'align' . $block['align'] : '';
$blockClass = '';
$blockClass = isset($block['className']) ? $block['className'] : '';

// INIT ATTR VARS

$classes = '';
$styles = '';

// ADD TYPICAL BLOCK CLASSES TO CLASS LIST

$classes .= $acf_name ?  $acf_name . ' ' : '';
$classes .= ' ' . $align_class;
$classes .= ' ' . $blockClass;

// INIT STYLE BUILDER

$style_builder = get_field('style_builder') ? style_builder(get_field('style_builder')) : '';
$styles .= $style_builder['style'] ?? '';
$theme_classes =   $style_builder['classes'] ?? '';
$attributes = $style_builder['attributes'] ?? false;
$classes .=  isset($style_builder['wp_classes']) ? ' ' . $style_builder['wp_classes'] : '';




// CREATE HIDDEN TAG

$hidden_tag_attrs = array('style' => 'display:none;', 'class' => 'nkg-hidden');
$hidden_tag_attrs['data-acf-mode'] = $acf_mode;
$hidden_tag_attrs['data-acf'] = htmlspecialchars(json_encode($acf_fields));
$hidden_tag_attrs['data-name'] = $acf_name;
$hidden_tag_attrs['data-classes'] = isset($theme_classes) && $theme_classes ? $theme_classes : '';
$hidden_tag_attrs['data-attributes'] = isset($attributes) ?  json_encode($attributes) : '';
if (!$acf_id && $acf_mode == 'child') {
    $hidden_tag_attrs['data-acf-id'] = 'inherit';
}
// Add Hidden Tag to DOM
echo opening_tag('div', $hidden_tag_attrs) . '</div>';

// UNIQUE CLASSES
$link = get_field('link');

$tag_classes = $css_mode ? array('class' => $acf_name) : array('class' => $classes . ' ' . $theme_classes);

$opening_tag_attrs = $tag_classes;
$opening_tag_attrs['target'] = $link['target'] ? $link['target'] : '_self';
$opening_tag_attrs['href'] = $link['url'] ? $link['url'] : '';

$title = (get_field('generate_random_text') && get_field('text_length')) ? generateLoremIpsum(get_field('text_length'), get_field('text_length')) : ($link['title'] ? $link['title'] : '');
if ($dev) {
    // Adding styles for Dev mode only
    $opening_tag_attrs['style'] = $styles;
}


if ($link) {
    if ($dev) {

        echo opening_tag('a', $opening_tag_attrs);
        echo $title;
        echo '</a>';
    } else { ?>
        <!--
        <php $link = get_field('<?php echo $acf_name ?>'); ?>
        <php $link_target = $link && $link['target'] ? $link['target'] : '_self';?>
        <php $link_url = $link && $link['url'] ? $link['url'] : '';?>
        <php $link_title = $link && $link['title'] ? $link['title'] : '';?>        
        <php echo '<a href="' . $link_url . '" target="'.$link_target.'" class="<?= implode(' ', $tag_classes); ?>">'.$link_title.'</a>'; ?>-->
<? }
}
