<?php

// Get plugin options
$dev = !get_field('nkg_render_mode', 'option');
$css_mode = !$dev && get_field('css_mode', 'option') ? get_field('css_mode', 'option') : '';
$dev = $is_preview ? true  : $dev;




$name = get_field('name');
$nameforId = strtolower(str_replace(' ', '-', $name));


// Put all of the above in a function..


// $id = isset($block) ? (empty($block['anchor']) ? wp_unique_id($name) : $block['anchor']) : wp_unique_id($name);
$blockName = str_replace('acf/', '', $block['name']);
$id = isset($block['anchor']) ? $block['anchor'] : $blockName . '-' . $block['id'];
// This ID will only be the same if the block's settings are identical to another block. This would be a great way to de-dupe ACF fields if you had a repeater block for instance.  

// ALLOWED ACF BLOCKS
$allowed_blocks = array('acf/nkg-image', 'acf/nkg-textarea', 'acf/nkg-group', 'acf/nkg-link', 'acf/nkg-code');


// ACF FIELDS SETUP
$acf_name = get_field('acf_name'); // name-of-block
$acf_mode = get_field('acf_mode'); // parent/child
$acf_id = get_field('acf_id'); // group_15315142534534
$acf_description = get_field('acf_description'); // Description of block
$acf_title = get_field('acf_title'); // Title of Block
$acf_single_title = get_field('acf_single_title')  ? get_field('acf_single_title') : 'Item';
$acf_repeater_layout = get_field('acf_repeater_layout') ? get_field('acf_repeater_layout') : 'block';
$acf_script = get_field('acf_script');
$acf_script_dependencies = get_field('acf_script_dependencies');


$acf_fields = false;



if ($acf_mode == 'parent') {

    $acf_category = get_field('acf_category') ?  get_field('acf_category') : 'nkg-blocks'; // get_field('acf_category'); Need to add this as option
    $acf_icon = get_field('acf_icon');
    $acf_supports = get_field('acf_supports');

    // echo '<pre>';
    // var_dump($acf_supports);
    // echo '</pre>';


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
        'icon' => $acf_icon,
        'acf' => array(
            'mode' => 'preview',
            'renderTemplate' => $acf_name . '.php',
        ),
        "supports" => array(
            "align" => $acf_supports && in_array('Align', $acf_supports)  ? array("full", "wide", "none") : false,
            "anchor" => $acf_supports && in_array('Anchor', $acf_supports)  ? true : false,
            "customClassName" => $acf_supports && in_array('Class', $acf_supports)  ? true : false,
            "jsx" => false
        ),
        "dependencies" => $acf_script_dependencies,
    );

    if ($acf_supports && in_array('Script', $acf_supports)) {
        $block_json['script'] = $acf_name;
    }
    if ($acf_supports && in_array('Style', $acf_supports)) {
        $block_json['style'] = $acf_name;
    }

    if ($acf_supports && in_array('Utility Classes', $acf_supports)) {

        $acf_utilty_classes_choices = get_field('acf_utility_classes')
            ? array_column(get_field('acf_utility_classes'), 'class_label', 'class_name') : array();



        $acf_utility_classes =  array(
            'key' => 'utility_classes_' . $acf_id,
            'label' => 'Style Classes',
            'name' => 'utility_classes',
            'aria-label' => '',
            'type' => 'select',
            'instructions' => 'Select additional style options here.',
            'required' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'choices' => $acf_utilty_classes_choices,
            'default_value' => array(),
            'return_format' => 'value',
            'multiple' => 1,
            'allow_null' => 0,
            'allow_in_bindings' => 0,
            'ui' => 1,
            'ajax' => 0,
            'placeholder' => '',
        );
        array_push($acf_fields['fields'], $acf_utility_classes);
    }




    // echo '<pre>' . var_dump($block_json) . '</pre>';
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
$align_class = !$dev && isset($acf_supports) && in_array('Align', $acf_supports) ? '' : $align_class; // If its render mode and Align is not supported, remove the align class from the block.


$blockClass = '';
$blockClass = isset($block['className']) ? $block['className'] : '';


$classes = ' ';
$innerStyles = '';
$innerClasses = '';
// ADD TYPICAL BLOCK CLASSES TO CLASS LIST
$innerClasses .= $acf_name ?  $acf_name . ' ' : '';
$innerClasses .= ' ' . $align_class;

// INIT STYLE BUILDER
$style_builder = get_field('style_builder') ? style_builder(get_field('style_builder')) : '';
$innerClasses .=  isset($style_builder['wp_classes']) ? ' ' . $style_builder['wp_classes'] : '';
$theme_classes = $style_builder &&  $style_builder['classes'] ?  $style_builder['classes'] . ' ' : '';



$innerStyles .= $style_builder['style'] ?? '';

