<?php

// ================== POPULATE ACF SELECT BOXES WITH OPTIONS FROM THEME.JSON ==================



/**
 * Create an ACF field for selecting a theme options
 */
function namespace_populate_spacing_field(array $field): array
{

    $theme_settings = wp_get_global_settings();

    if (isset($theme_settings['spacing']['spacingSizes']['theme'])) {
        $spacing_options = $theme_settings['spacing']['spacingSizes']['theme'];
    } else {
        $spacing_options = array(); // Fallback if no spacing options are found
    }
    $field['choices'] = [];

    foreach ($spacing_options as $spacing) {
        $field['choices'][esc_attr($spacing['slug'])] = esc_html($spacing['name']);
    }

    $field['choices']['custom'] = 'Custom';


    return $field;
}
add_filter('acf/load_field/name=spacing_options', 'namespace_populate_spacing_field', 10, 1);



function namespace_populate_text_color_field(array $field): array
{
    $theme_settings = wp_get_global_settings();
    if (isset($theme_settings['color']['palette']['theme'])) {
        $color_options = $theme_settings['color']['palette']['theme'];
    } else {
        $color_options = array(); // Fallback if no color options are found
    }
    $field['choices'] = ['default' => 'Default'];
    foreach ($color_options as $color) {
        $field['choices'][esc_attr($color['slug'])] = esc_html($color['name']);
    }
    $field['choices']['custom'] = 'Custom';
    // ksort($field['choices']);
    return $field;
}
add_filter('acf/load_field/name=text_color', 'namespace_populate_text_color_field', 10, 1);

function namespace_populate_background_color_field(array $field): array
{
    $theme_settings = wp_get_global_settings();
    if (isset($theme_settings['color']['palette']['theme'])) {
        $color_options = $theme_settings['color']['palette']['theme'];
    } else {
        $color_options = array(); // Fallback if no color options are found
    }
    $field['choices'] = ['default' => 'Default'];
    foreach ($color_options as $color) {
        $field['choices'][esc_attr($color['slug'])] = esc_html($color['name']);
    }
    $field['choices']['custom'] = 'Custom';
    // ksort($field['choices']);
    return $field;
}
add_filter('acf/load_field/name=background_color', 'namespace_populate_background_color_field', 10, 1);

function namespace_populate_font_face_field(array $field): array
{
    $theme_settings = wp_get_global_settings();
    if (isset($theme_settings['typography']['fontFamilies']['theme'])) {
        $font_options = $theme_settings['typography']['fontFamilies']['theme'];
    } else {
        $font_options = array(); // Fallback if no color options are found
    }
    $field['choices'] = [];
    $field['choices']['default'] = 'Default';
    foreach ($font_options as $font) {
        $field['choices'][esc_attr($font['slug'])] = esc_html($font['name']);
    }
    return $field;
}
add_filter('acf/load_field/name=font_family', 'namespace_populate_font_face_field', 10, 1);

function namespace_populate_font_size_field(array $field): array
{
    $theme_settings = wp_get_global_settings();
    if (isset($theme_settings['typography']['fontSizes']['theme'])) {
        $font_options = $theme_settings['typography']['fontSizes']['theme'];
    } else {
        $font_options = array(); // Fallback if no color options are found
    }
    $field['choices'] = [];
    $field['choices']['default'] = 'Default';
    foreach ($font_options as $font) {
        $field['choices'][esc_attr($font['slug'])] = esc_html($font['name']);
    }
    $field['choices']['custom'] = 'Custom';
    return $field;
}
add_filter('acf/load_field/name=font_size', 'namespace_populate_font_size_field', 10, 1);


function namespace_populate_line_height_field(array $field): array
{
    $theme_settings = wp_get_global_settings();
    if (isset($theme_settings['custom']['lineHeight'])) {
        $font_options = $theme_settings['custom']['lineHeight'];
    } else {
        $font_options = array(); // Fallback if no color options are found
    }
    $field['choices'] = [];
    foreach ($font_options as $key => $font) {
        $field['choices'][$key] = ucwords(esc_html($key));
    }
    ksort($field['choices']);
    $field['choices']['default'] = 'Default';
    $field['choices'] = array_reverse($field['choices']);
    return $field;
}
add_filter('acf/load_field/name=line_height', 'namespace_populate_line_height_field', 10, 1);

function namespace_populate_font_weight_field(array $field): array
{
    $theme_settings = wp_get_global_settings();
    if (isset($theme_settings['custom']['fontWeight'])) {
        $font_options = $theme_settings['custom']['fontWeight'];
    } else {
        $font_options = array(); // Fallback if no color options are found
    }
    $field['choices'] = [];
    $field['choices']['default'] = 'Default';
    foreach ($font_options as $key => $font) {
        $field['choices'][$key] = ucwords(esc_html($key));
    }
    // ksort($field['choices']);
    // $field['choices'] = array_reverse($field['choices']);
    return $field;
}
add_filter('acf/load_field/name=font_weight', 'namespace_populate_font_weight_field', 10, 1);

function namespace_populate_width_field(array $field): array
{
    $theme_settings = wp_get_global_settings();
    if (isset($theme_settings['custom']['width'])) {
        $width_options = $theme_settings['custom']['width'];
    } else {
        $width_options = array(); // Fallback if no color options are found
    }

    $field['choices'] = [];
    foreach ($width_options as $key => $width) {
        $field['choices'][$key] = ucwords(esc_html($key));
    }

    return $field;
}
add_filter('acf/load_field/name=width_options', 'namespace_populate_width_field', 10, 1);
function namespace_populate_thumbnail_options_field(array $field): array
{
    $thumbnail_options = get_intermediate_image_sizes();

    $field['choices'] = [];
    $field['choices']['full'] = 'Full Size';

    foreach ($thumbnail_options as $thumbnail) {
        $formatted_thumbnail = ucwords(str_replace('_', ' ', $thumbnail));
        $field['choices'][esc_attr($thumbnail)] = esc_html($formatted_thumbnail);
    }

    return $field;
}

add_filter('acf/load_field/name=thumbnail_options', 'namespace_populate_thumbnail_options_field', 10, 1);
