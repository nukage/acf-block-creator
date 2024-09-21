<?php


function my_plugin_enqueue_script()
{
    wp_enqueue_script('my-plugin-script', plugins_url('/js/app.js', __FILE__), array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'my_plugin_enqueue_script');



function generateLoremIpsum($minLength = 50, $maxLength = 100)
{
    $loremIpsum = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
    $words = explode(' ', $loremIpsum);
    $randomLength = rand($minLength, $maxLength);
    $randomText = '';
    for ($i = 0; $i < $randomLength; $i++) {
        $randomText .= $words[array_rand($words)] . ' ';
    }
    return trim($randomText);
}
