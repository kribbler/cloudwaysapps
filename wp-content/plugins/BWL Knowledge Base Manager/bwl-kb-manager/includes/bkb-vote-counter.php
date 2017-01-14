<?php

function bkb_check_already_voted( $post_id )  {
    
    /*------------------------------ IP Filter Status ---------------------------------*/
    
    $bkb_options = get_option('bkb_options');
     
     if ( isset($bkb_options['bkb_ip_filter_status']) && $bkb_options['bkb_ip_filter_status'] == 0 ) {
         
         return FALSE; // remove this !
         
     }
    
    $timebeforerevote = 120; // = 2 hours  
    
    if ( isset($bkb_options['bkb_vote_interval'] ) && is_numeric( $bkb_options['bkb_vote_interval'] ) ) { 
            
       $timebeforerevote = $bkb_options['bkb_vote_interval'];

    }
  
    // Retrieve post votes IPs  
    $meta_IP = get_post_meta($post_id, "bkb_voted_ip");
    
    $like_vote_counter = get_post_meta($post_id, "bkb_like_votes_count", true);  
    $dislike_vote_counter = get_post_meta($post_id, "bkb_dislike_votes_count", true);  
    
    
    if( ( $like_vote_counter == "" || $like_vote_counter == 0 ) && ($dislike_vote_counter == "" || $dislike_vote_counter == 0 ) ) {
        
        return false;
        
    }
    
    
    if( !empty($meta_IP)) {
        
        $voted_IP = $meta_IP[0];  
        
    } else {
        
         $voted_IP = array();  
         
    } 
          
    // Retrieve current user IP  
    $ip = $_SERVER['REMOTE_ADDR'];  
  
    // If user has already voted  
    if ( in_array($ip, array_keys($voted_IP)) ) {
        
        $time = $voted_IP[$ip];
        
        $now = time();  
          
        // Compare between current time and vote time 
        
        if( round(($now - $time) / 60 ) > $timebeforerevote ) {
            
            return false;
            
        }
              
        return true;  
        
    }  
      
    return false;  
    
}


function bkb_add_rating() {

     if( isset($_REQUEST['count_vote']) ) {

        // Retrieve user IP address  
         
        $ip          = $_SERVER['REMOTE_ADDR'];
        
        $post_id  = $_POST['post_id'];
        
        $vote_status  = $_POST['vote_status'];
        
        $meta_IP = get_post_meta($post_id, "bkb_voted_ip");  // Get voters'IPs for the current post  
        
        if (!empty($meta_IP)) {
            
            $bkb_voted_ip = $meta_IP[0];
            
        } else {
            
            $bkb_voted_ip = array();
            
        }
        
        // check if user logged in or not.
        
        $bkb_data = get_option('bkb_options');
        
        $bkb_login_status = FALSE;
        
        if( isset( $bkb_data['bkb_login_status'] ) && $bkb_data['bkb_login_status']==1 ) {
            
            $bkb_login_status = FALSE;        
            
            if ( is_user_logged_in() ) :
                $bkb_login_status = TRUE;        
            endif;
            
            if( $bkb_login_status == FALSE ) {
            
                $data = array (
                    'status'            => 0,
                    'msg'               => __(' LogIn Required To submit vote!', 'bwl-kb')
                );

                echo json_encode($data);
                
                die();
            
            }
            
        }
        
        

        if( ! bkb_check_already_voted( $post_id ) ) {
            
            $bkb_voted_ip[$ip] = time();  
            
            $like_vote_counter = get_post_meta($post_id, "bkb_like_votes_count", true);        
            
             if ( $like_vote_counter == "" ) {
                $like_vote_counter = 0;
            }
            
            $dislike_vote_counter = get_post_meta($post_id, "bkb_dislike_votes_count", true); 
            
            if ( $dislike_vote_counter == "" ) {
                $dislike_vote_counter = 0;
            }

                // Save IP and increase votes count

            if ( $vote_status == 1 ) {

                $total_vote_counter = $like_vote_counter+$dislike_vote_counter+1;

                // Like Vote Couter. 
                 update_post_meta($post_id, "bkb_voted_ip", $bkb_voted_ip);
                 update_post_meta($post_id, "bkb_like_votes_count", ++$like_vote_counter);


            } else {

                $total_vote_counter = $like_vote_counter+$dislike_vote_counter+1;

                // Dislike Vote Counter
                update_post_meta($post_id, "bkb_voted_ip", $bkb_voted_ip);
                update_post_meta($post_id, "bkb_dislike_votes_count", ++$dislike_vote_counter);

            }
            
            
            
            $data = array (
                'status'           => 1,
                'like_vote_counter' => $like_vote_counter,
                'dislike_vote_counter' => $dislike_vote_counter,
                'like_percentage' => bkb_calculate_percentage($total_vote_counter, $like_vote_counter),
                'dislike_percentage' => bkb_calculate_percentage($total_vote_counter, $dislike_vote_counter),
                'total_vote_counter' => $total_vote_counter,
                'vote_status'   => $vote_status,
                'msg'              => __(' Thanks for your vote!', 'bwl-kb')
                
            );
            
        } else  {
            
             $data = array (
                'status'            => 0,
                'msg'               => __(' You have already submitted your vote!', 'bwl-kb')
            );
             
        }
        
        echo json_encode($data);
    }
    
    die();
    
}

