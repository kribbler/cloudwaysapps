<?php

function cb_bkb_post_view_counter( $content ) {
    
    if ( ! is_singular('bwl_kb') ) {
        return $content;
    }

    if ( is_singular('bwl_kb') ) {
        
        global $post;

        $postID = $post->ID;
        
        $bkb_post_view_ip = $_SERVER['REMOTE_ADDR'];

        $count_key = 'bkbm_post_views';
        
        $count = get_post_meta($postID, $count_key, true);
        
        // Return current post IP and last view time information as an Array.
        
        $get_post_view_ip = get_post_meta($postID, "bkb_post_view_ip");  // Get voters'IPs for the current post 
        
        if ( $count == '' ) {
            
            $count = 0;
            
            delete_post_meta($postID, $count_key);
            
            $bkb_set_post_view_ip_info = array(
                'IP' => $bkb_post_view_ip,
                'view_time' => time()
            );
            
            add_post_meta($postID, "bkb_post_view_ip", $bkb_set_post_view_ip_info);
            add_post_meta($postID, $count_key, '1');
            
        } else {
            
             $view_time_interval = 1440; // = 24 hours = 1440 Mins  If user visit after 2 hours of his previous view then we count another view.
            
             $now = time();  
             
             if( sizeof( $get_post_view_ip ) == 0 ) {
                 
                 $last_bkb_post_view_ip = $bkb_post_view_ip;
                 $last_view_time = 0;
                 
             } else {
                 
                 $last_bkb_post_view_ip = $get_post_view_ip[0]['IP'];
                 $last_view_time = $get_post_view_ip[0]['view_time'];
                 
             }
          
            // Compare between current time and vote time 
        
            if( $last_bkb_post_view_ip != $bkb_post_view_ip || ( round(($now - $last_view_time) / 60 ) > $view_time_interval ) ) {
                
                $count++;
                
                $bkb_set_post_view_ip_info = array(
                    'IP' => $bkb_post_view_ip,
                    'view_time' => time()
                );

                update_post_meta($postID, "bkb_post_view_ip", $bkb_set_post_view_ip_info);
                
                update_post_meta($postID, $count_key, $count);
                
            }
            
        }
        
//        $bkb_post_breadcrumb = bkb_get_post_breadcrumb();
        
        
        $bkb_data = get_option('bkb_options');
     
        $total_post_view_html = "";
        $bkb_post_breadcrumb = "";
        $no_of_post_views = "";
        $bkb_edit_link_interface = "";
        
        // Filter date meta display status.
        
        if( ! isset( $bkb_data['bkb_meta_date_status'] ) || $bkb_data['bkb_meta_date_status'] == 1 ) {

            $bkb_post_date_time_info = '<i class="fa fa-clock-o"></i> ' .get_the_time('M j, Y') . ' &nbsp; ';
            
            $total_post_view_status = 1;

        } else {
            
            $bkb_post_date_time_info = "";
            
        }
        
        // Filter no of post view display status.
        
        if( ! isset( $bkb_data['bkb_meta_view_status'] ) || $bkb_data['bkb_meta_view_status'] == 1 ) {

            $no_of_post_views = '<i class="fa fa-eye"></i> ' . do_shortcode("[bkb_pv /]") . ' &nbsp; ';

        } else {
            
            $no_of_post_views = "";
            
        }
        
        // Filter post author name display status.
        
        $bkb_post_author_info = "";
        
        if( ! isset( $bkb_data['bkb_meta_author_status'] ) || $bkb_data['bkb_meta_author_status'] == 1 ) {
            
            $bkb_authors = get_post_meta( $postID, "bkb_authors", true);

            $bkb_post_author_info = ( $bkb_authors == "" ) ?  get_the_author_link() : get_the_author_meta('display_name', $bkb_authors) ;
            $bkb_post_author_info = '<i class="fa fa-user"></i> ' . $bkb_post_author_info . ' &nbsp; ';
            
        }
        
        
        $bkbm_post_categories = ""; // Initialize Categories value.
        
        $bkbm_post_categories = do_shortcode("[bkb_gpc /]");
        
        $bkbm_post_tags = ""; // Initialize Categories value.
        
        $bkbm_post_tags = do_shortcode("[bkb_gpt /]");
        
        $post_voting_interface = do_shortcode("[bkb_vm /]");
        
        $bkb_related_kb = do_shortcode("[bkb_grp /]");
        
        $bkb_ques_form = do_shortcode("[bkb_ques_form /]");
        
        $bkb_attachment = do_shortcode("[bkb_attachment /]");
        
        
        // Filter post category display status.
        
        if( ! isset( $bkb_data['bkb_meta_category_status'] ) || $bkb_data['bkb_meta_category_status'] == 1 ) {
        
            if ( $bkbm_post_categories != "" ) {

                $bkbm_post_categories = '<i class="fa fa-bookmark"></i> &nbsp;'.$bkbm_post_categories . ' &nbsp; ';

            }
            
        } else {
            
            $bkbm_post_categories = "";
            
        }
        
        // Filter Post Tag display status.
        
        if( ! isset( $bkb_data['bkb_meta_topics_status'] ) || $bkb_data['bkb_meta_topics_status'] == 1 ) {
        
            if ( $bkbm_post_tags != "" ) {

                $bkbm_post_tags = '<i class="fa fa-tags"></i> &nbsp;' . $bkbm_post_tags;

            }
            
        } else {
            
            $bkbm_post_tags = "";
            
        }
        
        // Finally we count if all string length is greater than zero or not.
        
        if ( strlen( $bkb_post_date_time_info . $no_of_post_views . $bkb_post_author_info . $bkbm_post_categories . $bkbm_post_tags ) > 0 ) {
        
            $total_post_view_html = '<div class="bkpm-total-post-view">'
                                                        . $bkb_post_date_time_info
                                                        . $no_of_post_views
                                                        . $bkb_post_author_info
                                                        . $bkbm_post_categories
                                                        . $bkbm_post_tags .
                                              '</div>';
        
        }
        
        if( current_user_can( 'edit_post', $postID ) ) {
                $bkb_edit_link = get_edit_post_link();
                $bkb_edit_link_interface = '<a href="'.$bkb_edit_link.'" target="_blank" title="'.get_the_title().'" class="bkb-post-edit-link"><span class="fa fa-edit"></span> ' . __('Edit', 'bwl-kb') . '</a>';
        }
        
    
        $content .= $bkb_edit_link_interface . $bkb_attachment . $bkb_post_breadcrumb . $total_post_view_html . $post_voting_interface . $bkb_related_kb . $bkb_ques_form;
        
        return $content;
        
    }
    
}
    
