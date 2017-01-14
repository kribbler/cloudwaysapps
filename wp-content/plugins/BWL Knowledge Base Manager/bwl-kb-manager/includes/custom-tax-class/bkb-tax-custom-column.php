<?php

 /*------------------------------  Custom Category Column Section ---------------------------------*/
// After manage text we need to add "custom_post_type" value.

add_filter('manage_edit-bkb_category_columns','bkb_cat_custom_column_header');
 // After manage text we need to add "custom_post_type" value.
        
add_action('manage_bkb_category_custom_column', 'bkb_display_cat_custom_column', 10, 3);


function bkb_cat_custom_column_header( $columns ) {
    
     $columns['bkb_fa_id'] = __('Icons', 'bwl-kb');
    
     return $columns;
     
 }
 
function bkb_display_cat_custom_column( $deprecated, $column, $term_id ) {

    // Add A Custom Image Size For Admin Panel.
    
    global $post;
    
    switch ( $column ) {
        
        case 'bkb_fa_id':

            $bkb_fa_id = get_tax_meta($term_id, 'bkb_fa_id');
            $bkb_upload_icon_status = get_tax_meta($term_id, 'bkb_upload_icon_status');
            $bkb_uploaded_icon = get_tax_meta($term_id, 'bkb_uploaded_icon');
            
            $bkb_fa_icon = "fa fa-gift"; // default
            
            if( $bkb_fa_id != "" ) {
                
                $bkb_fa_icon = get_tax_meta($term_id, 'bkb_fa_id');
                
            } else {
                
                $bkb_data = get_option('bkb_options');
                
                if (isset($bkb_data['bkb_cat_icon']) && $bkb_data['bkb_cat_icon'] != "") {
                
                    $bkb_fa_icon = $bkb_data['bkb_cat_icon'];
                    
                }
                 
            }
            
            $bkb_fa_icon = '<i class="'. $bkb_fa_icon.'"></i>';
            
            if ( $bkb_upload_icon_status == "on" && isset($bkb_uploaded_icon['url']) && $bkb_uploaded_icon['url'] !="" ) {
               
                $bkb_fa_icon = '<img src="'.$bkb_uploaded_icon['url'].'" alt="" style="width: 16px; height: 16px;" />';
                
            }
            
            echo '<div id="bkb_fa_id-' . $term_id . '" class="bkb-custom-icon-font">&nbsp;'.$bkb_fa_icon.'</div>';
            
            break;
            
    }
    
}


 /*------------------------------  Custom TAGS Column Section ---------------------------------*/

// After manage text we need to add "custom_post_type" value.

add_filter('manage_edit-bkb_tags_columns','bkb_tags_custom_column_header');
 // After manage text we need to add "custom_post_type" value.
        
add_action('manage_bkb_tags_custom_column', 'bkb_display_tags_custom_column', 10, 3);


function bkb_tags_custom_column_header( $columns ) {
    
     $columns['bkb_fa_id'] = __('Icons', 'bwl-kb');
    
     return $columns;
     
 }
 
function bkb_display_tags_custom_column( $deprecated, $column, $term_id ) {

    // Add A Custom Image Size For Admin Panel.
    
    global $post;
    
    switch ( $column ) {
        
        case 'bkb_fa_id':

            $bkb_fa_id = get_tax_meta($term_id, 'bkb_fa_id');
            $bkb_upload_icon_status = get_tax_meta($term_id, 'bkb_upload_icon_status');
            $bkb_uploaded_icon = get_tax_meta($term_id, 'bkb_uploaded_icon');
            
            $bkb_fa_icon = "fa fa-gift"; // default
            
            if( $bkb_fa_id != "" ) {
                
                $bkb_fa_icon = get_tax_meta($term_id, 'bkb_fa_id');
                
            } else {
                
                $bkb_data = get_option('bkb_options');
                
                if (isset($bkb_data['bkb_tag_icon']) && $bkb_data['bkb_tag_icon'] != "") {
                
                    $bkb_fa_icon = $bkb_data['bkb_tag_icon'];
                    
                }
                 
            }
            
            $bkb_fa_icon = '<i class="'. $bkb_fa_icon.'"></i>';
            
            if ( $bkb_upload_icon_status == "on" && isset($bkb_uploaded_icon['url']) && $bkb_uploaded_icon['url'] !="" ) {
               
                $bkb_fa_icon = '<img src="'.$bkb_uploaded_icon['url'].'" alt="" style="width: 16px; height: 16px;" />';
                
            }
            
            echo '<div id="bkb_fa_id-' . $term_id . '" class="bkb-custom-icon-font">&nbsp;'.$bkb_fa_icon.'</div>';
            
            break;
            
    }
    
}