add_action('wp_ajax_bkb_add_rating', 'bkb_add_rating');

add_action( 'wp_ajax_nopriv_bkb_add_rating', 'bkb_add_rating' );

/*------------------------------ Add Feedback Message ---------------------------------*/

function bkb_save_post_data() { 
    
    
    $post_id = $_REQUEST['post_id'];
    
     if (empty($_REQUEST) || !wp_verify_nonce($_REQUEST['name_of_nonce_field'], 'name_of_my_action')) {
         
        $status = array(
            'bkb_feedback_status' => 0
        );
         
     } else {
    
         // We are going to create an unique ID
         
         $bkb_feedback_message_unique_id = 'bkb_feedback_list_'.$post_id; // so idea is we are going to add post id after vairable name
         
        $prev_bkb_feedback_message = ( get_post_meta($post_id, $bkb_feedback_message_unique_id, true) == "" ) ?  array() : get_post_meta($post_id, $bkb_feedback_message_unique_id, true);  
        
        $prev = $prev_bkb_feedback_message;
         
        $prev_bkb_feedback_message[] = wp_strip_all_tags( $_REQUEST['feedback_message_box'] );
        
        update_post_meta($post_id, $bkb_feedback_message_unique_id, $prev_bkb_feedback_message, $prev);
        
        //Send Email to administrator.
        
        $bkb_feedback_email_status = TRUE; // Initally We send email when user post a new faq.
        
        $bkb_options = get_option('bkb_options');
    
        if ( isset($bkb_options['bkb_feedback_email_status'] ) && $bkb_options['bkb_feedback_email_status'] == 0) { 
            
            $bkb_feedback_email_status = FALSE;
            
        }
        
        if ( $bkb_feedback_email_status == TRUE ) {
            
            $to =  get_bloginfo( 'admin_email' );
            
            if ( isset($bkb_options['bkb_feedback_admin_email'] ) && $bkb_options['bkb_feedback_admin_email'] != "") { 
            
                $to =  $bkb_options['bkb_feedback_admin_email'];

            }
            
            $email = "user@email.com";
            $subject = __('New Feedback Submited!', 'bwl-kb');
            $edit_bkb_url =  get_admin_url() . "post.php?post&#61;$post_id&#38;action&#61;edit";

            $body = "<p>". __("Hello Administrator", 'bwl-kb') . ",<br>" . __("A new Feedback has been submitted by a user.", 'bwl-kb') . "</p>";         
            $body .= "<h3>" . __("Submitted Feedback", 'bwl-kb') . "</h3><hr />";         
            $body .= "<p>" . wp_strip_all_tags( $_REQUEST['feedback_message_box'] ) . "</p>";
            $body .= "<p><strong>" . __("Review Feedback", 'bwl-kb') . ":</strong> " . $edit_bkb_url . "</p>";
            $body .= "<p>" . __("Thank You!", 'bwl-kb') . "</p>"; 
            
            $headers[]= "From: New Feedback <$email>";
            
            add_filter( 'wp_mail_content_type', 'bkb_set_html_content_type' );
            
            wp_mail ( $to, $subject, $body, $headers );
            
            remove_filter ( 'wp_mail_content_type', 'bkb_set_html_content_type' );
            
        }
        
        $status = array(
            'bkb_feedback_status' => 1
        );

    }
    
    echo json_encode($status);
    
    die();
    
}

/**
* @Description: Add A filter for sending HTML email.
* @Created At: 08-04-2013
* @Last Edited AT: 30-06-2013
* @Created By: Mahbub
**/

 function bkb_set_html_content_type() {
   return 'text/html';
}
 
add_action('wp_ajax_bkb_save_post_data', 'bkb_save_post_data');

add_action( 'wp_ajax_nopriv_bkb_save_post_data', 'bkb_save_post_data' );


?>