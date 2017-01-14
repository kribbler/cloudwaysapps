<?php

add_shortcode( 'bkb_ques_form', 'bkb_ques_front_end_form' );

function bkb_ques_front_end_form($atts) {
    
    extract(shortcode_atts(array(
        
        'inline' => 0

    ), $atts));
    
    $bkb_options = get_option('bkb_options');
    
    $captcha_status = 1;
    
    if ( isset( $bkb_options['bkb_ques_captcha_status'] ) ) { 
        
        $captcha_status = $bkb_options['bkb_ques_captcha_status'];
        
    }
 
    $login_required = TRUE; // Default we required logged in to post a new KB.
    
    if( is_user_logged_in() ) {
                
        $login_required = FALSE;

    }
    
    
    if ( isset( $bkb_options['bkb_login_status'] ) ) {
         
        if ( $bkb_options['bkb_login_status'] == 1 ) {
            
            if( is_user_logged_in() ) {
                
                $login_required = FALSE;
                
            }            
            
        } else  {
            
            $login_required = FALSE;
            
        }            
        
    }
    
    
   if ( $login_required == FALSE ) :
    
   $bwl_kb_categories_counter = get_categories('post_type=bwl_kb&taxonomy=bkb_category&orderby=name&order=ASC');
 
    if( count($bwl_kb_categories_counter) == 0) {
 
        wp_insert_term(
          'General', // the term 
          'bkb_category', // the taxonomy
          array(
            'description'=> 'First KB Category.',
            'slug' => 'general',
            'parent'=> 0
          )
        );
 
    }
    
    $bwl_kb_categories = wp_dropdown_categories( 'post_type=bwl_kb&show_option_none='.__('- Select KB Category -', 'bwl-kb') . '&tab_index=4&taxonomy=bkb_category&echo=0&hide_empty=0' );
    
    $bkb_ques_form_id = wp_rand();    
    
    if ( $captcha_status == 1 ) :
        
        $bwl_captcha_generator = '<p>
                                                <label for="captcha">' . __('Captcha:', 'bwl-kb') . '</label>
                                                    <input id="num1" class="sum" type="text" name="num1" value="' . rand(1,4) . '" readonly="readonly" /> +
                                                    <input id="num2" class="sum" type="text" name="num2" value="' . rand(5,9) . '" readonly="readonly" /> =
                                                    <input id="captcha" class="captcha" type="text" name="captcha" maxlength="2" />
                                                    <input id="captcha_status" type="hidden" name="captcha_status" value="' . $captcha_status . '" />
                                                <span id="spambot"> '. __('Verify Human or Spambot ?', 'bwl-kb') .'</span>
                                            </p>';    
        
    else:        
        
        $bwl_captcha_generator = '<input id="captcha_status" type="hidden" name="captcha_status" value="' . $captcha_status . '" />';    
        
    endif;
    
    
    $bkb_user_email_field = "";
    
    if ( isset($bkb_options['bkb_ask_user_email_status']) && $bkb_options['bkb_ask_user_email_status'] == 1 ) {
    
    $bkb_user_email_field = '<p>        
                                        <label for="email">' . __('Your Email: ', 'bwl-kb') . '</label>
                                        <input type="text" id="email" value="" name="email"/> <small>' . __('You will get a notification email when Knowledgebase answerd/updated!', 'bwl-kb') . '</small>
                                    </p>';
    
    }
    
    $bkb_ask_question_title = __('Add A Knowledge Base Question !', 'bwl-kb');
        
    if( isset( $bkb_options['bkb_ask_question_title'] ) && $bkb_options['bkb_ask_question_title'] != "" ) {

       $bkb_ask_question_title = trim( $bkb_options['bkb_ask_question_title'] );

   }
    
    $bkb_ques_form_body = '<section class="bkb-ques-form-container" id="' . $bkb_ques_form_id . '">
                    
                                        <h2>' . $bkb_ask_question_title . ' </h2>

                                        <div class="bkb-ques-form-message-box"></div>
                                            
                                        <form id="bkb_ques_form" class="bkb_ques_form" name="bkb_ques_form" method="post" action="#"> 
                                        
                                                <p>        
                                                    <label for="title">' . __('Question Title: ', 'bwl-kb') . '</label>
                                                    <input type="text" id="title" value="" name="title"/>                                      
                                               </p>
                                               
                                               <p>
                                                    <label for="cat">' . __('Category:', 'bwl-kb') . '</label>'
                                                    . $bwl_kb_categories . 
                                                '</p>

                                                ' . $bkb_user_email_field . $bwl_captcha_generator . '

                                                <p class="bkb_question_submit_container">
                                                    <input type="submit" value="' . __('Submit', 'bwl-kb') . '" tabindex="6" id="submit" name="submit" bkb_ques_form_id= "' . $bkb_ques_form_id . '" />
                                                </p>

                                                <input type="hidden" name="post_type" id="post_type" value="bwl_kb" />

                                                <input type="hidden" name="action" value="bkb_ques" />'

                                                . wp_nonce_field( 'name_of_my_action','name_of_nonce_field' ) .
            
                                           '</form>

                                        </section>';
    
    else:
        
        $bkb_ques_form_body = '<p>' . __("Log In is required for submitting new question.", 'bwl-kb') . '</p>';
        
    endif;
    
    
    if( isset($inline) && $inline==1 ) {
        
        /*------------------------------  Start Loading Question Form Scripts ---------------------------------*/
        wp_enqueue_script( 'bkb-ques-form-script' );
        /*------------------------------ End Loading Question Form Scripts  ---------------------------------*/
        
    } else if ( isset($bkb_options['bkb_display_question_submission_form']) && $bkb_options['bkb_display_question_submission_form'] == 1 ) {
                
        $bkb_ques_form_body = "";
            
    } else {
        /*------------------------------  Start Loading Question Form Scripts ---------------------------------*/
        wp_enqueue_script( 'bkb-ques-form-script' );
        /*------------------------------ End Loading Question Form Scripts  ---------------------------------*/
    }
    
    
    return $bkb_ques_form_body;

}

