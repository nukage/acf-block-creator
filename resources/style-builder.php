<?php

/**
 * Builds a set of CSS classes and styles based on a given set of ACF style blocks.
 *
 * @param array $style_blocks The ACF style blocks to build the CSS classes and styles from.
 *
 * @return array An array containing two keys: 'classes' and 'style'. The 'classes' key contains a string of CSS
 * classes, and the 'style' key contains a string of CSS styles.
 */

function style_builder($style_blocks)
{


    $builder_classes = '';
    $builder_style = '';
    $attributes = array();

    foreach ($style_blocks as $style_block) {

        if ($style_block['acf_fc_layout'] == 'class_list') {

            $builder_classes .= ' ' . $style_block['class_list'] . ' ';
        } else if ($style_block['acf_fc_layout'] == 'spacing') {



            if ($style_block['spacing_side']) {
                $spacingSides = $style_block['spacing_side'];


                if (in_array('t',  $spacingSides) && in_array('b',  $spacingSides)) {
                    $spacingSides = array_diff($spacingSides, ['t', 'b']);
                    $spacingSides[] = 'y';
                }
                if (in_array('l',  $spacingSides) && in_array('r',  $spacingSides)) {
                    $spacingSides = array_diff($spacingSides, ['l', 'r']);
                    $spacingSides[] = 'x';
                }
                if (in_array('x',  $spacingSides) && in_array('y',  $spacingSides)) {
                    $spacingSides = array_diff($spacingSides, ['x', 'y']);
                    $spacingSides[] = 'all';
                }
                if ($spacingSides == null) {
                    $spacingSides[] = 'all';
                }
            } else {
                $spacingSides = ['all'];
            }

            $spacingClass = array();


            // Padding Or Margin
            if ($style_block['spacing_type'] == 'Padding') {
                $spacingClass['type'] = 'p';
            } else if ($style_block['spacing_type'] == 'Margin') {
                $spacingClass['type'] = 'm';
            } else {
                return;
            }

            if ($style_block['spacing_options'] && $style_block['spacing_options'] == 'custom') {
                if ($style_block['spacing_custom']) {
                    $spacingClass['size'] =  $style_block['spacing_custom'];
                    $spacingClass['custom'] = true;
                } else {
                    return;
                }
            } else if (isset($style_block['spacing_options'])) {
                $spacingClass['size'] =  $style_block['spacing_options'];
                $spacingClass['custom'] = false;
            }





            $classNames = '';
            $styles = '';
            foreach ($spacingSides as $spacingSide) {

                $classNames .= $spacingClass['type'];
                if ($spacingSide === 'all') {
                    $classNames .= '-';
                } else {
                    $classNames .= $spacingSide . '-';
                }
                $classNames .= isset($spacingClass['custom'])  && $spacingClass['custom']  ? '[' : '';
                $classNames .=  isset($spacingClass['size'])  ? $spacingClass['size'] : '';
                $classNames .= isset($spacingClass['custom'])  && $spacingClass['custom'] ? ']' : '';
                $classNames .= ' ';
            }



            if (isset($spacingClass['custom']) && $spacingClass['custom']) {
                $map = array(
                    't' => 'top',
                    'b' => 'bottom',
                    'l' => 'left',
                    'r' => 'right',
                    'm' => 'margin',
                    'p' => 'padding',
                );

                $styleSides = $style_block['spacing_side'] ? $style_block['spacing_side'] : ['t', 'b', 'l', 'r'];
                foreach ($styleSides as $styleSide) {
                    $style = '';
                    $style .= strtolower($style_block['spacing_type']) . '-' .  $map[$styleSide] . ': ' . $style_block['spacing_custom'] . '; ';

                    $styles  .= $style;
                }
                // echo '<pre>';
                // echo 'styles:';
                // var_dump($styles);
                // echo '</pre>';
            }
            $classNames = trim($classNames);



            $builder_classes .= $classNames . ' ';
            $builder_style .= $styles . ' ';
            // END OF SPACING SIDE LAYOUT
        } else if ($style_block['acf_fc_layout'] == 'colors') {


            if ($style_block['text_color'] == 'default') {
                // Do nothing

            } else if ($style_block['text_color'] == 'custom') {
                if ($style_block['text_custom']) {
                    $builder_style .= 'color: ' . $style_block['text_custom'] . '; ';
                    $builder_classes .= 'text-[' . $style_block['text_custom'] . '] ';
                }
            } else if ($style_block['text_color']) {
                $builder_classes .= 'text-' . $style_block['text_color'] . ' ';
            }

            if ($style_block['background_color'] == 'default') {
                // Do nothing

            } else if ($style_block['background_color'] == 'custom') {
                if ($style_block['background_custom']) {
                    $builder_style .= 'background-color: ' . $style_block['background_custom'] . '; ';
                    $builder_classes .= 'bg-[' . $style_block['background_custom'] . '] ';
                }
            } else if ($style_block['background_color']) {
                $builder_classes .= 'bg-' . $style_block['background_color'] . ' ';
            }
        } else if ($style_block['acf_fc_layout'] == 'typography') {

            if ($style_block['font_family']) {
                if ($style_block['font_family'] == 'default') {
                    // Do nothing
                } else {
                    $builder_classes .= 'font-' . $style_block['font_family'] . ' ';
                }
            }

            if ($style_block['font_size']) {
                if ($style_block['font_size'] == 'default') {
                    // Do nothing
                } else {
                    $builder_classes .= 'text-' . $style_block['font_size'] . ' ';
                }
            }

            if ($style_block['font_weight']) {
                if ($style_block['font_weight'] == 'default') {
                    // Do nothing
                } else {
                    $builder_classes .= 'font-' . $style_block['font_weight'] . ' ';
                }
            }
            if ($style_block['font_case']) {
                if ($style_block['font_case'] == 'default') {
                    // Do nothing
                } else {
                    $builder_classes .= $style_block['font_case'] . ' ';
                }
            }
            if ($style_block['line_height']) {
                if ($style_block['line_height'] == 'default') {
                    // Do nothing
                } else {
                    $builder_classes .= 'leading-' . $style_block['line_height'] . ' ';
                }
            }
        } else if ($style_block['acf_fc_layout'] == 'display') {
            if (isset($style_block['display'])) {
                $builder_classes .= $style_block['display'] . ' ';
            }
        } else if ($style_block['acf_fc_layout'] == 'size') {
            if ($style_block['w']) {
                $builder_classes .= 'w-[' . $style_block['w'] . '] ';
                $builder_style .= 'width: ' . $style_block['w'] . '; ';
            }
            if ($style_block['h']) {
                $builder_classes .= 'h-[' . $style_block['h'] . '] ';
                $builder_style .= 'height: ' . $style_block['h'] . '; ';
            }

            if ($style_block['min-w']) {
                $builder_classes .= 'min-w-[' . $style_block['min-w'] . '] ';
                $builder_style .= 'min-width: ' . $style_block['min-w'] . '; ';
            }

            if ($style_block['min-h']) {
                $builder_classes .= 'min-h-[' . $style_block['min-h'] . '] ';
                $builder_style .= 'min-height: ' . $style_block['min-h'] . '; ';
            }

            if ($style_block['max-w']) {
                $builder_classes .= 'max-w-[' . $style_block['max-w'] . '] ';
                $builder_style .= 'max-width: ' . $style_block['max-w'] . '; ';
            }

            if ($style_block['max-h']) {
                $builder_classes .= 'max-h-[' . $style_block['max-h'] . '] ';
                $builder_style .= 'max-height: ' . $style_block['max-h'] . '; ';
            }
        } else if ($style_block['acf_fc_layout'] == 'width') {
            if ($style_block['width_options'] == 'default') {
                // Do nothing
            } else {
                $builder_classes .= 'w-' . $style_block['width_options'] . ' ';
            }
        } else if ($style_block['acf_fc_layout'] == 'custom_attributes') {

            if ($style_block['custom_attributes']) {



                foreach ($style_block['custom_attributes'] as $item) {

                    $attributes[$item['key']] = $item['value'];
                }
            }
        }
    }

    // echo '<pre>';
    // echo 'attributes :';
    // var_dump($attributes);
    // echo '</pre>';

    // echo '<pre>';
    // echo 'style block classes:';
    // var_dump($builder_classes);
    // echo '</pre>';

    // echo '<pre>';
    // echo 'style block style:';
    // var_dump($builder_style);
    // echo '</pre>';
    return array(
        'classes' => trim($builder_classes),
        'style' => trim($builder_style),
        'attributes' => $attributes
    );
}
