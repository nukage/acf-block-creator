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
$acf_fields = '';


if (get_field('acf_mode') == 'child') {
    $acf_fields =  array(
        'key' => 'field_' . $acf_id,
        'label' => $acf_title,
        'name' => $acf_name,
        'aria-label' => '',
        'type' => 'textarea',
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


$classes = '';
$styles = '';

$style_builder = get_field('style_builder') ? style_builder(get_field('style_builder')) : '';

$styles .= $style_builder['style'] ?? '';

$classes .=   $style_builder['classes'] ?? '';

$classes .= ' ' . $align_class;

$classes .= ' ' . $blockClass;




$preview_text = get_field('preview_text');

if (get_field('element')) :

    // $element = '<' . get_field('element');
    // $element .= ' class="';
    // $element .= $classes;
    // $element .= '" data-acf-mode="' . $acf_mode . '"';
    // $element .= ' data-acf="' . htmlspecialchars(json_encode($acf_fields)) . '"';
    // $element .= '>';

    echo opening_tag(get_field('element'), array('class' => $classes, 'style' => $styles, 'data-acf-mode' => $acf_mode, 'data-json' => json_encode($acf_fields),   'data-acf' => json_encode($acf_fields)));
endif;
?>


<?php echo $element ?? '';
$text = get_field('generate_random_text') && get_field('text_length') ? generateLoremIpsum(get_field('text_length'), get_field('text_length')) : get_field('preview_text');


?>



<?php echo $text; ?>


</<?php echo get_field('element'); ?>>
<!-- </div> -->