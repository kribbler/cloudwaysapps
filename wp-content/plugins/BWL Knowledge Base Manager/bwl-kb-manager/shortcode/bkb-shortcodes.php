<?php

add_shortcode('bwl_kb', 'bwl_kb');
        
function bwl_kb( $atts ){
 
    $id_prefix = wp_rand();
    
    extract(shortcode_atts(array(
        'post_type'     => 'bwl_kb',
        'meta_key'         => '',
        'meta_value'         => '',
        'orderby'         => 'menu_order',
        'order'            => 'ASC',
        'limit'              => -1,
        'bkb_cat_title' => '',
        'bkb_category' => '',
        'bkb_tags'     => '',
        'taxonomy'     => 'bkb_category',
        'posts_count'   => 0,
        'bkb_col_class' => 'bkbcol-1-1',
        'sbox'            => 1,
        'bkb_tabify'    => 0,
        'list'       => 0,
        'single' => 0,
        'fpid' => 0,
        'box_view' => 0,
        'bkb_desc' => 0,
        'bkb_list_type' => '', // rectangle/iconized/rounded/none
        'suppress_filters' => 0,
        'show_title' => 1

    ), $atts));
    
    $output = "";
    
    $bkb_data = get_option('bkb_options');
    
    $args = array(
        'post_status'       => 'publish',
        'meta_key'         => $meta_key,
        'meta_value'       => $meta_value,
        'post_type'         => $post_type,
        'orderby'             => $orderby,
        'order'                => $order,
        'posts_per_page' => $limit,
        'bkb_category'      => $bkb_category,
        'bkb_tags'          => $bkb_tags
    );
    
    $loop = new WP_Query($args);
    
    
    /*------------------------------ Start Font Awesome Category & Content Icons  ---------------------------------*/
            
        $bkb_fa_icon = "fa fa-file-o"; // Default Icon for Categories/Tags
        $bkb_list_fa_icon = $bkb_fa_icon; // Default Icon for Lists.

        if ($bkb_tags != "") {

            $taxonomy = 'bkb_tags';
            $bkb_fa_icon = "fa fa-th";
            
            if (isset($bkb_data['bkb_tag_icon']) && $bkb_data['bkb_tag_icon'] != "") {
                $bkb_fa_icon = $bkb_data['bkb_tag_icon'];
                $bkb_list_fa_icon = $bkb_fa_icon;
            }

        } else {

            if (isset($bkb_data['bkb_cat_icon']) && $bkb_data['bkb_cat_icon'] != "") {
                $bkb_fa_icon = $bkb_data['bkb_cat_icon'];
                $bkb_list_fa_icon = $bkb_fa_icon;
            }

        }
    
    /*------------------------------  End Font Awesome Category & Content Icons---------------------------------*/
    
        if ($bkb_tabify == 0) {

            $bkb_taxonomy_title = $bkb_cat_title;

            $bkb_taxonomy_info = get_term_by('name', $bkb_taxonomy_title, $taxonomy);

            $taxonomy_id = $bkb_taxonomy_info->slug;

            $bkb_taxonomy_cat_link = get_term_link($taxonomy_id, $taxonomy);
            
            $output .='<div class="' . $bkb_col_class . '">
                                 <div class="bkb-content">';
            
            $bkb_custom_fa_icon = get_tax_meta( $bkb_taxonomy_info->term_taxonomy_id, 'bkb_fa_id' );
            
            $bkb_upload_icon_status = get_tax_meta($bkb_taxonomy_info->term_taxonomy_id, 'bkb_upload_icon_status');
            $bkb_uploaded_icon = get_tax_meta($bkb_taxonomy_info->term_taxonomy_id, 'bkb_uploaded_icon');
 
            if( $bkb_custom_fa_icon != "" ) {
                
                $bkb_fa_icon = $bkb_custom_fa_icon;
                
            }
            
            $bkb_fa_icon = '<i class="'. $bkb_fa_icon.'"></i>';
            
            if ( $bkb_upload_icon_status == "on" && isset($bkb_uploaded_icon['url']) && $bkb_uploaded_icon['url'] !="" ) {
                
                $bkb_taxonomy_img_class = "bkb_taxonomy_img_lists";
                
                if( $box_view == 1 ) {
                    $bkb_taxonomy_img_class = "bkb_taxonomy_img_box";
                }
                
               
                $bkb_fa_icon = '<img src="'.$bkb_uploaded_icon['url'].'" class="'.$bkb_taxonomy_img_class.'" />';
                
            }
            
            
            $bkb_posts_count_string = ""; // Initialize KB Post Count.
            $bkb_taxonomy_description = ""; // Initialize KB Taxonomy Description.
            
            
            // Get KB posts count.
            if ( $posts_count == 1 ) {
                
                $bkb_posts_count_string = ' ( ' . $bkb_taxonomy_info->count . ' )';
                
            }
            
            // Get Category/Topic description.
            
             if( $bkb_taxonomy_info->description != "" && $bkb_desc == 1 ) {
                 
                //Genereate taxonomy string if description is available and display status is 1.
                $bkb_taxonomy_description .= '<p class="bkb-category-description">' . $bkb_taxonomy_info->description . '</p>';

            }
            
            
            if( $box_view == 1) {
            
                // Box View.
                $output .='<div class="bkb-box-layout"><a href="' . $bkb_taxonomy_cat_link . '" title="' . $bkb_taxonomy_title . '" ><span class="bkb-icon-container">' . $bkb_fa_icon . '</span> <h2 class="bkb-box-style-category-title">' . ucfirst( $bkb_cat_title ) . $bkb_posts_count_string . '</h2></a>';

                $output.= $bkb_taxonomy_description;
                
                $output .='</div>';
                
            } else {

                // Regular View.
                // @added in version 1.0.8
                
                if( $show_title == 1 ) {
                
                    $output .='<h2 class="bwl-kb-category-title"><a href="' . $bkb_taxonomy_cat_link . '" title="' . $bkb_taxonomy_title . '" >' . $bkb_fa_icon . ' ' . ucfirst( $bkb_cat_title ) . $bkb_posts_count_string . '</a></h2>';
                
                }
                $output.= $bkb_taxonomy_description;
                
            }

        }


        if ( $loop->have_posts() && $box_view == 0 ) :
            
            $bkb_list_iconized_status = FALSE;
            $bkb_list_iconized_string = "";
            
       
            // List type styling classes.
            // 4 types of list styles available in KB.
            // Default: Rounded List.
            
            if ( isset($bkb_data['bkb_list_style_type']) && $bkb_data['bkb_list_style_type']=="rectangle") {

                $bkb_list_style_class = "rectangle-list";

            } else if ( isset($bkb_data['bkb_list_style_type']) && $bkb_data['bkb_list_style_type']=="iconized") {

                $bkb_list_style_class = "iconized-list";
                $bkb_list_iconized_status = TRUE;

            } else if ( isset($bkb_data['bkb_list_style_type']) && $bkb_data['bkb_list_style_type']=="none") {

                $bkb_list_style_class = "none-list";

            } else{

                $bkb_list_style_class =  "rounded-list";

            }
        
        /*------------------------------ Just A Quick Check For List Type Settings ---------------------------------*/
        
            if( isset( $bkb_list_type ) && $bkb_list_type !="" ) {

                $bkb_list_style_class = $bkb_list_type . "-list";

                if ( $bkb_list_style_class == "iconized-list" ) {
                    $bkb_list_iconized_status = TRUE;
                } else {
                    $bkb_list_iconized_status = FALSE;
                }

            }
        
         
        $output .='<ol class="bwl-kb-categories ' . $bkb_list_style_class .'">';
        
        while ( $loop->have_posts() ) :
        
            $loop->the_post(); 
            
            $bkb_title = get_the_title();
            
            if ( $bkb_list_iconized_status == TRUE ) {
                
                $bkb_kb_post_icon = get_post_meta(get_the_ID(), "bkb_fa_id", true); 
                
                if( $bkb_kb_post_icon != "" ) {
                    $bkb_list_fa_icon = $bkb_kb_post_icon;
                }
                
                $bkb_list_iconized_string = '<i class="'. $bkb_list_fa_icon.'"></i> &nbsp;'; 
            }
     
            $output .='<li><a href="'.get_permalink().'" title="'.$bkb_title.'">'. $bkb_list_iconized_string . $bkb_title .'</a></li>';
            
        endwhile;
        
        $output .='</ol>';
        
    else :
            
        if( $box_view == 1) {
            
            // Box View.
            $output .= "";
            
        } else {
            
            // Regular View.
            $output .= "<p>" . __('Sorry, No Knowledgebase Item Available!', 'bwl-kb') . "</p>";
            
        }

    endif;
    
     if ($bkb_tabify == 0 ) {
        
        $output .='    </div>
                       </div>';

    } else {
        // Tabify Footer code sent in here.
    }
    
    wp_reset_query();
    
    return $output;
    
}

