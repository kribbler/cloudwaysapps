<?php

 /*------------------------------  Custom Meta Box Section ---------------------------------*/

class BKB_Meta_Box {
    
    function __construct( $custom_fields ) {

        $this->custom_fields  = $custom_fields; //Set custom field data as global value.

        add_action( 'add_meta_boxes', array( &$this, 'bkb_metaboxes' ) );
        
        add_action( 'save_post', array( &$this, 'save_bkb_meta_box_data' ) ); 
        
    }
            
    
    //Custom Meta Box.
    
    function bkb_metaboxes() {
        
        $bwl_cmb_custom_fields = $this->custom_fields;

        // First parameter is meta box ID.
        // Second parameter is meta box title.
        // Third parameter is callback function.
        // Last paramenter must be same as post_type_name
        
        add_meta_box(
            $bwl_cmb_custom_fields['meta_box_id'],
            $bwl_cmb_custom_fields['meta_box_heading'],
            array( &$this, 'show_meta_box' ),
            $bwl_cmb_custom_fields['post_type'],            
            $bwl_cmb_custom_fields['context'], 
            $bwl_cmb_custom_fields['priority']
        );

    }

    function show_meta_box( $post ) {
        
        $bwl_cmb_custom_fields = $this->custom_fields;
        
        foreach( $bwl_cmb_custom_fields['fields'] as $custom_field ) :

            $field_value = get_post_meta($post->ID, $custom_field['id'], true);
       
        ?>

            <?php if( $custom_field['type'] == 'text' ) : ?>

            <p>
                <label for="<?php echo $custom_field['id']?>"><?php echo $custom_field['title']?> </label>
                <input type="<?php echo $custom_field['type']?>" id="<?php echo $custom_field['id']?>" name="<?php echo $custom_field['name']?>" class="<?php echo $custom_field['class']?>" value="<?php echo esc_attr($field_value); ?>"/>
            </p>
            
            <?php endif; ?>
            
            <?php if( $custom_field['type'] == 'select' ) : ?>
            
                <?php 
                
                    $values = get_post_custom( $post->ID );
                    
                    $selected = isset( $values[$custom_field['name']] ) ? esc_attr( $values[$custom_field['name']][0] ) : $custom_field['default_value'];
 
                ?>
            
                <p> 
                    <label for="<?php echo $custom_field['id']?>"><?php echo $custom_field['title']?> </label> 
                    <select name="<?php echo $custom_field['name']?>" id="<?php echo $custom_field['id']?>"> 
                        
                        <option value="" selected="selected">- Select -</option>
                        
                        <?php foreach( $custom_field['value'] as $key => $value ) : ?>
                            <option value="<?php echo $key ?>" <?php selected( $selected, $key ); ?> ><?php echo $value; ?></option> 
                        <?php endforeach; ?>
                        
                    </select>
                    
                    <?php if( isset( $custom_field['desc'] ) && $custom_field['desc'] != "" ) { ?>
                        <i><?php echo $custom_field['desc']; ?></i>
                    <?php } ?>
                </p> 

            <?php endif; ?>
            
            <?php if( $custom_field['type'] == 'checkbox' ) : ?>
            
                <p> 
                    <input type="checkbox" id="my_meta_box_check" name="my_meta_box_check" <?php checked($check, 'on'); ?> />  
                    <label for="my_meta_box_check">Do not check this</label>  
                </p>  
            
             <?php endif; ?>
                
                
             <?php if( $custom_field['type'] == 'bkb_custom' ) : ?>
            
                <p> 
                   <label for="<?php echo $custom_field['title']?>"><?php echo $custom_field['title']?> </label> 
                   
                   <?php 
                   
                    global $post;
                   
                    $bkb_feedback_message_unique_id = 'bkb_feedback_list_'.$post->ID; // so idea is we are going to add post id after vairable name
         
                    $prev_bkb_feedback_message = get_post_meta( $post->ID, $bkb_feedback_message_unique_id );


                    if( isset($prev_bkb_feedback_message[0]) ) {

                       $prev_bkb_feedback_message_counter = sizeof($prev_bkb_feedback_message[0]);

                    } else {

                       $prev_bkb_feedback_message_counter = 0; 

                    }
                   
                   ?>
                   
                   <?php if( $prev_bkb_feedback_message_counter != 0 ) : ?>
                   
                   <ol>
                       <?php foreach ( $prev_bkb_feedback_message[0] as $feedback_message ) :?>
                       
                       <li><?php echo $feedback_message; ?></li>                        
                       
                       <?php endforeach;?>
                   </ol>
                
                    <?php else: ?>
                        <p>No Feedback Message Found!</p>
                    <?php endif; ?>
                </p>  
            
             <?php endif; ?>   

        <?php
        
            endforeach;
            
    }        

