<?php

$dev = !get_field('nkg_render_mode', 'option'); // DEV MODE (TRUE/FALSE)
$dev = $is_preview ? true  : $dev;


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
$acf_fields = array();

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

// ADD TYPICAL BLOCK CLASSES TO CLASS LIST

$classes .= $acf_name ?  $acf_name . ' ' : '';
$classes .= ' ' . $align_class;
$classes .= ' ' . $blockClass;

// INIT STYLE BUILDER

$style_builder = get_field('style_builder') ? style_builder(get_field('style_builder')) : '';
$styles .= $style_builder['style'] ?? '';
$theme_classes =   $style_builder['classes'] ?? '';


// CREATE HIDDEN TAG

$hidden_tag_attrs = array('style' => 'display:none;', 'class' => 'nkg-hidden');
$hidden_tag_attrs['data-acf-mode'] = $acf_mode;
$hidden_tag_attrs['data-acf'] = htmlspecialchars(json_encode($acf_fields));
$hidden_tag_attrs['data-name'] = $acf_name;
$hidden_tag_attrs['data-classes'] = $theme_classes;
echo opening_tag('div', $hidden_tag_attrs) . '</div>';

// ADD BLOCK-SPECIFIC FIELDS

$size = get_field('thumbnail_options') ? get_field('thumbnail_options') : 'full';
$imageId = '';
// $imageId = get_field('use_random_image') ? nkg_get_random_image()['id'] :  '';
if (get_field('use_random_image')) {
    $imageId = nkg_get_random_image()['id'];
} else if (get_field('image')) {
    $imageId = get_field('image');
}

$src = wp_get_attachment_image_url($imageId, $size, false);

$opening_tag_attrs = array('src' => $src, 'class' => $classes);
if ($dev) {
    $opening_tag_attrs['style'] = $styles;
} elseif ($acf_mode === 'php') {
    if (get_field('php_setup')) { ?>
        <!--<php  <?= get_field('php_setup') ?> ?>-->
    <?php  } ?>
    <!--<php   echo wp_get_attachment_image(<?= get_field('content_variable') ?>, '<?= $size ?>', false, array('class'=>'<?= trim($classes . ' ' . $theme_classes) ?>')); ?>-->
<?php } else { ?>
    <!--<php   echo wp_get_attachment_image(get_field('<?= $acf_name ?>'), '<?= $size ?>', false, array('class'=>'<?= trim($classes . ' ' . $theme_classes) ?>')); ?>-->
<?php }

if ($src && $dev) {
    echo opening_tag('img', $opening_tag_attrs, true);
} elseif ($dev) {
    echo 'Please add an image.';
}
