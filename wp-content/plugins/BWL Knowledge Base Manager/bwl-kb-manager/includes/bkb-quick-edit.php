<?php

// Add to our admin_init function
add_action( 'bulk_edit_custom_box', 'bkb_quick_edit_box', 10, 2 );
add_action( 'quick_edit_custom_box', 'bkb_quick_edit_box', 10, 2 );

function bkb_quick_edit_box( $column_name, $post_type ) {

        switch ( $post_type ) {
        
                case $post_type: 
                
                        switch( $column_name ) {
                    
                                case 'bkb_featured_status':
                                
                                ?>
                                        <fieldset class="inline-edit-col-right">
                                            <div class="inline-edit-col">
                                                <div class="inline-edit-group">
                                                    <label class="inline-edit-status alignleft">
                                                        <span class="title">Featured</span>
                                                        <select name="bkb_featured_status">
                                                             <option value=""><?php _e('Select', 'bwl-kb'); ?></option>
                                                            <option value="0"><?php _e('No', 'bwl-kb'); ?></option>
                                                            <option value="1"><?php _e('Yes', 'bwl-kb'); ?></option>
                                                        </select>
                                                    </label>
                                                </div>
                                            </div>
                                        </fieldset>
                                            
                                <?php
                                            
                                    break;
                    

                                    case 'bkb_display_status':
                                
                                ?>

                                        <fieldset class="inline-edit-col-right">
                                            <div class="inline-edit-col">
                                                <div class="inline-edit-group">
                                                    <label class="inline-edit-status alignleft">
                                                        <span class="title">Voting Display Status</span>
                                                        <select name="bkb_display_status">
                                                            <option value=""><?php _e('Select', 'bwl-kb'); ?></option>
                                                            <option value="0"><?php _e('Hidden', 'bwl-kb'); ?></option>
                                                            <option value="1"><?php _e('Show', 'bwl-kb'); ?></option>
                                                            <option value="2"><?php _e('Closed', 'bwl-kb'); ?></option>
                                                        </select>
                                                    </label>
                                                </div>
                                            </div>
                                        </fieldset>


                                <?php
                                            
                                    break;

                                    case 'bkb_authors':
                                        
                                        $bkb_authors = array();
                                        
                                        $bkb_registered_users = get_users('orderby=display_name&order=ASC');

                                ?>

                                        <fieldset class="inline-edit-col-right">
                                            <div class="inline-edit-col">
                                                <div class="inline-edit-group">
                                                    <label class="inline-edit-status alignleft">
                                                        <span class="title"><?php _e("Author", "bwl-kb"); ?></span>
                                                        <select name="bkb_authors">
                                                            <option value=""><?php _e('Select', 'bwl-kb'); ?></option>
                                                            <?php 
                                                            
                                                                foreach ($bkb_registered_users as $user_info) :
                                                                    
                                                            ?>
                                                                    
                                                                    <option value="<?php echo $user_info->ID; ?>"><?php echo $user_info->display_name; ?></option>
                                                                    
                                                            <?php      
                                                            
                                                                endforeach;
                                                            
                                                            ?>
                                                        </select>
                                                    </label>
                                                </div>
                                            </div>
                                        </fieldset>

                                            
                                <?php
                                            
                                    break;
                                    
                                    case 'bkb_kbdabp_status': 

                                ?>

                                        <fieldset class="inline-edit-col-right">
                                            <div class="inline-edit-col">
                                                <div class="inline-edit-group">
                                                    <label class="inline-edit-status alignleft">
                                                        <span class="title"><?php _e( 'Hide From Blog List?', 'bwl-kb'); ?></span>
                                                        <select name="bkb_kbdabp_status" id="bkb_kbdabp_status">
                                                             <option value=""><?php _e('Select', 'bwl-kb'); ?></option>
                                                            <option value="0"><?php _e('No', 'bwl-kb'); ?></option>
                                                            <option value="1"><?php _e('Yes', 'bwl-kb'); ?></option>
                                                        </select>
                                                    </label>
                                                </div>
                                            </div>
                                        </fieldset>

                                            
                                <?php
                                            
                                    break;
                                
                                    case 'bkbm_post_views':
                                
                                    ?>

                                            <fieldset class="inline-edit-col-right">
                                                <div class="inline-edit-col">
                                                    <div class="inline-edit-group">
                                                        <label class="alignleft">
                                                                <input type="checkbox" value="0" name="bkbm_post_views">
                                                                <span class="checkbox-title">Reset View Counter</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </fieldset>

                                    <?php

                                        break; 
                                
                                   case 'bkb_like_votes_count':
                                
                                ?>

                                        <fieldset class="inline-edit-col-right">
                                            <div class="inline-edit-col">
                                                <div class="inline-edit-group">
                                                    <label class="alignleft">
                                                            <input type="checkbox" value="0" name="bkb_like_votes_count">
                                                            <span class="checkbox-title">Reset Like Vote</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </fieldset>
                                            
                                <?php
                                            
                                    break; 
                                
                                    case 'bkb_dislike_votes_count':
                                
                                ?>

                                    <fieldset class="inline-edit-col-right">
                                        <div class="inline-edit-col">
                                            <div class="inline-edit-group">
                                                <label class="alignleft">
                                                        <input type="checkbox" value="0" name="bkb_dislike_votes_count">
                                                        <span class="checkbox-title">Reset Dislike Vote</span>
                                                </label>
                                            </div>
                                        </div>
                                    </fieldset>
                                            
                                <?php
                                            
                                    break;
                                        
                                }
                        
                        break;
                        
            }
        
}