    function save_bkb_meta_box_data( $id ) {
        
        global $post;
        
         if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){   
            
             return $post_id;  
             
         } else {
        
            $tbd_testimonials_custom_fields = $this->custom_fields;

            foreach( $tbd_testimonials_custom_fields['fields'] as $custom_field ) {

                if ( isset( $_POST[$custom_field['name']] ) ) {
                    
                    if ( $custom_field['name'] != "bkb_user_email_send_status" ) {
                        update_post_meta($id, $custom_field['name'], strip_tags( $_POST[$custom_field['name']] ));
                    }

                }

            }
         }
        
    }
     
}

// Register Custom Meta Box For BWL Pro Related Post Manager

function bkb_custom_meta_init() {
    
    $bkb_custom_post_types = array('bwl_kb');
    
    $bkb_authors = array();
    $bkb_registered_users = get_users('orderby=display_name&order=ASC');
    
    foreach ($bkb_registered_users as $user_info) :
        $bkb_authors[$user_info->ID]  = $user_info->display_name;
    endforeach;
 
    foreach ($bkb_custom_post_types as $bkb_custom_post_types_key => $bkb_custom_post_types_value ) {
        
        
        $bkb_kb_post_icon_fields= array(

            'meta_box_id'           => 'cmb_bkb_icon_settings', // Unique id of meta box.
            'meta_box_heading'  => 'BKB Post Icon Settings', // That text will be show in meta box head section.
            'post_type'               => $bkb_custom_post_types_value, // define post type. go to register_post_type method to view post_type name.        
            'context'                   => 'normal',
            'priority'                    => 'high',
            'fields'                       => array(
                
                                                        'bkb_user_email_send_status'  => array(
                                                                                    'title'      => __( 'Select Icon: ', 'bwl-kb'),
                                                                                    'id'         => 'bkb_kb_post_icon',
                                                                                    'name'    => 'bkb_fa_id',
                                                                                    'type'      => 'select',
                                                                                    'value'     => bkb_get_fa_icons(TRUE),
                                                                                    'default_value' => 'fa fa-file-o',
                                                                                    'class'      => 'widefat'
                                                                                )
                                                    )
        );


        new BKB_Meta_Box( $bkb_kb_post_icon_fields );
        

        $custom_fields= array(

            'meta_box_id'           => 'cmb_bkb', // Unique id of meta box.
            'meta_box_heading'  => 'BKB Voting Manager Settings', // That text will be show in meta box head section.
            'post_type'               => $bkb_custom_post_types_value, // define post type. go to register_post_type method to view post_type name.        
            'context'                   => 'normal',
            'priority'                    => 'high',
            'fields'                       => array( 
                
                                                         'bkb_authors'  => array(
                                                                                'title'      => __( 'Author: ', 'bwl-kb'),
                                                                                'id'         => 'bkb_authors',
                                                                                'name'    => 'bkb_authors',
                                                                                'type'      => 'select',
                                                                                'value'     => $bkb_authors,
                                                                                'default_value' => 1,
                                                                                'class'      => 'widefat'
                                                                            ),
                                                        'bkb_featured_status'  => array(
                                                                                    'title'      => __( 'Featured Status: ', 'bwl-kb'),
                                                                                    'id'         => 'bkb_featured_status',
                                                                                    'name'    => 'bkb_featured_status',
                                                                                    'type'      => 'select',
                                                                                    'value'     => array(
                                                                                                            '0' => __('No', 'bwl-kb'),
                                                                                                            '1' => __('Yes', 'bwl-kb')
                                                                                                        ),
                                                                                    'default_value' => 0,
                                                                                    'class'      => 'widefat'
                                                            ),
                                                            'bkb_display_status'  => array(
                                                                'title'      => __( 'Display Voting Box: ', 'bwl-kb'),
                                                                'id'         => 'bkb_display_status',
                                                                'name'    => 'bkb_display_status',
                                                                'type'      => 'select',
                                                                'value'     => array(
                                                                                        '0' => __('Hide', 'bwl-kb'),
                                                                                        '1' => __('Show', 'bwl-kb'),
                                                                                        '2' => __('Voting Closed', 'bwl-kb'),
                                                                                    ),
                                                                'default_value' => 1,
                                                                'class'      => 'widefat'
                                                            ),
                                                            'bkb_display_feedbacks'  => array(
                                                               'title'      => __( 'Voting Feedbacks', 'bwl-kb'),
                                                               'id'         => 'bkb_display_feedbacks',
                                                               'name'    => 'bkb_display_feedbacks',
                                                               'type'      => 'bkb_custom'
                                                           )

                                                    )
        );


        new BKB_Meta_Box( $custom_fields );
         
        $bkb_ques_user_email = "";
        
        if( isset( $_GET['post'] ) && get_post_type( $_GET['post']) == "bwl_kb" ) {
        
            $bkb_ques_user_email = get_post_meta( $_GET['post'], 'bkb_ques_user_email', TRUE );
        
        }
       
        $bkb_email_settings_custom_fields= array(

            'meta_box_id'           => 'cmb_bkb_email_settings', // Unique id of meta box.
            'meta_box_heading'  => 'BKB Email Notification Settings', // That text will be show in meta box head section.
            'post_type'               => $bkb_custom_post_types_value, // define post type. go to register_post_type method to view post_type name.        
            'context'                   => 'normal',
            'priority'                    => 'high',
            'fields'                       => array(
                
                                                        'bkb_ques_user_email'  => array(
                                                                                    'title'      => __( 'Question Submitted By: ', 'bwl-kb'),
                                                                                    'id'         => 'bkb_ques_user_email',
                                                                                    'name'    => 'bkb_ques_user_email',
                                                                                    'type'      => 'text',
                                                                                    'value'     => $bkb_ques_user_email,
                                                                                    'default_value' => $bkb_ques_user_email,
                                                                                    'class'      => 'large'
                                                                                ), 
                                                        'bkb_user_email_send_status'  => array(
                                                                                    'title'      => __( 'Send Notification Email: ', 'bwl-kb'),
                                                                                    'id'         => 'bkb_user_email_send_status',
                                                                                    'name'    => 'bkb_user_email_send_status',
                                                                                    'type'      => 'select',
                                                                                    'value'     => array(
                                                                                                            '1' => __('Yes', 'bwl-kb'),
                                                                                                            '0' => __('No', 'bwl-kb')
                                                                                                        ),
                                                                                    'default_value' => 0,
                                                                                    'class'      => 'widefat',
                                                                                    'desc'  => __('This field value will not saved in database.', 'bwl-kb')
                                                                                )
                                                    )
        );


        new BKB_Meta_Box( $bkb_email_settings_custom_fields );
    
            
    }
    
}