/*---------------------------BKB CATEGORY SHORTCODE ------------------------------------*/

add_shortcode('bkb_category', 'bkb_get_category_contents');

function bkb_get_category_contents( $atts ){
 
    extract(shortcode_atts(array(
        'taxonomy'     => 'bkb_category',
        'meta_key'     => '',
        'orderby'        => 'ID',
        'order'           => 'DESC',
        'limit'             => -1,
        'categories'    => '',
        'cols'             => 2,
        'posts_count' => 0,
        'bkb_list_type' => '', // rectangle/iconized/rounded/none,
        'bkb_desc' => 0,
        'box_view' => 0,
        'show_title' => 1
         
    ), $atts));
    
    $output = "";
    
    $bkb_category_args = array(
                'taxonomy' => $taxonomy,
                'hide_empty' => 1,
                'orderby' => 'title', 
                'order' => 'ASC'
     );
 
    $bkb_col_class = bkb_get_grid_col_class($cols);
    
    if( trim( $categories ) == "" ) {
        
        // If there is no category filtering then first we pick all categories from database and then create a loop.
        
        $bkb_categories = get_categories( $bkb_category_args );
        
        $total_bkb_categories = sizeof( $bkb_categories );
        
        $counter = 0;
        
        $outer_loop = 1;
        
        $end_point = $cols-1;
        
        foreach($bkb_categories as $category):
        
            $slug = $category->slug;  
        
            $category_title = $category->name;
            
            if ( $counter % $cols == 0 ) {
                
                $output .= '<div class="grid grid-pad bwl-kb">'; 

            }

                $output .= do_shortcode('[bwl_kb bkb_cat_title="'.$category_title.'" bkb_col_class="'. $bkb_col_class . '" bkb_category="'.$slug.'" limit="' . $limit . '" orderby="' . $orderby . '" order="' . $order . '" posts_count="' . $posts_count . '" bkb_list_type="' . $bkb_list_type . '" box_view="' . $box_view . '" bkb_desc="' . $bkb_desc . '" show_title="' . $show_title . '" /]');
     
                
           if ( $counter == $end_point || $total_bkb_categories == $outer_loop ) {
                    
                $output .= '</div><!-- end of .grid -->';
                
                $counter = 0;
                
            } else {
            
                $counter++;
                
            }
            
            $outer_loop++;
            
        endforeach;

        wp_reset_query();
        
    } else {
        
        // Here we get list of categories user want to display. 
        
        $categories = explode(',', $categories); 
        
        if( sizeof($categories) > 0) {
            
            $total_bkb_categories = sizeof( $categories );
        
            $counter = 0;
            
            $outer_loop = 1;
            
            $end_point = $cols-1;
            
            foreach ($categories as $category_slug) {
      
                $category_info = get_term_by( 'slug' , $category_slug, $taxonomy );
                
                $slug = $category_slug;
                
                $category_title = $category_info->name;
                
                if ( $counter % $cols == 0 ) {
                
                    $output .= '<div class="grid grid-pad bwl-kb">'; 
                
                }

                    $output .= do_shortcode('[bwl_kb bkb_cat_title="'.$category_title.'" bkb_col_class="'. $bkb_col_class . '" bkb_category="'.$slug.'" limit="'.$limit.'" orderby="' . $orderby . '" order="' . $order . '" posts_count="' . $posts_count . '" bkb_list_type="' . $bkb_list_type . '" box_view="' . $box_view . '" bkb_desc="' . $bkb_desc . '" show_title="' . $show_title . '" /]');
                 
                if ( $counter == $end_point || $total_bkb_categories == $outer_loop ) {

                    $output .= '</div><!-- end of .grid -->';

                    $counter = 0;
                    
                } else {

                    $counter++;
                }
                
                $outer_loop++;
            }
            
        }
        
    }
    
    return $output;
    
}

