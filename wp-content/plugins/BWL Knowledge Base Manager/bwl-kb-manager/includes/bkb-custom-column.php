<?php

 /*------------------------------  Custom Column Section ---------------------------------*/
// After manage text we need to add "custom_post_type" value.

add_filter('manage_bwl_kb_posts_columns', 'bkb_custom_column_header' );

 // After manage text we need to add "custom_post_type" value.

add_action('manage_bwl_kb_posts_custom_column', 'bkb_display_custom_column', 10, 1);


function bkb_custom_column_header( $columns ) {
    
     $columns = array();
    
     $columns['cb'] = 'cb';
     
     $columns['title'] = __('KB Title', 'bwl-kb');
     
     $columns['bkb_authors'] = __('Author', 'bwl-kb');
     
     $columns['bkb_category'] = __('Category', 'bwl-kb');
     
     $columns['bkb_tags'] = __('Tags', 'bwl-kb');
     
     $columns['bkb_fa_id'] = __('Icon', 'bwl-kb');
     
     $columns['bkbm_post_views'] = __('Views', 'bwl-kb');
     
     $columns['bkb_like_votes_count'] = __('Like', 'bwl-kb');
     
     $columns['bkb_dislike_votes_count'] = __('Dislike', 'bwl-kb');
     
     $columns['bkb_feedback'] = __('Feedback', 'bwl-kb');
     
     $columns['bkb_display_status'] = __('Voting Box', 'bwl-kb');
     
     $columns['bkb_featured_status'] = __('Featured', 'bwl-kb');
     
     $columns['date'] = __('Date', 'bwl-kb');
     
    if ( ( in_array('kb-display-as-blog-post/kb-display-as-blog-post.php', apply_filters('active_plugins', get_option('active_plugins')))  && class_exists('BKB_kbdabp') )) {
     
         $columns['bkb_kbdabp_status'] = __('Hide From<br />Blog List?', 'bwl-kb');
         
     }
    
     return $columns;
 }


 
