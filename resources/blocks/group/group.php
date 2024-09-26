<?php

// Get plugin options
$dev = !get_field('nkg_render_mode', 'option');
$css_mode =  get_field('css_mode', 'option') ? get_field('css_mode', 'option') : '';




$name = get_field('name');
$nameforId = strtolower(str_replace(' ', '-', $name));


// Put all of the above in a function..

$allowed_blocks = array('acf/column', 'core/paragraph');
// $id = isset($block) ? (empty($block['anchor']) ? wp_unique_id($name) : $block['anchor']) : wp_unique_id($name);
$blockName = str_replace('acf/', '', $block['name']);
$id = isset($block['anchor']) ? $block['anchor'] : $blockName . '-' . $block['id'];
// This ID will only be the same if the block's settings are identical to another block. This would be a great way to de-dupe ACF fields if you had a repeater block for instance.  





// ACF FIELDS SETUP
$acf_name = get_field('acf_name'); // name-of-block
$acf_mode = get_field('acf_mode'); // parent/child
$acf_id = get_field('acf_id'); // group_15315142534534
$acf_description = get_field('acf_description'); // Description of block
$acf_title = get_field('acf_title'); // Title of Block
$acf_category = get_field('acf_category') ?  get_field('acf_category') : 'nkg-blocks'; // get_field('acf_category'); Need to add this as option
$acf_single_title = get_field('acf_single_title')  ? get_field('acf_single_title') : 'Item';
$acf_repeater_layout = get_field('acf_repeater_layout') ? get_field('acf_repeater_layout') : 'block';



if ($acf_mode == 'parent') {

    $message =   array(
        'key' => 'field_message_' . $acf_id,
        'label' => $acf_title,
        'name' => 'message_' . $acf_name,
        'aria-label' => '',
        'type' => 'message',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'message' => $acf_description,
        'new_lines' => 'wpautop',
        'esc_html' => 0,
    );


    $acf_fields = array(
        'key' =>  'group_' . $acf_id,
        'title' => $acf_title,
        'fields' => array($message),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/' . $acf_name,
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => $acf_description,
        'show_in_rest' => 0,



    );

    $block_json = array(
        'name' => 'acf/' . $acf_name,
        'title' => $acf_title,
        'description' => $acf_description,
        'category' => $acf_category,
        'acf' => array(
            'mode' => 'preview',
            'renderTemplate' => $acf_name . '.php',
        ),
        "supports" => array(
            "align" => true,
            "anchor" => true,
        )
    );
} else if ($acf_mode == 'repeater') {

    $acf_fields =   array(
        'key' => 'field_' . $acf_id,
        'label' => $acf_title,
        'name' => $acf_name,
        'aria-label' => '',
        'type' => 'repeater',
        'instructions' => $acf_description,
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'layout' => $acf_repeater_layout,
        'pagination' => 0,
        'min' => 0,
        'max' => 0,
        'collapsed' => '',
        'button_label' => 'Add ' . $acf_single_title,
        'rows_per_page' => 20,
        'sub_fields' => array(),
    );
}

// include dirname(__FILE__) . '/../acf-setup.php';


$align_class = $block['align'] ? 'align' . $block['align'] : '';


$blockClass = '';
$blockClass = isset($block['className']) ? $block['className'] : '';


$classes = ' ';

$style_builder = get_field('style_builder') ? style_builder(get_field('style_builder')) : '';

$theme_classes = $style_builder &&  $style_builder['classes'] ?  $style_builder['classes'] . ' ' : '';


// INIT ATTR VARS

$innerClasses = '';
$innerStyles = '';

// $innerClasses .= $acf_name ?   'block-name__' . $acf_name . ' ' : '';



// ADD TYPICAL BLOCK CLASSES TO CLASS LIST

$innerClasses .= ' ' . $align_class;
// $innerClasses .= ' ' . $blockClass;


$repeater = get_field('acf_mode') == 'repeater' && get_field('repeater_preview') && !is_admin()  ? get_field('repeater_preview') : 1;


// Set up the class list

$innerClasses .= $acf_name ?  $acf_name . ' ' : '';
// $innerClasses .= 'blockid-' . $id  . ' ';
$theme_classes .= get_field('grid_columns') ? 'grid-cols-' .   get_field('grid_columns') . ' ' : '';
$theme_classes .= get_field('container_type') && get_field('container_type') !== 'default' ?  get_field('container_type') . ' ' : '';
$theme_classes .= get_field('flex_direction') ?  get_field('flex_direction') . ' ' : '';
$theme_classes .= get_field('flex_justification') ?  get_field('flex_justification') . ' ' : '';
$theme_classes .= get_field('flex_wrap') ?  get_field('flex_wrap') . ' ' : '';