/*---------------------------BKB TAG SHORTCODE ------------------------------------*/

add_shortcode('bkb_tags', 'bkb_get_tag_contents');

function bkb_get_tag_contents($atts) {

    extract(shortcode_atts(array(
        'taxonomy' => 'bkb_tags',
        'meta_key' => '',
        'orderby'    => 'ID',
        'order'       => 'DESC',
        'limit'        => -1,
        'tags'       => '',
        'cols'        => 2,
        'posts_count' => 0,
        'bkb_list_type' => '', // rectangle/iconized/rounded/none
        'bkb_desc' => 0,
        'box_view' => 0,
        'show_title' => 1
        
    ), $atts));

    $output = "";
 
    $bkb_tags_args = array(
        'taxonomy' => $taxonomy,
        'hide_empty' => 1,
        'orderby' => 'title',
        'order' => 'ASC'
    );

    $bkb_col_class = bkb_get_grid_col_class($cols);
    
    if (trim($tags) == "") {

        $tags = get_categories($bkb_tags_args);
        
        $total_bkb_tags = sizeof( $tags );
        
        $counter = 0;
        
        $outer_loop = 1;
        
        $end_point = $cols-1;

        foreach ($tags as $tag):

            $slug = $tag->slug;
        
            $tag_title = $tag->name;
            
            if ( $counter % $cols == 0 ) {
                
                $output .= '<div class="grid grid-pad bwl-kb">'; 

            }

            $output .= do_shortcode('[bwl_kb bkb_cat_title="' . $tag_title . '" bkb_col_class="'. $bkb_col_class . '" bkb_tags="' . $slug . '" limit="' . $limit . '" orderby="' . $orderby . '" order="' . $order . '" posts_count="' . $posts_count . '" bkb_list_type="' . $bkb_list_type . '"  box_view="' . $box_view . '" bkb_desc="' . $bkb_desc . '" show_title="' . $show_title . '" /]');

            if ( $counter == $end_point || $total_bkb_tags == $outer_loop ) {
                    
                $output .= '</div><!-- end of .grid -->';
                
                $counter = 0;
                
            } else {
            
                $counter++;
                
            }
            
            $outer_loop++;
            
        endforeach;

        wp_reset_query();
        
    } else {

        $tags = explode(',', $tags);

        if (sizeof($tags) > 0) {
            
            $total_bkb_tags = sizeof( $tags );
        
            $counter = 0;
            
            $outer_loop = 1;
            
            $end_point = $cols-1;

            foreach ($tags as $tag_slug) {

                $tag_info = get_term_by('slug', $tag_slug, $taxonomy);

                $slug = $tag_slug;

                $tag_title = $tag_info->name;
                
                if ( $counter % $cols == 0 ) {
                
                    $output .= '<div class="grid grid-pad bwl-kb">'; 
                
                }

                $output .= do_shortcode('[bwl_kb bkb_cat_title="' . $tag_title . '" bkb_col_class="'. $bkb_col_class . '" bkb_tags="' . $slug . '" limit="' . $limit . '" orderby="' . $orderby . '" order="' . $order . '" posts_count="' . $posts_count . '" bkb_list_type="' . $bkb_list_type . '"  box_view="' . $box_view . '" bkb_desc="' . $bkb_desc . '" show_title="' . $show_title . '" /]');
                
                if ( $counter == $end_point || $total_bkb_tags == $outer_loop ) {

                    $output .= '</div><!-- end of .grid -->';

                    $counter = 0;
                    
                } else {

                    $counter++;
                }
                
                $outer_loop++;
                
            }
            
        }
        
    }

    return $output;
}