function bkb_ques_save_post_data() {    
    
     if (empty($_REQUEST) || !wp_verify_nonce($_REQUEST['name_of_nonce_field'], 'name_of_my_action')) {
         
        $status = array(
            'bwl_kb_add_status' => 0
        );
         
     } else {
    
        $sender_email = trim( $_REQUEST['email'] ); // Sender Email. 
         
        $post = array(
            'post_title'            =>   wp_strip_all_tags( $_REQUEST['title'] ),
            'tax_input'            => array('bkb_category' => $_REQUEST['cat']), // Usable for custom taxonomies too 
            'post_status'        => 'pending', // Choose: publish, preview, future, etc.
            'post_type'          => $_REQUEST['post_type']  // Use a custom post type if you want to
        );
      
        $post_id = wp_insert_post($post);            
        
        $status = array(
            'bwl_kb_add_status' =>1
        );
        
        // Add Post Meta For user email..
        
        if ( $sender_email != "" ) {
        
            add_post_meta( $post_id , 'bkb_ques_user_email', $sender_email );
        
        }
        
        //Send Email to administrator.
        
        $bwl_send_email_status = TRUE; // Initally We send email when user post a new KB.
        
        $bkb_options = get_option('bkb_options');
    
        if ( isset($bkb_options['bwl_advanced_email_notification_status'] ) && $bkb_options['bwl_advanced_email_notification_status'] == 0) { 
            
            $bwl_send_email_status = FALSE;
            
        }
        
        if ( $bwl_send_email_status == TRUE ) {
            
            $to =  get_bloginfo( 'admin_email' );
            
             if ( isset($bkb_options['bkb_feedback_admin_email'] ) && $bkb_options['bkb_feedback_admin_email'] != "") { 
            
                $to =  $bkb_options['bkb_feedback_admin_email'];

            }
            
            $email = "user@email.com";
            $subject = __('New Knowledge Base Question Submited!', 'bwl-kb');
            $edit_kb_url =  get_admin_url() . "post.php?post&#61;$post_id&#38;action&#61;edit";

            $body = "<p>". __("Hello Administrator", 'bwl-kb') . ",<br>" . __("A new Knowledge Base question has been submitted by a user.", 'bwl-kb') . "</p>";         
            $body .= "<h3>" . __("Submitted Question Information", 'bwl-kb') . "</h3><hr />";         
            $body .= "<p><strong>" . __("Title", 'bwl-kb') . ":</strong><br />" . strip_tags( $_REQUEST['title'] ) . "</p>";            
            $body .= "<p><strong>" . __("KB Status", 'bwl-kb') . ":</strong> " . __("Pending", 'bwl-kb') . "</p>";
            $body .= "<p><strong>" . __("Review KB", 'bwl-kb') . ":</strong> " . $edit_kb_url . "</p>";
            $body .= "<p>" . __("Thank You!", 'bwl-kb') . "</p>"; 
            
            $headers[]= "From: New KB Question <$email>";
            
            add_filter( 'wp_mail_content_type', 'bkb_ques_set_html_content_type' );
            
            wp_mail ( $to, $subject, $body, $headers );
            
            remove_filter ( 'wp_mail_content_type', 'bkb_ques_set_html_content_type' );
            
        }

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

 function bkb_ques_set_html_content_type() {
   return 'text/html';
}
 
add_action('wp_ajax_bkb_ques_save_post_data', 'bkb_ques_save_post_data');

add_action( 'wp_ajax_nopriv_bkb_ques_save_post_data', 'bkb_ques_save_post_data' );