function bkb_display_custom_column( $column ) {

    // Add A Custom Image Size For Admin Panel.
    
    global $post;
    
    switch ( $column ) {
        
        case 'bkb_authors':
            
            $bkb_authors = get_post_meta( $post->ID, "bkb_authors", true);
            
            if( $bkb_authors == "" ) {
                
                $bkb_post_info = get_post( $post->ID ); // $id - Post ID
                $bkb_author_id = $bkb_post_info->post_author; // print post author ID
                
            } else {
            
                $bkb_author_id = $bkb_authors;
                
            }

            $bkb_post_author_info = ( $bkb_authors == "" ) ?  get_the_author_link() : get_the_author_meta('display_name', $bkb_authors) ; 
            echo '<div id="bkb_authors-' . $post->ID . '" data-bkb_author_id="'.$bkb_author_id.'">' . $bkb_post_author_info . '</div>';

            break;
        
        case 'bkb_category':

            $bkb_category = "";

            $get_bkb_categories = get_the_terms($post->ID, 'bkb_category');

            if (is_array($get_bkb_categories) && count($get_bkb_categories) > 0) {

                foreach ($get_bkb_categories as $category) {

                    $bkb_category .= $category->name . ", ";
                }

                echo substr($bkb_category, 0, strlen($bkb_category) - 2);
            } else {

                _e('Uncategorized', 'bwl-kb');
            }

            break;

        case 'bkb_tags':

            $bkb_topics = "";

            $get_faq_topics = get_the_terms($post->ID, 'bkb_tags');

            if (is_array($get_faq_topics) && count($get_faq_topics) > 0) {

                foreach ($get_faq_topics as $topic) {

                    $bkb_topics .= $topic->name . ", ";
                }

                echo substr($bkb_topics, 0, strlen($bkb_topics) - 2);
            } else {

                echo "—";
            }

            break;
            
        case 'bkb_fa_id':

                $bkb_fa_id = ( get_post_meta($post->ID, "bkb_fa_id", true ) == "" ) ? '-' : '<i class="'. get_post_meta($post->ID, "bkb_fa_id", true).'"></i>';  
                echo '<div id="bkbm_post_views-' . $post->ID . '" >'. $bkb_fa_id.'</div>';

        break;    
        
        case 'bkbm_post_views':

                $bkbm_post_views = ( get_post_meta($post->ID, "bkbm_post_views", true ) == "" ) ? 0 : get_post_meta($post->ID, "bkbm_post_views", true);  
                echo '<div id="bkbm_post_views-' . $post->ID . '" >&nbsp;' . $bkbm_post_views . '</div>';

        break;
    
        case 'bkb_featured_status':

                    $bkb_featured_status = ( get_post_meta($post->ID, "bkb_featured_status", true ) == 1 ) ? 1 : 0;
                    
                    if( $bkb_featured_status == 1 ) {
                    
                        $bkb_featured_status_text = __('Yes', 'bwl-kb');

                    } else {

                        $bkb_featured_status_text = __('No', 'bwl-kb');

                    }

                    echo '<div id="bkb_featured_status-' . $post->ID . '" data-status_code="'.$bkb_featured_status.'">' . $bkb_featured_status_text . '</div>';
                    

        break;
    
        case 'bkb_like_votes_count':

                $like_vote_counter = ( get_post_meta($post->ID, "bkb_like_votes_count", true ) == "" ) ? 0 : get_post_meta($post->ID, "bkb_like_votes_count", true);  
                echo '<div id="bkb_like_votes_count-' . $post->ID . '" >&nbsp;' . $like_vote_counter . '</div>';

        break;
    
        case 'bkb_dislike_votes_count':
        
                $dislike_vote_counter = ( get_post_meta($post->ID, "bkb_dislike_votes_count", true ) == "" ) ? 0 : get_post_meta($post->ID, "bkb_dislike_votes_count", true);  
                echo '<div id="bkb_dislike_votes_count-' . $post->ID . '">&nbsp;' . $dislike_vote_counter . '</div>';
            
        break;
    
        case 'bkb_display_status':
        
                $bkb_display_status = ( get_post_meta($post->ID, "bkb_display_status", true ) == "" ) ? 1 : get_post_meta($post->ID, "bkb_display_status", true);  
                
                if( $bkb_display_status == 2 ) {
                    
                    $bkb_display_status_text = __('Closed', 'bwl-kb');
                    
                } else if( $bkb_display_status == 1 ) {
                    
                    $bkb_display_status_text = __('Show', 'bwl-kb');
                    
                } else {
                    
                    $bkb_display_status_text = __('Hidden', 'bwl-kb');
                    
                }
            
                echo '<div id="bkb_display_status-' . $post->ID . '" data-status_code="'.$bkb_display_status.'">' . $bkb_display_status_text . '</div>';
            
        break;
    
        case 'bkb_feedback':
        
                $bkb_feedback_message_unique_id = 'bkb_feedback_list_'.$post->ID; // so idea is we are going to add post id after vairable name
         
                $prev_bkb_feedback_message = get_post_meta( $post->ID, $bkb_feedback_message_unique_id );
        
                
                if( isset($prev_bkb_feedback_message[0]) ) {
                
                   $prev_bkb_feedback_message_counter = sizeof($prev_bkb_feedback_message[0]);
                
                } else {
                    
                   $prev_bkb_feedback_message_counter = 0; 
                    
                }
//                
                echo '<div id="bkb_dislike_votes_count-' . $post->ID . '" class="bkb_alignment">' . $prev_bkb_feedback_message_counter . '</div>';
            
        break;
        
        case 'bkb_kbdabp_status':
            
            if ( ( in_array('kb-display-as-blog-post/kb-display-as-blog-post.php', apply_filters('active_plugins', get_option('active_plugins')))  && class_exists('BKB_kbdabp') )) {
                
                $bkb_kbdabp_status = get_post_meta($post->ID, "bkb_kbdabp_status", true);

                $bkb_kbdabp_status_name = ( $bkb_kbdabp_status == 1 ) ? __('Yes', 'bwl-kb') : __('No', 'bwl-kb');

                echo '<div id="bkb_kbdabp_status-' . $post->ID . '" data-status_code="' . $bkb_kbdabp_status . '">
                        ' . $bkb_kbdabp_status_name . '
                    </div>';
            
            }

        break;
        
            
    }
    
}


/*-----------------------------Make Column Sortable ----------------------------------*/

add_filter( 'manage_edit-bwl_kb_sortable_columns', 'bkb_sortable_column' );

function bkb_sortable_column( $columns ) {
    $columns['bkbm_post_views'] = 'bkbm_post_views';
    $columns['bkb_like_votes_count'] = 'bkb_like_votes_count';
    $columns['bkb_dislike_votes_count'] = 'bkb_dislike_votes_count';
 
    //To make a column 'un-sortable' remove it from the array
    //unset($columns['date']);
 
    return $columns;
}

add_action( 'pre_get_posts', 'bkb_manage_wp_posts_order', 1 );

function bkb_manage_wp_posts_order( $query ) {
        
   if ( $query->is_main_query() && ( $orderby = $query->get( 'orderby' ) ) ) {

      switch( $orderby ) {
        
         case 'bkbm_post_views':
            $query->set( 'meta_key', 'bkbm_post_views' );
            $query->set( 'orderby', 'meta_value' );
            break;
        
         case 'bkb_like_votes_count':
            $query->set( 'meta_key', 'bkb_like_votes_count' );
            $query->set( 'orderby', 'meta_value' );
            break;
        
         case 'bkb_dislike_votes_count':
            $query->set( 'meta_key', 'bkb_dislike_votes_count' );
            $query->set( 'orderby', 'meta_value' );
            break;

      }

   }

}