/*------------------------------ GET POLL ANSWER OPTIONS ---------------------------------*/

add_shortcode('bkb_search', 'bkb_live_search_field');

function bkb_live_search_field( ) {
    
    wp_enqueue_script( 'bkb-custom-search-script' ); // Loading Search Scripts.
    
    $bkb_live_search_html = "";
    
    $search_box_unique_id = wp_rand();
    
    $bkb_live_search_html .= '<form id="form" action="' .get_home_url().'" autocomplete="off" class="bkb-live-search-form">
                                            <div id="suggest" class="bkb_filter_container">
                                                <input type="text" size="25" value="" id="s" name="s" class="s" placeholder="' . __('Search Keywords ..... ', 'bwl-kb') . '" data-search-box-unique-id="' .$search_box_unique_id . '"/>
                                                 <span class="bkbm-btn-clear bkbm-dn"></span>
                                                <div class="suggestionsBox" id="suggestions_'.$search_box_unique_id.'" style="display: none;">
                                                    <div class="suggestionList" id="suggestionsList_'.$search_box_unique_id.'"> &nbsp; </div>
                                                </div> <!-- end suggestionsBox -->
                                            </div> <!-- end .bkb_filter_container -->
                                        </form><!--end .bkb-live-search-form -->' ;
    
    return $bkb_live_search_html;
}
 

