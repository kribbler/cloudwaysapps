<?php

/**
* @Description: Shortcode Editor Button
* @Created At: 08-04-2013
* @Last Edited AT: 26-06-2013
* @Created By: Mahbub
**/

add_action('admin_init', 'bkb_tinymce_shortcode_button');

function bkb_tinymce_shortcode_button() {
    
    if (current_user_can('edit_posts') && current_user_can('edit_pages')) {
        add_filter('mce_external_plugins', 'add_bkb_shortcode_plugin');
        add_filter('mce_buttons', 'register_bkb_shortcode_button');
    }
}

function register_bkb_shortcode_button( $buttons ) {
    array_push($buttons, "bkb");
    return $buttons;
}

function add_bkb_shortcode_plugin( $plugin_array ) {
    $plugin_array['bkb'] = BWL_KB_PLUGIN_DIR . 'tinymce/bkb_tinymce_button.js';
    return $plugin_array;
}

 
?>