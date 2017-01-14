<?php

/**
 * Render the welcome screen
 */
function bkb_welcome() {

    require_once 'welcome-page.php';
}

/**
 * Add the welcome page to the admin menu
 */
function bkb_welcome_submenu() {

    add_submenu_page(
            'edit.php?post_type=bwl_kb', __('Thanks for Installing BWL Knowledge Base Manager.', 'bwl-kb'), __('Plugin Info', 'bwl-kb'), 'manage_options', 'bkb-welcome', 'bkb_welcome'
    );
}

add_action('admin_menu', 'bkb_welcome_submenu');