/*------------------------------ Shortcode For Get Total No Of Post View ---------------------------------*/


add_shortcode('bkb_vc', 'bkb_vc');
        
function bkb_vc(){
    
    return bkb_post_views();
    
}


/*-------------------------------Shortcode For Voting Manager --------------------------------*/

add_shortcode('bkb_vm', 'bkb_vm'); 
        
function bkb_vm($atts){
 
     global $post;
     
     $post_id = get_the_ID();
     
     extract(shortcode_atts(array(
        'id' => $post_id,
        'status' => 1,
        'post_type' => get_post_type( $post_id )
         
    ), $atts));
     
     if ( isset($id) && $id !="" ) {
         
         $post_id = $id;
         $post_type = get_post_type( $post_id );
         $status = get_post_meta($post_id, "bkb_display_status", true);  
     }     
     
    /**
    * @Description: Parameter Definition
    * @Status: Display voting manager or not. 0. Hide 1. Show, 2. Voting Close. 
    * @Post Type: You can add custom post type to display voting manager any where of your blog.
    * @Post ID: Current Post, page, custom post ID.
    **/
    $output = bkb_shortcode_html( $status, $post_type, $post_id );
    
    return $output;
    
}


function bkb_shortcode_html( $bkb_display_status, $post_type, $post_id ) {

    $content = "";
    
    if( $bkb_display_status!="" && $bkb_display_status == 0 ) {
        
        return $content;
        
    }
 
    if( $bkb_display_status!="" && $bkb_display_status == 2 ) {
        
        
        /*------------------------------ BUILD INTERFACE ---------------------------------*/ 
    
        $bkb_interface = '<section class="bkb_container bkb_clearfix">
                                  <p class="voting-closed-message"><i class="fa fa-info-circle"></i> ' . __('Voting Closed !', 'bwl-kb') . '</p>
                                </section><!-- end .bkb_container -->';
        
        $content .= $bkb_interface;
        
        return $content;
        
    }
    
    // Display Voting Closed Message.
    
    $like_vote_counter = get_post_meta($post_id, "bkb_like_votes_count", true);  
    
    if ( $like_vote_counter == "" ) {
        $like_vote_counter = 0;
    }
    
    $dislike_vote_counter = get_post_meta($post_id, "bkb_dislike_votes_count", true);  
    
    if ( $dislike_vote_counter == "" ) {
        $dislike_vote_counter = 0;
    }
    
     $bkb_feedback_message_unique_id = 'bkb_feedback_list_'.$post_id; // so idea is we are going to add post id after vairable name
     
     $prev_bkb_feedback_message = get_post_meta($post_id, $bkb_feedback_message_unique_id);  
    
     $total_vote_counter = $like_vote_counter+$dislike_vote_counter;
     
     $like_percentage = bkb_calculate_percentage( $total_vote_counter, $like_vote_counter);
     $dislike_percentage = bkb_calculate_percentage($total_vote_counter, $dislike_vote_counter);
 
     $bkb_data = get_option('bkb_options');
     
     /*------------------------------ Feedback Title ---------------------------------*/
     
     if( isset($bkb_data ['bkb_feedback_form_title']) && $bkb_data ['bkb_feedback_form_title'] != "" ) {
        
         $bkb_feedback_form_title = $bkb_data ['bkb_feedback_form_title'];
         
     } else {
         
         $bkb_feedback_form_title = "Tell us how can we improve this post?";
         
     }
     
     /*------------------------------ Add Custom Icon For Like Button  ---------------------------------*/
     
      if( isset($bkb_data ['bkb_like_thumb_icon']) && $bkb_data ['bkb_like_thumb_icon'] != "" ) {
        
         $bkb_like_thumb_icon = $bkb_data ['bkb_like_thumb_icon'];
         
         $bkb_like_thumb_html = '<i class="fa ' . $bkb_like_thumb_icon . ' bkb_icon_like_color"></i>';
         
     } else {
         
         $bkb_like_thumb_icon = "fa-thumbs-o-up";
         
         $bkb_like_thumb_html = '<i class="fa ' . $bkb_like_thumb_icon . ' bkb_icon_like_color"></i>';
         
     }
     
     /*------------------------------ Add Custom Icon For Dislike Button  ---------------------------------*/
     
     if( isset($bkb_data ['bkb_dislike_thumb_icon']) && $bkb_data ['bkb_dislike_thumb_icon'] != "" ) {
        
         $bkb_dislike_thumb_icon = $bkb_data ['bkb_dislike_thumb_icon'];
         
         $bkb_dislike_thumb_html = '<i class="fa ' . $bkb_dislike_thumb_icon . ' bkb_icon_dislike_color"></i>';
         
     } else {
         
         $bkb_dislike_thumb_icon = "fa-thumbs-o-down";
         
         $bkb_dislike_thumb_html = '<i class="fa ' . $bkb_dislike_thumb_icon . ' bkb_icon_dislike_color"></i>';
         
     }
     
     /*------------------------------ Custom Image For Like Button ---------------------------------*/
   
         if( isset( $bkb_data ['bkb_like_conditinal_fields']['enabled']) && $bkb_data['bkb_like_conditinal_fields']['enabled'] == 'on' ){
             
             $bkb_custom_like_icon = $bkb_data['bkb_like_conditinal_fields']['bkb_custom_like_icon'];
             
             if( isset( $bkb_custom_like_icon ['src'] ) && $bkb_custom_like_icon['src'] != "" ){
                 
                 $bkb_like_thumb_html = '<img src="' . $bkb_custom_like_icon['src'] . '" class="bkb-custom-icon"/>';
                 
            }
         
        }
        
        
      /*------------------------------ Custom Image For Dislike Button ---------------------------------*/
   
         if( isset( $bkb_data ['bkb_dislike_conditinal_fields']['enabled']) && $bkb_data['bkb_dislike_conditinal_fields']['enabled'] == 'on' ){
             
             $bkb_custom_dislike_icon = $bkb_data['bkb_dislike_conditinal_fields']['bkb_custom_dislike_icon'];
             
             if( isset( $bkb_custom_dislike_icon ['src'] ) && $bkb_custom_dislike_icon['src'] != "" ){
                 
                 $bkb_dislike_thumb_html = '<img src="' . $bkb_custom_dislike_icon['src'] . '" class="bkb-custom-icon"/>';
                 
            }
         
        }  
     
     
     /*------------------------------ Down Vote Status ---------------------------------*/
     
     $bkb_disable_down_vote_status = 0;
     
     if( isset( $bkb_data['bkb_disable_down_vote_status'] ) && $bkb_data['bkb_disable_down_vote_status'] == 1 ) {
            
            $bkb_disable_down_vote_status = 1;
            
    }
     
     /*------------------------------ ADD VOTE STATUS ---------------------------------*/
     
     $vote_given_status = 0;
     
     $bkb_tipsy_like_title = "Like The Post";
     
     // Like Bar Color.
        
     if( isset( $bkb_data['bkb_tipsy_like_title'] ) && $bkb_data['bkb_tipsy_like_title']!="" ) {

        $bkb_tipsy_like_title = $bkb_data['bkb_tipsy_like_title']; 

     }
     
     $bkb_tipsy_dislike_title = "Dislike The Post";
     
     // Dislike Bar Color.
        
     if( isset( $bkb_data['bkb_tipsy_dislike_title'] ) && $bkb_data['bkb_tipsy_dislike_title']!="" ) {

        $bkb_tipsy_dislike_title = $bkb_data['bkb_tipsy_dislike_title']; 

     }
     
     
     if( $vote_given_status == 1) {
 
         $bkb_btn_container_html = '<div class="msg_container" id="msg_container_'.$post_id.'"> ' . __('Loading .....', 'bwl-kb') . '</div>';
         
     } else {
         
         if ( $bkb_disable_down_vote_status == 1 ) {
             
             $bkb_btn_container_html = '<div class="btn_like" title="' . $bkb_tipsy_like_title . '" vote_status="1" post_id="' . $post_id .'">' . $bkb_like_thumb_html . '</div>';
             
         } else {
         
         $bkb_btn_container_html = '<div class="btn_like" title="' . $bkb_tipsy_like_title . '" vote_status="1" post_id="' . $post_id .'">' . $bkb_like_thumb_html . '</div>
                                               <div class="btn_dislike" title="' . $bkb_tipsy_dislike_title . '" vote_status="0" post_id="' . $post_id .'">' . $bkb_dislike_thumb_html . '</div>';
         
         }
     }
    
     
    /*------------------------------ BUILD INTERFACE ---------------------------------*/ 
     
     
     $bkb_like_count_container_string = '<div class="like-count-container">'.$bkb_like_thumb_html.' <span>' . $like_vote_counter . '</span></div>';
     $bkb_dislike_count_container_string = '<div class="dislike-count-container">'.$bkb_dislike_thumb_html.' <span>' . $dislike_vote_counter . '</span></div>';
     
     if ( $bkb_disable_down_vote_status == 1 ) {
         $bkb_dislike_count_container_string = "";
     }
    
    $bkb_interface = '<section class="bkb_container bkb_clearfix">
                                 <div class="bkb_btn_container bkb_clearfix" id="bkb_btn_container_' . $post_id . '">
                                    ' . $bkb_btn_container_html . '
                                 </div>
                                <div class="stat-cnt" id="stat-cnt-' . $post_id . '">
                                    <div class="total-vote-counter">' . __('Total', 'bwl-kb') . ' <span>' . $total_vote_counter .'</span> ' . __('Votes:', 'bwl-kb') . '</div>
                                    <div class="stat-bar">
                                        <div class="bg-green like_percentage" style="width:' . $like_percentage  .'%;"></div>
                                        <div class="bg-red dislike_percentage" style="width:' . $dislike_percentage  .'%;"></div>
                                    </div>
                                    ' . $bkb_dislike_count_container_string . $bkb_like_count_container_string .'
                                </div>
                            </section>';
    
    $content .= $bkb_interface;
    
    $bkb_form_id = "bkb_feedback_form_".$post_id;
    
    $captcha_status = 1;
    
    $bkb_captcha_generator = '<p>
                                                <label for="captcha">' . __('Captcha:', 'bwl-kb') . '</label>
                                                    <input id="num1" class="sum" type="text" name="num1" value="' . rand(1,4) . '" readonly="readonly" /> +
                                                    <input id="num2" class="sum" type="text" name="num2" value="' . rand(5,9) . '" readonly="readonly" /> =
                                                    <input id="captcha" class="captcha" type="text" name="captcha" maxlength="2" />
                                                    <input id="captcha_status" type="hidden" name="captcha_status" value="' . $captcha_status . '" />
                                                <span id="spambot"> '. __('Verify Human or Spambot ?', 'bwl-kb') .'</span>
                                            </p>';   
    
    $bkb_form_body = '<section class="bkb-feedback-form-container bkb_clearfix" id="' . $bkb_form_id . '">
                    
                                        <h2>' . $bkb_feedback_form_title . ' </h2>

                                        <div class="bwl_pro_form_error_message_box"></div>
                                            
                                        <form id="bkb_feedback_form" class="bkb_feedback_form" name="bkb_feedback_form" method="post" action="#"> 
                                        
                                                <p>        
                                                    <textarea id="feedback_message" class="feedback_message_box" placeholder="'.__('Write feedback message ..... ', 'bwl-kb').'"/></textarea>

                                                ' . $bkb_captcha_generator . '

                                                <p class="bkb_feedback_submit_container">
                                                    <input type="submit" value="' . __('Submit', 'bwl-kb') . '" tabindex="6" id="submit" name="submit" bkb_feedback_form_id= "' . $bkb_form_id . '" post_id="' . $post_id .'"/>
                                                </p>

                                                <input type="hidden" name="post_type" id="post_type" value="bwl_pro_voting_manager" />

                                                <input type="hidden" name="action" value="bwl_pro_voting_manager" />'

                                                . wp_nonce_field( 'name_of_my_action','name_of_nonce_field' ) .
            
                                           '</form>

                                        </section>';
    
    $content .= $bkb_form_body;
    
    return $content;

}

/*
 * 
 * @Description: Shortcode to set custom ask a from modal window any here of your site. 
 * @since 1.0.3
 * @create date: 08-12-2014
 * @lasr update: 08-12-2014
 * @uses $shortcode_tags
 *
 * @param string $link Shortcode tag to be searched in post content.
 * @param callable $type Hook to run when shortcode is found.
 */
/***********************************************************************************************/

add_shortcode('bkb_ask_form', 'bkb_ask_form');

function bkb_ask_form( $atts ) {
    
    extract(shortcode_atts(array(
        'title'     => __('Add a Question', 'bwl-kb'),
        'type'         => 'link'
         
    ), $atts));
    
     $bkb_modal_random_id = wp_rand();   
    
//     $bkb_ask_ques_modal = '<div data-remodal-id="bkb_ask_ques_modal_'.$bkb_modal_random_id.'">'
     $bkb_ask_ques_modal = '<div data-remodal-id="bkb_ask_ques_modal">'
                                            .  do_shortcode("[bkb_ques_form /]") .
                                        '</div>';
    
    return $bkb_ask_ques_modal . '<a href="#" class="bkb_ask_ques" data-modal_id="'.$bkb_modal_random_id.'">'.$title.'</a>';
    
}