add_filter('the_content', 'cb_bkb_post_view_counter', 10, 1);

/*-------------------------- Get Total No Of Post Viwes -------------------------------------*/

add_shortcode('bkb_pv', 'bkb_post_views');
    
function bkb_post_views() {

    global $post;

    $postID = $post->ID;

    $count_key = 'bkbm_post_views';
    $count = get_post_meta($postID, $count_key, true);

    if ($count == '') {
        $count = 0;
    }

    return $count;
    
}

/*--------------------------- GET Knowledge Base Categories------------------------------------*/

add_shortcode('bkb_gpc', 'bkb_get_post_categories');
        
function bkb_get_post_categories() {

    global $post;

    $postID = $post->ID;
//    the_taxonomies($args);
    $terms = wp_get_post_terms($postID, 'bkb_category');

    $bkb_single_post_categories = "";

    if (sizeof($terms) > 0) {

        $bkb_single_post_categories .='<span class="bkb-single-post-categories">';

        foreach ($terms as $term) {

            $bkb_single_post_categories .='<a href="' . get_term_link($term->slug, 'bkb_category') . '" title="' . ucwords($term->name) . '">' . ucwords($term->name) . '</a>, ';
        }

        $bkb_single_post_categories = substr($bkb_single_post_categories, 0, strlen($bkb_single_post_categories) - 2);

        $bkb_single_post_categories .='</span>';
    }

    return $bkb_single_post_categories;
    
}

/*--------------------------- Knowledge Base Tags------------------------------------*/

add_shortcode('bkb_gpt', 'bkb_get_post_tags');
        
function bkb_get_post_tags() {

    global $post;

    $postID = $post->ID;

    $terms = wp_get_post_terms($postID, 'bkb_tags');

    $bkb_single_post_tags = "";

    if (sizeof($terms) > 0) {

        $bkb_single_post_tags .='<span class="bkb-single-post-tags">';

        foreach ($terms as $term) {

            $bkb_single_post_tags .='<a href="' . get_term_link($term->slug, 'bkb_tags') . '" title="' . ucwords($term->name) . '">' . ucwords($term->name) . '</a> , ';
        }

        $bkb_single_post_tags = substr($bkb_single_post_tags, 0, strlen($bkb_single_post_tags) - 2);

        $bkb_single_post_tags .='</span>';
    }

    return $bkb_single_post_tags;
}


/*---------------------------BKB Related Post ------------------------------------*/

add_shortcode('bkb_grp', 'get_bkb_related_kb');
        
