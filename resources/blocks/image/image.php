<?php


// $name = get_field('name');
// $name = str_replace(' ', '', $name);
// $name = strtolower($name);

// Put all of the above in a function..

$blockName = str_replace('acf/', '', $block['name']);
$id = isset($block['anchor']) ? $block['anchor'] : $blockName . '-' . $block['id'];
// This ID will only be the same if the block's settings are identical to another block. 

// ACF FIELDS SETUP
$acf_name = get_field('acf_name');
$acf_mode = get_field('acf_mode');
$acf_id = get_field('acf_id');
$acf_instructions = get_field('acf_instructions');
$acf_title = get_field('acf_title');


if (get_field('acf_mode') == 'child') {
    $acf_fields =  array(
        'key' => 'field_' . $acf_id,
        'label' => $acf_title,
        'name' => $acf_name,
        'aria-label' => '',
        'type' => 'image',
        'instructions' => $acf_instructions,
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'return_format' => 'array',
        'library' => 'all',
        'min_width' => '',
        'min_height' => '',
        'min_size' => '',
        'max_width' => '',
        'max_height' => '',
        'max_size' => '',
        'mime_types' => '',
        'allow_in_bindings' => 0,
        'preview_size' => 'medium',
    );
}

$align_class = $block['align'] ? 'align' . $block['align'] : '';
$blockClass = '';
$blockClass = isset($block['className']) ? $block['className'] : '';


// INIT ATTR VARS

$classes = '';
$styles = '';

// INIT STYLE BUILDER

$style_builder = get_field('style_builder') ? style_builder(get_field('style_builder')) : '';
$styles .= $style_builder['style'] ?? '';
$classes .=   $style_builder['classes'] ?? '';

// ADD TYPICAL BLOCK CLASSES TO CLASS LIST

$classes .= ' ' . $align_class;
$classes .= ' ' . $blockClass;

// ADD BLOCK-SPECIFIC FIELDS

$size = get_field('thumbnail_options') ? get_field('thumbnail_options') : 'full';
$imageId = get_field('image') && get_field('image')['id'] ? get_field('image')['id'] : '';
$src = wp_get_attachment_image_url($imageId, $size, false);


if ($src) {
    echo opening_tag('img', array('src' => $src, 'class' => $classes, 'style' => $styles, 'data-acf-mode' => $acf_mode, 'data-acf' => htmlspecialchars(json_encode($acf_fields))), true);
} else {
    echo 'Please add an image.';
}
