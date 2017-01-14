<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/***********************************************************************************************/
/* Menus */
/***********************************************************************************************/

function bkb_addon_options_page() {

    add_submenu_page(
            'edit.php?post_type=bwl_kb',             //sub page to settings page
            __( 'Available Addons for BWL Knowledge Base Manager', 'bwl-kb'), // The Text to be display in bte browser bar.
            __( 'Plugin Add-ons', 'bwl-kb'), // The Text to be display in bte browser bar.
            'manage_options', // permission
            'bkbm-addon', //slug
            'bkb_addon_page_display' //callback
            );
    
}

function bkb_addon_page_display() {

    require_once 'bkb-addon-template.php';
    
}

add_action('admin_menu', 'bkb_addon_options_page');