<?php

/**
* @Description: Filter All KB Category and Topics
* @Created At: 15-03-2014
* @Last Edited AT: 15-03-2014
* @Created By: Mahbub
* @Created Version: 1.0.0
**/

function bkb_restrict_manage_posts() {
    global $typenow;
//    $args = array('public' => true, '_builtin' => false);
//    $post_types = get_post_types($args);
    
//    if (in_array($typenow, $post_types)) {
    
    if ($typenow == 'bwl_kb') {
        
        $filters = get_object_taxonomies($typenow);
        
        foreach ($filters as $tax_slug) {
            $tax_obj = get_taxonomy($tax_slug);
            
            if(isset($_GET[$tax_obj->query_var])) {
                $selected_value = $_GET[$tax_obj->query_var];
            } else {
                $selected_value = "";
            }
            
            wp_dropdown_categories(array(
                'show_option_none' => __('Show All ' . $tax_obj->label),
                'taxonomy' => $tax_slug,
                'name' => $tax_obj->name,
                'orderby' => 'term_order',
                'selected' => $selected_value,
                'hierarchical' => $tax_obj->hierarchical,
                'show_count' => true,
                'hide_empty' => FALSE
            ));
        }
    }
}

function bkb_convert_restrict($query) {
    global $pagenow;
    global $typenow;
    if ( $pagenow == 'edit.php' && $typenow== "bwl_kb" ) {
        $filters = get_object_taxonomies($typenow);        
        foreach ($filters as $tax_slug) {
            $var = &$query->query_vars[$tax_slug];
            if (isset($var)) {
                $term = get_term_by('id', $var, $tax_slug);                
                if(isset($term->slug)) {
                    $var = $term->slug;
                } else {
                    $var = "";
                }
            }
        }
    }
}

add_action('restrict_manage_posts', 'bkb_restrict_manage_posts');
add_filter('parse_query', 'bkb_convert_restrict');