$attributes = $style_builder['attributes'] ?? false;

if ($acf_mode == 'link') {
    $attributes['href'] =    '#';
    if (get_field('link_var') && !$dev) {
        $attributes['href'] =  'php echo ' . get_field('link_var') . ';';
    }
}






$repeater = (get_field('acf_mode') == 'repeater' || get_field('acf_mode') == "query") && get_field('repeater_preview') && !is_admin()  ? get_field('repeater_preview') : 1;


// Set up the class list


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
        $gridClasses .= "grid-cols-[" . str_replace(' ', ',', get_field('grid_template_columns')) . "] ";
        $gridStyles .= "grid-template-columns: " . get_field('grid_template_columns') . ";";
    }
}
// Add them to the tag
$theme_classes .= $gridClasses;
$innerStyles .= $gridStyles;



$innerClasses .= $repeater > 1 && $dev ? ' acf-repeater-clone' : '';







// $innerClasses = !$dev && $css_mode && $acf_name ? $acf_name : $innerClasses;

if (!$dev && $css_mode && $acf_name) {
    // If its render mode, and CSS mode, just use the name as the class
    // $innerClasses = $acf_name;  < no this was a bad idea because we lost the align class
} else if (!$dev && !$css_mode) {
    // If its not dev mode and not css extract mode, add the theme classes to the class list
    $innerClasses .= ' ' . $theme_classes;
} else if ($dev) {
    // If it is dev mode, add the theme classes in. 
    $innerClasses .= ' ' . $theme_classes;
}


// If block is parent and its render mode, AND class or anchor are supported, add these special class and anchor functions

if (isset($acf_supports) && $acf_mode == 'parent' && !$dev) {
    if (in_array('Anchor', $acf_supports)) {
        $attributes['id'] =    'php echo nkg_acf_block_id($block);';
    }
    if (in_array('Class', $acf_supports) || in_array('Align', $acf_supports) || in_array('Utility Classes', $acf_supports)) {   // This function used for both classes and align
        $attributes['class'] =    'php echo nkg_acf_block_classes($block,\"' . $innerClasses . '\");';
    }
}


// Build the opening tag



$openingTag = '<div class="nkg-group-hidden" id="' . $id . '" ';
$openingTag .=  $acf_mode ? 'data-acf-mode="' . trim($acf_mode) . '"' : '';
$openingTag .= $acf_name ? 'data-name="' . trim($acf_name) . '"' : '';
$openingTag .= $acf_mode == 'link' ? 'data-element="a" ' : 'data-element="div" ';

$openingTag .= $attributes ? "data-attributes='" . json_encode($attributes) . "' " : '';
$openingTag .= $acf_fields ? "data-acf='" . json_encode($acf_fields) . "'" : '';
$openingTag .= isset($theme_classes) && $theme_classes ? 'data-classes="' . trim($theme_classes) . '" ' : '';
$openingTag .= isset($block_json) && $block_json ? " data-block='" . json_encode($block_json) . "'" : '';
$openingTag .= $dev ? 'data-style="' . trim($innerStyles) . '" ' : '';
$openingTag .= 'style="display:none;">';

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



echo $openingTag . '</div>';



?>





<?php if (($acf_mode == 'repeater' || $acf_mode == 'query' || $acf_mode == 'link')  && !$dev) : ?>

    <?php if ($acf_mode == 'repeater') : ?>
        <!--<php if ( have_rows('<?php echo $acf_name; ?>') ) : while( have_rows('<?php echo $acf_name; ?>') ) : the_row(); ?>-->
    <?php endif; ?>
    <?php if ($acf_mode == 'query' || $acf_mode == 'link') : ?>
        <!--<php    <?php echo get_field('query_loop_php'); ?> ?>-->
    <?php endif; ?>
    <?php if ($acf_mode == 'query') : ?>
        <!--<php  if ( $the_query->have_posts() ) : while( $the_query->have_posts() ) :  $the_query->the_post();  ?>-->
    <?php endif; ?>

    <?php $repeater = 1; // If not dev mode, just one instance of repeater HTML 
    ?>
<?php endif; ?>
<?php for ($i = 0; $i < $repeater; $i++) { ?>

    <?php
    echo '<InnerBlocks allowedBlocks="' . esc_attr(wp_json_encode($allowed_blocks)) . '" class="' . trim($innerClasses) . '"  />'; ?>
    <?php if (($acf_mode == 'repeater' || $acf_mode == 'query')  && !$dev) : ?>
        <!-- <php  endwhile; endif;  <?= $acf_mode = 'query' ? 'wp_reset_postdata();' : '' ?> ?>-->
    <?php endif; ?>
<?php }
echo $acf_script ? '<script>' . $acf_script . '</script>' : '';
