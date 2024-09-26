<?php

$dev = !get_field('nkg_render_mode', 'option'); // DEV MODE (FALSE/TRUE) -  
$css_mode =  get_field('css_mode', 'option') ? get_field('css_mode', 'option') : '';


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




$preview_text = get_field('preview_text');

// CREATE HIDDEN TAG

$hidden_tag_attrs = array('style' => 'display:none;', 'class' => 'nkg-hidden');
$hidden_tag_attrs['data-acf-mode'] = $acf_mode;
$hidden_tag_attrs['data-acf'] = htmlspecialchars(json_encode($acf_fields));
$hidden_tag_attrs['data-name'] = $acf_name;
$hidden_tag_attrs['data-classes'] = isset($theme_classes) && $theme_classes ? $theme_classes : '';

// Add Hidden Tag to DOM
echo opening_tag('div', $hidden_tag_attrs) . '</div>';

if (get_field('element')) :


    $opening_tag_attrs = $css_mode ? array('class' => $acf_name) : array('class' => $classes . ' ' . $theme_classes);
    if ($dev) {
        // Adding styles for Dev mode only
        $opening_tag_attrs['style'] = $styles;
        echo opening_tag(get_field('element'), $opening_tag_attrs);
    }
endif;
?>


<?php echo $element ?? '';
if ($dev) {
    echo  get_field('generate_random_text') && get_field('text_length') ? generateLoremIpsum(get_field('text_length'), get_field('text_length')) : get_field('preview_text');
} else { ?>

    <!--<php  echo get_field('<?= $acf_name ?>') ? '<?= opening_tag(get_field('element'), $opening_tag_attrs) ?>' . get_field('<?= $acf_name ?>') . '</<?= get_field('element') ?>>' : ''; ?>-->

<?php }


?>





</<?php echo $dev ? get_field('element') : ''; ?>>