// Add to our admin_init function

add_action('save_post', 'bkb_save_quick_edit_data', 10, 2);
 
function bkb_save_quick_edit_data( $post_id, $post ) {
    
    // pointless if $_POST is empty (this happens on bulk edit)
        if ( empty( $_POST ) )
                return $post_id;
                
        // verify quick edit nonce
        if ( isset( $_POST[ '_inline_edit' ] ) && ! wp_verify_nonce( $_POST[ '_inline_edit' ], 'inlineeditnonce' ) )
                return $post_id;
                        
        // don't save for autosave
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
                return $post_id;
                
        // dont save for revisions
        if ( isset( $post->post_type ) && $post->post_type == 'revision' )
                return $post_id;
                
        switch( $post->post_type ) {
        
                case $post->post_type:
                
                        /**
                         * Because this action is run in several places, checking for the array key
                         * keeps WordPress from editing data that wasn't in the form, i.e. if you had
                         * this post meta on your "Quick Edit" but didn't have it on the "Edit Post" screen.
                         */
                    
                        $custom_fields = array( 'bkb_featured_status', 'bkb_display_status', 'bkb_like_votes_count', 'bkb_dislike_votes_count', 'bkbm_post_views', 'bkb_authors' );
                        
                        // Addon Support ::  KB Display As Blog Post - Knowledgebase Addon
                        if ( ( in_array('kb-display-as-blog-post/kb-display-as-blog-post.php', apply_filters('active_plugins', get_option('active_plugins')))  && class_exists('BKB_kbdabp') )) {

                            $custom_fields[] = 'bkb_kbdabp_status';
                            
                        }
                    
                        foreach( $custom_fields as $field ) {
                        
                                if ( array_key_exists( $field, $_POST ) ) {
                                    
                                    // We're not going to update if field value is null. Added in version 1.0.8
                                    if ( $_POST[ $field ] != "" ) {
                                        update_post_meta( $post_id, $field, $_POST[ $field ] );
                                    }
                                        
                                }
                                        
                        }
                                
                        break;
                        
        }
    
}


/*------------------------------  Buik Edit ---------------------------------*/

add_action( 'wp_ajax_manage_wp_posts_using_bulk_edit_bkbm', 'manage_wp_posts_using_bulk_edit_bkbm' );

function manage_wp_posts_using_bulk_edit_bkbm() {

        // we need the post IDs
        $post_ids = ( isset( $_POST[ 'post_ids' ] ) && !empty( $_POST[ 'post_ids' ] ) ) ? $_POST[ 'post_ids' ] : NULL;
                
        // if we have post IDs
        if ( ! empty( $post_ids ) && is_array( $post_ids ) ) {
        
                // Get the custom fields
            
                $custom_fields = array( 'bkbm_post_views', 'bkb_featured_status' ,'bkb_display_status', 'bkb_like_votes_count', 'bkb_dislike_votes_count', 'bkb_authors' );
                
                // Addon Support ::  KB Display As Blog Post - Knowledgebase Addon
                if ( ( in_array('kb-display-as-blog-post/kb-display-as-blog-post.php', apply_filters('active_plugins', get_option('active_plugins')))  && class_exists('BKB_kbdabp') )) {
                
                    $custom_fields[] = 'bkb_kbdabp_status';
                    
                }
                
                foreach( $custom_fields as $field ) {
                        
                        // if it has a value, doesn't update if empty on bulk
                        if ( isset( $_POST[ $field ] ) && trim( $_POST[ $field ] ) != "" ) {
                        
                                // update for each post ID
                                foreach( $post_ids as $post_id ) {
                                        
                                    // We're not going to update if field value is null. Added in version 1.0.8
                                    if ( $_POST[ $field ] != "" ) {
                                        update_post_meta( $post_id, $field, $_POST[ $field ] );
                                    }
                                        
                                }
                                
                        }
                        
                }
                
        }
        
}