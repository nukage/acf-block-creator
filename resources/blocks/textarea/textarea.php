<?php


$name = get_field('name');
$name = str_replace(' ', '', $name);
$name = strtolower($name);

// Put all of the above in a function..

$allowed_blocks = array('acf/column', 'core/paragraph');
$id = isset($block) ? (empty($block['anchor']) ? wp_unique_id($name) : $block['anchor']) : wp_unique_id($name);


include dirname(__FILE__) . '/../acf-setup.php';

$align_class = $block['align'] ? 'align' . $block['align'] : '';
$blockClass = '';
$blockClass = isset($block['className']) ? $block['className'] : '';


$classes = '';
$classes .= ' ' . $align_class;

$classes .= ' ' . $blockClass;




$preview_text = get_field('preview_text');

if (get_field('element')) :

    $element = '<' . get_field('element');
    $element .= ' class="';
    $element .= $classes;
    $element .= '" data-acf-mode="' . $acf_mode . '"';
    $element .= ' data-acf="' . htmlspecialchars(json_encode($acf_fields)) . '"';
    $element .= '>';
endif;
?>


<?php echo $element ?? '';
$text = get_field('generate_random_text') && get_field('text_length') ? generateLoremIpsum(get_field('text_length'), get_field('text_length')) : get_field('preview_text');


?>



<?php echo $text; ?>


</<?php echo get_field('element'); ?>>
<!-- </div> -->