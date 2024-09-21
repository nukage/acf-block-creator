<?php


$name = get_field('name');
$nameforId = strtolower(str_replace(' ', '-', $name));


// Put all of the above in a function..

$allowed_blocks = array('acf/column', 'core/paragraph');
// $id = isset($block) ? (empty($block['anchor']) ? wp_unique_id($name) : $block['anchor']) : wp_unique_id($name);
$blockName = str_replace('acf/', '', $block['name']);
$id = isset($block['anchor']) ? $block['anchor'] : $blockName . '-' . $block['id'];

// $acf_fields = array(
//     'key' => $id,
//     'title' => get_field('name'),


// );

// $acf_mode = get_field('acf_mode');

include dirname(__FILE__) . '/../acf-setup.php';


$align_class = $block['align'] ? 'align' . $block['align'] : '';


$blockClass = '';
$blockClass = isset($block['className']) ? $block['className'] : '';


$classes = '';

$innerClasses = '';

$classes .= ' ' . $align_class;

$classes .= ' ' . $blockClass;

$repeater = get_field('repeater') && get_field('repeater_preview') ? get_field('repeater_preview') : 1;


// Set up the class list

$innerClasses .= $nameforId ?  'blockname-' . $nameforId : '';
$innerClasses .= ' blockid-' . $id . $classes;
$innerClasses .= get_field('grid_columns') ? ' qntm-grid-cols-' . get_field('grid_columns') : '';
$innerClasses .= get_field('container_type') ? ' qntm-' . get_field('container_type') : '';
$innerClasses .= get_field('flex_direction') ? ' qntm-flex-' . get_field('flex_direction') : '';
$innerClasses .= get_field('flex_justification') ? ' qntm-flex-' . get_field('flex_justification') : '';
$innerClasses .= get_field('flex_wrap') ? ' qntm-flex-' . get_field('flex_wrap') : '';


// Build the opening tag

$openingTag = '<div id="' . $id . '" class="' . trim($classes) . '" ';
$openingTag .=  $acf_mode ? 'data-acf-mode="' . trim($acf_mode) . '"' : '';



$openingTag .= $acf_mode == 'parent' &&  $acf_fields ? "data-acf='" . json_encode($acf_fields) . "'" : '';
$openingTag .= '>';

echo $openingTag; ?>

<!-- <php  for ($i = 0; $i < $repeater; $i++) { -->
<?php for ($i = 0; $i < $repeater; $i++) { ?>
    <?php echo '<InnerBlocks class="' . trim($innerClasses) . '"  />'; ?>
<?php } ?>
<!-- <php }  ?>-->

</div>