$theme_classes .= get_field('spacing_options') ?  'gap-' . get_field('spacing_options') . ' ' : '';

// Set up Grid

$gridClasses = '';
$gridStyles = '';
if (get_field('container_type') == 'grid') {
    // $gridClasses = "grid "; // grid class would already be added above
    if (get_field('grid_mode') == 'Manual' && get_field('grid_columns')) {
        $gridClasses .= "grid-cols-" . get_field('grid_columns') . " ";
    } else if (get_field('grid_mode') == 'Auto' && get_field('grid_column_width')) {
        $gridClasses .= "grid-cols-[repeat(auto-fill,minmax(min(" . get_field('grid_column_width') . ",100%),1fr))] ";
        $gridStyles .= "grid-template-columns: repeat(auto-fill,  minmax(min(" . get_field('grid_column_width') . ", 100%), 1fr));";
    } else if (get_field('grid_mode') == 'Custom' && get_field('grid_template_columns')) {
        $gridClasses .= "grid-cols-[" . str_replace(' ', '', get_field('grid_template_columns')) . "] ";
        $gridStyles .= "grid-template-columns: " . get_field('grid_template_columns') . ";";
    }
}
// Add them to the tag
$theme_classes .= $gridClasses;
$innerStyles .= $gridStyles;

// INIT STYLE BUILDER

$style_builder = get_field('style_builder') ? style_builder(get_field('style_builder')) : '';
$innerStyles .= $style_builder['style'] ?? '';
$innerClasses .=   $style_builder['classes'] ?? '';

$innerClasses .= $repeater > 1 && $dev ? ' acf-repeater-clone' : '';


// Build the opening tag

$openingTag = '<div class="nkg-group-hidden" id="' . $id . '" ';
$openingTag .=  $acf_mode ? 'data-acf-mode="' . trim($acf_mode) . '"' : '';
$openingTag .= $acf_name ? 'data-name="' . trim($acf_name) . '"' : '';



$openingTag .= $acf_mode !== 'none' &&  $acf_fields ? "data-acf='" . json_encode($acf_fields) . "'" : '';
$openingTag .= isset($theme_classes) && $theme_classes ? 'data-classes="' . trim($theme_classes) . '" ' : '';
$openingTag .= isset($block_json) && $block_json ? " data-block='" . json_encode($block_json) . "'" : '';
$openingTag .= $dev ? 'data-style="' . trim($innerStyles) . '" ' : '';
$openingTag .= 'style="display:none;">';

// $innerClasses = !$dev && $css_mode && $acf_name ? $acf_name : $innerClasses;

if (!$dev && $css_mode && $acf_name) {
    // If its render mode, and CSS mode, just use the name as the class
    $innerClasses = $acf_name;
}

if (!$dev && !$css_mode) {
    // If its not dev mode and not css extract mode, add the theme classes to the class list
    $innerClasses .= ' ' . $theme_classes;
}
if ($dev) {
    // If it is dev mode, add the theme classes in. 
    $innerClasses .= ' ' . $theme_classes;
}



// echo !$dev && $css_mode && $acf_name ? '$acf_name' : '$innerClasses';
// echo $innerClasses;

// var_dump($innerClasses);
// echo '</pre>';

if (!$dev && $acf_mode == 'parent') : ?>

    <h4>Block: <?php echo $acf_name; ?>.php</h4>
    <hr>
    <pre data-name="<?php echo $acf_name; ?>">
        </pre>
<?php endif;



echo $openingTag . '</div>' ?>
<?php if ($acf_mode == 'repeater'  && !$dev) : ?>
    <!--<php if ( have_rows('<?php echo $acf_name; ?>') ) : while( have_rows('<?php echo $acf_name; ?>') ) : the_row(); ?>-->
    <?php $repeater = 1; // If not dev mode, just one instance of repeater HTML 
    ?>
<?php endif; ?>
<?php for ($i = 0; $i < $repeater; $i++) { ?>

    <?php
    echo '<InnerBlocks class="' . trim($innerClasses) . '"  />'; ?>
    <?php if ($acf_mode == 'repeater'  && !$dev) : ?>
        <!-- <php  endwhile; endif; ?>-->
    <?php endif; ?>
<?php }