// META BOX START EXECUTION FROM HERE.

add_action('admin_init', 'bkb_custom_meta_init');


/*------------------------------ After Save Post We are going to send email to user ---------------------------------*/

function bkb_post_updated_send_email( $post_id ) {

            // If this is just a revision, don't send the email.
    
            if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave($post_id) || get_post_type( $post_id ) != 'bwl_kb' )
		
                return;
 
        
            if ( get_post_status( $post_id ) == 'publish' && get_post_type( $post_id ) == 'bwl_kb' && 
                 isset( $_POST['bkb_user_email_send_status'] ) && $_POST['bkb_user_email_send_status'] == 1 && 
                 isset( $_POST['bkb_ques_user_email'] ) && $_POST['bkb_ques_user_email'] != get_bloginfo( 'admin_email' ) ) {
        
                
              $bkb_ques_user_email = $_POST['bkb_ques_user_email']; 
	$post_title = get_the_title( $post_id );
	$post_url = get_permalink( $post_id );
	$subject = __('Knowledgebase Question has been updated!', 'bwl-kb');
              $sender_email =  get_bloginfo( 'admin_email' ); // Email send from blog admin.
              
              
	$message = "<p>Hello, <br />Your submitted Knowledgebase question has been updated on our website. More details - <br />";
	$message .= '<a href="'.$post_url.'">'. $post_title . '</a></p>' ;
	$message .= "<p>Thanks.</p>";
                
              $headers[]= "From: Knowledgebase Question <$sender_email>";
              
              add_filter( 'wp_mail_content_type', 'bkb_ques_set_html_content_type' );
              
	// Send email to admin.
	wp_mail( $bkb_ques_user_email, $subject, $message, $headers );
        
              remove_filter ( 'wp_mail_content_type', 'bkb_ques_set_html_content_type' );
        
            }
            
}

add_action( 'save_post', 'bkb_post_updated_send_email' );