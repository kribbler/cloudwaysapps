<?php

add_shortcode('bkb_tab', 'bkb_tab');

function bkb_tab($atts, $content = null) {
    
    extract(shortcode_atts(array(
        'title' => '',
        'link' => '',
        'target' => ''
                    ), $atts));
    
    global $single_tab_array;
    
    $single_tab_array[] = array(
                                        'title' => bkb_get_tab_title( $title ), 
                                        'link' => $link, 
                                        'content' => trim(do_shortcode($content))
                                    );
}


add_shortcode('bkb_tabs', 'bkb_tabs');

function bkb_tabs( $atts, $content = null ) {
    
    global $single_tab_array;
    
    $single_tab_array = array(); // clear the array

    $bkb_tab_navigation = '<div class="bkb-wrapper">';
    $bkb_tab_content = "";
    $bkb_tab_output = "";
    
    $bkb_tab_navigation .= '<ul class="bkb-tabs">';

    // execute the '[tab]' shortcode first to get the title and content - acts on global $single_tab_array
    do_shortcode($content);

    //declare our vars to be super clean here
    
    foreach ( $single_tab_array as $tab => $tab_attr_array ) {

        $random_id = wp_rand();

        $default = ( $tab == 0 ) ? ' class="active"' : '';

        if ( $tab_attr_array['link'] != "" ) {
            
            $bkb_tab_navigation .= '<li' . $default . '><a class="bkb-link" href="' . $tab_attr_array["link"] . '" target="' . $tab_attr_array["target"] . '" rel="tab' . $random_id . '"><span>' . $tab_attr_array['title'] . '</span></a></li>';
            
        } else {
            
            $bkb_tab_navigation .= '<li' . $default . '><a href="javascript:void(0)" rel="tab' . $random_id . '"><span>' . $tab_attr_array['title'] . '</span></a></li>';
            $bkb_tab_content .= '<div class="bkb-tab-content" id="tab' . $random_id . '" ' . ( $tab != 0 ? 'style="display:none"' : '') . '>' . $tab_attr_array['content'] . '</div>';
            
        }
        
    }
    
    $bkb_tab_navigation .= '</ul><!-- .bkb-tabs -->';

    $bkb_tab_output = $bkb_tab_navigation . '<div class="bkb-content-wrapper">' . $bkb_tab_content . '</div>';
    $bkb_tab_output .= '</div><!-- .tabs-wrapper -->';
    
    /*------------------------------ Load Scripts ---------------------------------*/
    
    wp_enqueue_script( 'bkb-tabify-script' );

    return $bkb_tab_output;
    
}


/*------------------------------ WPML Support ---------------------------------*/

function bkb_get_tab_title( $tab_title = "" ) {
    
    $default_value = "-";
    
    $tab_title = strtolower($tab_title);
    
    if( $tab_title == "featured" ) {
        
        return __('Featured','bwl-kb');
        
    } else if( $tab_title == "popular" ) {
        
        return __('Popular','bwl-kb');
        
    } else if( $tab_title == "recent" ) {
        
        return __('Recent','bwl-kb');
        
    } else {
        
        return $tab_title;
        
    }
    
    
}