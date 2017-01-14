<?php

 /*------------------------------  Custom Meta Box Section ---------------------------------*/

class BKB_Related_Post_Manager_Meta_Box {
    
    function __construct( $custom_fields ) {
        
        $this->custom_fields  = $custom_fields; //Set custom field data as global value.

        add_action( 'add_meta_boxes', array( &$this, 'metaboxes' ) );
        
        add_action( 'save_post', array( &$this, 'save_meta_box_data' ) ); 
        
    }
            
    
    //Custom Meta Box.
    
    function metaboxes() {
        
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
                </p> 

            <?php endif; ?>
            
            <?php if( $custom_field['type'] == 'checkbox' ) : ?>
            
                <p> 
                    <input type="checkbox" id="my_meta_box_check" name="my_meta_box_check" <?php checked($check, 'on'); ?> />  
                    <label for="my_meta_box_check">Do not check this</label>  
                </p>  
            
             <?php endif; ?>

        <?php
        
            endforeach;
            
    }        

    function save_meta_box_data( $id ) {
        
        global $post;
        
         if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){   
            
             return $post_id;  
             
         } else {
        
            $tbd_testimonials_custom_fields = $this->custom_fields;

            foreach( $tbd_testimonials_custom_fields['fields'] as $custom_field ) {

                if ( isset( $_POST[$custom_field['name']] ) ) {
                    
                    update_post_meta($id, $custom_field['name'], strip_tags( $_POST[$custom_field['name']] ));

                }

            }
         }
        
    }
     
}

// Register Custom Meta Box For BWL Pro Related Post Manager

function bkb_related_post_manager_custom_meta_init() {
    
    $custom_fields= array(
        
        'meta_box_id'           => 'cmb_bkb_related_post_manager', // Unique id of meta box.
        'meta_box_heading'  => 'BKB Related Post Manager Settings', // That text will be show in meta box head section.
        'post_type'               => 'bwl_kb', // define post type. go to register_post_type method to view post_type name.        
        'context'                   => 'normal',
        'priority'                    => 'high',
        'fields'                       => array(
                                                    'bkb_related_post_display_status'  => array(
                                                                                'title'      => __( 'Related Post Display Status: ', 'bwl-kb'),
                                                                                'id'         => 'bkb_related_post_display_status',
                                                                                'name'    => 'bkb_related_post_display_status',
                                                                                'type'      => 'select',
                                                                                'value'     => array(
                                                                                                        '0' => __('Hide', 'bwl-kb'),
                                                                                                        '1' => __('Show', 'bwl-kb')
                                                                                                    ),
                                                                                'default_value' => 1,
                                                                                'class'      => 'widefat'
                                                                            ),
            
                                                        'bkb_related_post_filter_type'  => array(
                                                           'title'      => __( 'Related Post Filter Type: ', 'bwl-kb'),
                                                           'id'         => 'bkb_related_post_filter_type',
                                                           'name'    => 'bkb_related_post_filter_type',
                                                           'type'      => 'select',
                                                           'value'     => array(
                                                                                   '0' => __('Category', 'bwl-kb'),
                                                                                   '1' => __('Tag', 'bwl-kb')
                                                                               ),
                                                           'default_value' => 0,
                                                           'class'      => 'widefat'
                                                       )
            
                                                )
    );
    
    
    new BKB_Related_Post_Manager_Meta_Box( $custom_fields );     
    
}


// META BOX START EXECUTION FROM HERE.

add_action('admin_init', 'bkb_related_post_manager_custom_meta_init');