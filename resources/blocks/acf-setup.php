<?php

$acf_key = $id;
$acf_fields = array(
    'key' => $acf_key,

);
$acf_name = get_field('acf_name');
$acf_mode = get_field('acf_mode');

if ($acf_mode == 'parent') {
    $acf_fields['title'] = $acf_name;
}

if ($acf_mode == 'child') {
    $acf_fields['name'] = $acf_name;
}
