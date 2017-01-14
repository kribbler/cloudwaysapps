<?php

if( !function_exists('bkb_custom_theme')) {
    
    function bkb_custom_theme() {
        
        /*------------------------------  Default Settings ---------------------------------*/
        $bkb_like_bar_color = '#559900';
        $bkb_dislike_bar_color = '#C9231A';
        $bkb_like_thumb_color= '#559900';
        $bkb_dislike_bar_color = '#C9231A';
        
        $bkb_data = get_option('bkb_options');
        
        $custom_theme = '<style type="text/css">';
        
        // Like Bar Color.
        
        if( isset( $bkb_data['bkb_like_bar_color'] ) && $bkb_data['bkb_like_bar_color']!="" ) {
            
            $bkb_like_bar_color = $bkb_data['bkb_like_bar_color'];            
            $custom_theme .= '.bkb_container .bg-green{ background-color: ' . $bkb_like_bar_color .';}';
            
        }
        
        // Dislike Bar Color.
        
        if( isset( $bkb_data['bkb_dislike_bar_color'] ) && $bkb_data['bkb_dislike_bar_color']!="" ) {
            $bkb_dislike_bar_color = $bkb_data['bkb_dislike_bar_color'];
            $custom_theme .= '.bkb_container .bg-red{ background-color: ' . $bkb_dislike_bar_color .';}';
        }
        
        // Like Button Thumb Color.
        
        if( isset( $bkb_data['bkb_like_thumb_color'] ) && $bkb_data['bkb_like_thumb_color']!="" ) {
            
            $bkb_like_thumb_color= $bkb_data['bkb_like_thumb_color'];            
            $custom_theme .= '.bkb_container .btn_like{ color: ' . $bkb_like_thumb_color .';}';
            $custom_theme .= '.bkb_icon_like_color{ color: ' . $bkb_like_thumb_color .';}';
        }
        
        // Dislike Button Text Color.
        
        if( isset( $bkb_data['bkb_dislike_thumb_color'] ) && $bkb_data['bkb_dislike_thumb_color']!="" ) {
            $bkb_dislike_thumb_color = $bkb_data['bkb_dislike_thumb_color'];
            $custom_theme .= '.bkb_container .btn_dislike{ color: ' . $bkb_dislike_thumb_color .';}';
            $custom_theme .= '.bkb_icon_dislike_color{ color: ' . $bkb_dislike_thumb_color .';}';
        }
        
        
        /*------------------------------ Tipsy ---------------------------------*/
        
        $bkb_tipsy_bg = "#000000";
        $bkb_tipsy_text_color = "#FFFFFF";
        
        if( isset( $bkb_data['bkb_tipsy_bg'] ) && $bkb_data['bkb_tipsy_bg']!="" ) {
            $bkb_tipsy_bg = $bkb_data['bkb_tipsy_bg'];
        }
        
        if( isset( $bkb_data['bkb_tipsy_text_color'] ) && $bkb_data['bkb_tipsy_text_color']!="" ) {
            $bkb_tipsy_text_color = $bkb_data['bkb_tipsy_text_color'];
        }
        
        $custom_theme .= '.tipsy-inner{ background: ' . $bkb_tipsy_bg .'; color: ' . $bkb_tipsy_text_color .';}';
        
         /*------------------------------ KB List Heading Color  ---------------------------------*/
        $bkb_heading_link_color = "#0074A2";
        $bkb_heading_link_hover_color = "#004F6C";
        
        if( isset( $bkb_data['bkb_heading_link_color'] ) && $bkb_data['bkb_heading_link_color']!="" ) {
            $bkb_heading_link_color = $bkb_data['bkb_heading_link_color'];
        }
        
        if( isset( $bkb_data['bkb_heading_link_hover_color'] ) && $bkb_data['bkb_heading_link_hover_color']!="" ) {
            $bkb_heading_link_hover_color = $bkb_data['bkb_heading_link_hover_color'];
        }
        
        $custom_theme .= '.bwl-kb div.bkb-box-layout a h2.bkb-box-style-category-title, .bwl-kb div.bkb-box-layout a span.bkb-icon-container, .bwl-kb h2.bwl-kb-category-title a{ color: ' . $bkb_heading_link_color .';}';
        $custom_theme .= '.bwl-kb div.bkb-box-layout a:hover h2.bkb-box-style-category-title, .bwl-kb div.bkb-box-layout a:hover span.bkb-icon-container, .bwl-kb h2.bwl-kb-category-title a:hover{ color: ' . $bkb_heading_link_hover_color .';}';
        
        /*------------------------------ bkb Taxonomy Description Color ---------------------------------*/
        
        $bkb_category_description_color = "#525252";
        
         if( isset( $bkb_data['bkb_category_description_color'] ) && $bkb_data['bkb_category_description_color']!="" ) {
            $bkb_category_description_color = $bkb_data['bkb_category_description_color'];
        }
                
        $custom_theme .= '.bwl-kb div.bkb-content > p.bkb-category-description, .bwl-kb div.bkb-box-layout p.bkb-category-description{ color: ' . $bkb_category_description_color .';}';

        
        /*------------------------------ Search Theming ---------------------------------*/
        
        $bkb_search_results_background = "#2C2C2C";
        $bkb_search_results_color = "#FFFFFF";
        
        
        if( isset( $bkb_data['bkb_search_results_background'] ) && $bkb_data['bkb_search_results_background']!="" ) {
            $bkb_search_results_background = $bkb_data['bkb_search_results_background'];
        }
        
        if( isset( $bkb_data['bkb_search_results_color'] ) && $bkb_data['bkb_search_results_color']!="" ) {
            $bkb_search_results_color = $bkb_data['bkb_search_results_color'];
        }
        
        $custom_theme .= 'div.suggestionsBox{ background: ' . $bkb_search_results_background .';}';
        $custom_theme .= 'div.suggestionList ul li{color: ' . $bkb_search_results_color .' !important;}';
        $custom_theme .= 'div.suggestionList ul li a{color: ' . $bkb_search_results_color .' !important;}';
        $custom_theme .= 'div.suggestionList:before{  border-bottom: 7px solid ' . $bkb_search_results_background .';}';
        
        /*------------------------------ RTL Support For Search Section ---------------------------------*/
        
        if( isset( $bkb_data['bkb_rtrl_support'] ) && $bkb_data['bkb_rtrl_support'] == 1 ) {
            //Write all custom codes for RTL in here.
            $custom_theme .= 'span.bkbm-btn-clear{ left: 3px;}';
        } else {
            
               $custom_theme .= 'span.bkbm-btn-clear{ right: 3px;}'; 
                
        }
        
        
        /*---------------------------- KB List Text Color -----------------------------------*/
        
        $bkb_list_text_color = "#2C2C2C";
        $bkb_list_bg = "#EBEBEB";
        
        $bkb_list_hover_text_color = "#5C5C5C";
        $bkb_list_hover_bg = "#DDDDDD";
        
        if( isset( $bkb_data['bkb_list_text_color'] ) && $bkb_data['bkb_list_text_color']!="" ) {
            $bkb_list_text_color = $bkb_data['bkb_list_text_color'];
        }
        
        if( isset( $bkb_data['bkb_list_bg'] ) && $bkb_data['bkb_list_bg']!="" ) {
            $bkb_list_bg = $bkb_data['bkb_list_bg'];
        }
        
        if( isset( $bkb_data['bkb_list_hover_text_color'] ) && $bkb_data['bkb_list_hover_text_color']!="" ) {
            $bkb_list_hover_text_color = $bkb_data['bkb_list_hover_text_color'];
        }
        
        if( isset( $bkb_data['bkb_list_hover_bg'] ) && $bkb_data['bkb_list_hover_bg']!="" ) {
            $bkb_list_hover_bg = $bkb_data['bkb_list_hover_bg'];
        }
        
            
        $custom_theme .= '.rectangle-list a{ background: ' . $bkb_list_bg .'; color: ' . $bkb_list_text_color .';}';
        $custom_theme .= '.rectangle-list a:hover{ background: ' . $bkb_list_hover_bg .'; color: ' . $bkb_list_hover_text_color .';}';

        $custom_theme .= '.rounded-list a, .rounded-list a:visited{ background: ' . $bkb_list_bg .'; color: ' . $bkb_list_text_color .';}';
        $custom_theme .= '.rounded-list a:hover{ background: ' . $bkb_list_hover_bg .'; color: ' . $bkb_list_hover_text_color .';}';

        $custom_theme .= '.iconized-list a{ color: ' . $bkb_list_text_color .';}';
        $custom_theme .= '.iconized-list a:hover{ color: ' . $bkb_list_hover_text_color .';}';

        $custom_theme .= '.none-list a{ color: ' . $bkb_list_text_color .';}';
        $custom_theme .= '.none-list a:hover{ color: ' . $bkb_list_hover_text_color .';}';
        
        
        /*----------------------------KB Rounded Box Text & Background -----------------------------------*/
        
        $bkb_rounded_box_text_color = "#2C2C2C";
        
        $bkb_rounded_box_bg = "#CDCDCD";
        
        if( isset( $bkb_data['bkb_rounded_box_text_color'] ) && $bkb_data['bkb_rounded_box_text_color']!="" ) {
            $bkb_rounded_box_text_color = $bkb_data['bkb_rounded_box_text_color'];
        }
        
        if( isset( $bkb_data['bkb_rounded_box_bg'] ) && $bkb_data['bkb_rounded_box_bg']!="" ) {
            $bkb_rounded_box_bg = $bkb_data['bkb_rounded_box_bg'];
        }
            
        $custom_theme .= '.rectangle-list a:before { background: ' . $bkb_rounded_box_bg .'; color: ' . $bkb_rounded_box_text_color .';}';

        $custom_theme .= '.rounded-list a:before {background: ' . $bkb_rounded_box_bg .'; color: ' . $bkb_rounded_box_text_color .';}';
        
        /*------------------------------Tab Border Settings ---------------------------------*/
        
        $bkb_tab_border_color = "#2C2C2C";
        
        if( isset( $bkb_data['bkb_tab_border_color'] ) && $bkb_data['bkb_tab_border_color']!="" ) {
            $bkb_tab_border_color = $bkb_data['bkb_tab_border_color'];
        }
        
        $custom_theme .= '.bkb-wrapper ul.bkb-tabs li.active { border-color: ' . $bkb_tab_border_color .';}';
        
         /*------------------------------ Taxonomy Icon Styling  ---------------------------------*/
        
        $bkb_box_view_icon_size = '32';
        
        if( isset( $bkb_data['bkb_box_view_icon_size'] ) && $bkb_data['bkb_box_view_icon_size']!="" ) {
            $bkb_box_view_icon_size = $bkb_data['bkb_box_view_icon_size'];
            
            $custom_theme .= '.bwl-kb div.bkb-box-layout a span.bkb-icon-container { font-size: ' . $bkb_box_view_icon_size .'px;}';
        }
        
        /*------------------------------ Taxonomy Images Styling  ---------------------------------*/
        
        
        $bkb_list_view_thumb_size = "16";
        $bkb_list_view_thumb_width = "16px";
        $bkb_list_view_thumb_height = "16px";
        
        if( isset( $bkb_data['bkb_list_view_thumb_size'] ) && $bkb_data['bkb_list_view_thumb_size']!="" ) {
            $bkb_list_view_thumb_size = bkb_get_custom_taxonomy_img_size( $bkb_data['bkb_list_view_thumb_size'] );
            
            $bkb_list_view_thumb_width = $bkb_list_view_thumb_size['width'];
            $bkb_list_view_thumb_height = $bkb_list_view_thumb_size['height'];
        }
        
        $custom_theme .= '.bkb_taxonomy_img_lists { width: ' . $bkb_list_view_thumb_width .'; height: ' . $bkb_list_view_thumb_width .';}';
        
        $bkb_box_view_thumb_size = "64";
        $bkb_box_view_thumb_width = "64px";
        $bkb_box_view_thumb_height = "64px";
        
        if( isset( $bkb_data['bkb_box_view_thumb_size'] ) && $bkb_data['bkb_box_view_thumb_size']!="" ) {
            $bkb_box_view_thumb_size = bkb_get_custom_taxonomy_img_size( $bkb_data['bkb_box_view_thumb_size'] );
            
            $bkb_box_view_thumb_width = $bkb_box_view_thumb_size['width'];
            $bkb_box_view_thumb_height = $bkb_box_view_thumb_size['height'];
        }
        
        $custom_theme .= '.bkb_taxonomy_img_box { width: ' . $bkb_box_view_thumb_width .'; height: ' . $bkb_box_view_thumb_height .';}';
        
        
        /*---------------------------- Custom CSS -----------------------------------*/
        
        $bkb_custom_css = "";
        
        if( isset( $bkb_data['bkb_custom_css'] ) && $bkb_data['bkb_custom_css']!="" ) {
            $bkb_custom_css = $bkb_data['bkb_custom_css'];
        }
        
        $custom_theme .= $bkb_custom_css;
        
        $custom_theme .= '</style>';
        
        echo $custom_theme;
        
    }
    
    
    add_action('wp_head', 'bkb_custom_theme');
    
}