function get_bkb_related_kb($id) {

    $id = get_the_ID();

    $bkb_related_post_display_status = TRUE;

    $get_bkb_related_post_display_status = trim(get_post_meta($id, 'bkb_related_post_display_status', true));

    if (isset($get_bkb_related_post_display_status) && $get_bkb_related_post_display_status != "" && $get_bkb_related_post_display_status == 0) {

        $bkb_related_post_display_status = FALSE;

        return '';
        
    }

    $bkb_related_post_filter_type = 'category';

    $get_bkb_related_post_filter_type = trim(get_post_meta($id, 'bkb_related_post_filter_type', true));

    if (isset($get_bkb_related_post_filter_type) && $get_bkb_related_post_filter_type != "" && $get_bkb_related_post_filter_type == 1) {

        $bkb_related_post_filter_type = 'tags';
    }

    $cats = array();

    if (isset($bkb_related_post_filter_type) && $bkb_related_post_filter_type == 'category') {

        $terms = wp_get_object_terms($id, 'bkb_category');

        if( sizeof($terms) > 0 ) {

            foreach ($terms as $term) {

                $cats[] = $term->term_id; // store categoires in array.
            }

        } else {
            
            $cats = "";
            
        }

        $args = array(
            'post_type' => 'bwl_kb',
            'post__not_in' => array($id),
            'showposts' => 3,
            'orderby' => 'rand',
            'tax_query' => array(
                array(
                    'taxonomy' => 'bkb_category',
                    'field' => 'id',
                    'terms' => $cats
                )
            )
        );
    }

    // Just consider, a post may contain more than 1 tags, so we need to create an array to store all tags.

    $tags = array();

    if (isset($bkb_related_post_filter_type) && $bkb_related_post_filter_type == 'tags') {

        $terms = wp_get_object_terms($id, 'bkb_tags');

        if( sizeof($terms) > 0 ) {

            foreach ($terms as $term) {

                $tags[] = $term->term_id; // store tags in array.
            }

        } else {
            
            $tags = "";
            
        }

        $args = array(
            'post_type' => 'bwl_kb',
            'post__not_in' => array($id),
            'showposts' => 3,
            'orderby' => 'rand',
            'tax_query' => array(
                array(
                    'taxonomy' => 'bkb_tags',
                    'field' => 'id',
                    'terms' => $tags
                )
            )
        );
    }

    $loop = new WP_Query($args); // Finally we pass arguments WP_Query Function.
    
    $bkb_related_kb_string = '<section class="bkb_related_posts bkb_clearfix">';

    $bkb_related_post_heading = __("Related Knowledge Base Posts -", 'bwl-kb');

    $bkb_related_kb_string .= '<h2>' . $bkb_related_post_heading . '</h2>';

    if ($loop->have_posts()) {

        $bkb_related_kb_string .= '<ul class="bkb-related-posts">';

        while ($loop->have_posts()) {

            $loop->the_post();

            $bkb_related_kb_string .='<li>';
            $bkb_related_kb_string .= '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
            $bkb_related_kb_string .="</li>";
        }

        $bkb_related_kb_string .= '</ul>';

        wp_reset_query(); // reset SQL query. VERY IMPORTANT.
        
    } else {

        $bkb_related_kb_string .="<p>" . __('No related posts found !', 'bwl-kb') . "</p>";
    }

    $bkb_related_kb_string .='</section>';
    
    wp_reset_query();
    
    return $bkb_related_kb_string; // Finally return content with related post.
    
}


/*------------------------------ BKB Post Attachemnt  ---------------------------------*/

/*---------------------------BKB Related Post ------------------------------------*/

add_shortcode('bkb_attachment', 'get_bkb_attachment');
        
function get_bkb_attachment( $id ) {

    $id = get_the_ID();
    
    $bkb_file_attachment_string = "";
    $bkb_display_file_name_status = 0;
    
    $bkb_data = get_option('bkb_options');
    
    if( isset($bkb_data['bkb_display_file_name_status']) && $bkb_data['bkb_display_file_name_status']==1  ) {
        $bkb_display_file_name_status = 1;
    }

    $get_bkb_attachment_ids =  get_post_meta(get_the_ID(), 'bkb_attachment_files');
    
    if ( sizeof($get_bkb_attachment_ids) > 0 ) {
        
        
        $bkb_file_attachment_string .= '<section class="bkb_file_attachment bkb_clearfix">';

        $bkb_file_attachment_heading = __("Attachments -", 'bwl-kb');

        $bkb_file_attachment_string .= '<h2>' . $bkb_file_attachment_heading . '</h2>';
        
        $counter  = 1;
        
        $bkb_file_attachment_string .= '<ul class="bkb-attachment-items">';
        
        foreach ($get_bkb_attachment_ids as $attachment_post_id){
             
            $get_bkb_attachment_url = get_post_meta( $attachment_post_id, '_wp_attached_file', true);
            
            $bkb_file_attachment_string .='<li>';
            
//            echo $bkb_display_file_name_status;
//            die();
            
                if( $bkb_display_file_name_status == 1 ) {
                    
                    $bkb_file_name = ' '.basename($get_bkb_attachment_url);
                    
                } else {
            
                    $bkb_file_name =  __(' File# ', 'bwl-kb') . $counter;
                
                }
            
                $bkb_file_attachment_string .= '<a href="'.home_url().'/wp-content/uploads/' . $get_bkb_attachment_url .'" target="_blank">' . $bkb_file_name . '</a>';
            
            $bkb_file_attachment_string .='</li>';
            
            $counter++;
             
        }
        
        $bkb_file_attachment_string .= '</ul>';
        
        $bkb_file_attachment_string .='</section>';
        
    }
    
    return $bkb_file_attachment_string;
     
}