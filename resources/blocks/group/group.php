<?php


$name = get_field('name');
$nameforId = strtolower(str_replace(' ', '-', $name));


// Put all of the above in a function..

$allowed_blocks = array('acf/column', 'core/paragraph');
// $id = isset($block) ? (empty($block['anchor']) ? wp_unique_id($name) : $block['anchor']) : wp_unique_id($name);
$blockName = str_replace('acf/', '', $block['name']);
$id = isset($block['anchor']) ? $block['anchor'] : $blockName . '-' . $block['id'];
// This ID will only be the same if the block's settings are identical to another block. This would be a great way to de-dupe ACF fields if you had a repeater block for instance.  


// ACF FIELDS SETUP
$acf_name = get_field('acf_name');
$acf_mode = get_field('acf_mode');
$acf_id = get_field('acf_id');
$acf_description = get_field('acf_description');
$acf_title = get_field('acf_title');

if ($acf_mode == 'parent') {


    $acf_fields = array(
        'key' =>  'group_' . $acf_id,
        'title' => $acf_title,
        'fields' => array(),
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
}

// include dirname(__FILE__) . '/../acf-setup.php';


$align_class = $block['align'] ? 'align' . $block['align'] : '';


$blockClass = '';
$blockClass = isset($block['className']) ? $block['className'] : '';


$classes = ' ';

$style_builder = get_field('style_builder') ? style_builder(get_field('style_builder')) : '';

$classes .=   $style_builder['classes'] ?? '';


// INIT ATTR VARS

$innerClasses = '';
$innerStyles = '';



// ADD TYPICAL BLOCK CLASSES TO CLASS LIST

$innerClasses .= ' ' . $align_class;
$innerClasses .= ' ' . $blockClass;


$repeater = get_field('acf_mode') == 'repeater' && get_field('repeater_preview') && !is_admin() ? get_field('repeater_preview') : 1;


// Set up the class list

$innerClasses .= $nameforId ?  'blockname-' . $nameforId . ' ' : '';
$innerClasses .= 'blockid-' . $id  . ' ';
$innerClasses .= get_field('grid_columns') ? 'grid-cols-' .   get_field('grid_columns') . ' ' : '';
$innerClasses .= get_field('container_type') ?  get_field('container_type') . ' ' : '';
$innerClasses .= get_field('flex_direction') ?  get_field('flex_direction') . ' ' : '';
$innerClasses .= get_field('flex_justification') ?  get_field('flex_justification') . ' ' : '';
$innerClasses .= get_field('flex_wrap') ?  get_field('flex_wrap') . ' ' : '';

$innerClasses .= get_field('spacing_options') ?  'gap-' . get_field('spacing_options') . ' ' : '';

// Set up Grid

$gridClasses = '';
$gridStyles = '';
if (get_field('container_type') == 'grid') {
    // $gridClasses = "grid "; // grid class would already be added above
    if (get_field('grid_mode') == 'Manual' && get_field('grid_columns')) {
        $gridClasses .= "grid-cols-" . get_field('grid_columns') . " ";
    } else if (get_field('grid_mode') == 'Auto' && get_field('grid_column_width')) {
        $gridClasses .= "grid-cols-[repeat(auto-fill,minmax(min(" . get_field('grid_column_width') . ",100%),1fr] ";
        $gridStyles .= "grid-template-columns: repeat(auto-fill,  minmax(min(" . get_field('grid_column_width') . ", 100%), 1fr));";
    } else if (get_field('grid_mode') == 'Custom' && get_field('grid_template_columns')) {
        $gridClasses .= "grid-cols-[" . str_replace(' ', '', get_field('grid_template_columns')) . "] ";
        $gridStyles .= "grid-template-columns: " . get_field('grid_template_columns') . ";";
    }
}
// Add them to the tag
$innerClasses .= $gridClasses;
$innerStyles .= $gridStyles;

// INIT STYLE BUILDER

$style_builder = get_field('style_builder') ? style_builder(get_field('style_builder')) : '';
$innerStyles .= $style_builder['style'] ?? '';
$innerClasses .=   $style_builder['classes'] ?? '';


// Build the opening tag

$openingTag = '<div class="nkg-group-hidden" id="' . $id . '" ';
$openingTag .=  $acf_mode ? 'data-acf-mode="' . trim($acf_mode) . '"' : '';



$openingTag .= $acf_mode == 'parent' &&  $acf_fields ? "data-acf='" . json_encode($acf_fields) . "'" : '';
$openingTag .= 'data-style="' . trim($innerStyles) . '" ';
$openingTag .= 'style="display:none;">';

// echo '<pre>';
// var_dump($innerClasses);
// echo '</pre>';


echo $openingTag . '</div>' ?>
<?php if ($repeater > 1) : ?>
    <!-- <php // Repeater Start
$nameforId= get_field('<?php echo $nameforId; ?>'); 
for ($i = 0; $i < $nameforId; $i++) {  ?>-->
<?php endif; ?>
<?php for ($i = 0; $i < $repeater; $i++) { ?>
    <?php echo '<InnerBlocks class="' . trim($innerClasses) . '"  />'; ?>
    <?php if ($repeater > 1 && $i == 0) : ?>
        <!-- <php } // Repeater End ?>-->
    <?php endif; ?>

<?php } ?>