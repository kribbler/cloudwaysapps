<?php

/***********************************************************
* @Description: BKB Widget
* @Created At: 25-04-2014
* @Last Edited AT: 25-04-2014
* @Created By: Mahbub
***********************************************************/

function bkb_widget_init() {
   
    register_widget('BKB_Widget');
     
}

add_action( 'widgets_init', 'bkb_widget_init' ); 


class BKB_Widget extends WP_Widget {

    public function __construct() {     
 
            parent::__construct(
                    'bkb_widget',
                    __('BKBM Widget' , 'bwl-kb'),
                    array(
                            'classname'     =>  'BKB_Widget',
                            'description'    =>   __('Display Top Up Voted / Top Down Voted/ Top Viewed / Recent Posts in widget area' , 'bwl-kb')
                    )
            );
        
    }
    
    public function form($instance) {
 
        $defaults = array(
            'title'                   =>  __('KnowledeBase' , 'bwl-kb'),
            'bkb_categories'    => '',
            'bkb_display_type' => 'post',
            'bkb_order_type'   => 'asc',
            'bkb_no_of_post'   =>  '5',
            'bkb_display_views' => 'on',
            'bkb_display_like' => 'on',
            'bkb_display_dislike' => 'on'
        );
        
        $instance = wp_parse_args((array) $instance, $defaults);
        
        extract($instance);
        
        $bkb_categories_args = array(
                'taxonomy' => 'bkb_category',
                'hide_empty' => 0,
                'orderby' => 'ID', 
                'order' => 'ASC'
        );
            
        $bkb_categories_lists = get_categories( $bkb_categories_args );
        
        ?>
 
        
        <p>
            <label for="<?php echo $this->get_field_id('title') ?>"><?php _e('Title' , 'bwl-kb'); ?></label>
            <input type="text" 
                       class="widefat" 
                       id="<?php echo $this->get_field_id('title') ?>" 
                       name="<?php echo $this->get_field_name('title') ?>"
                       value="<?php echo esc_attr($title) ?>"/>
        </p>
        
        
        <!-- Categories  -->        
        
        <p>
            <?php 
            
                $bkb_categories = explode ( ',' , $instance['bkb_categories'] ) ; 
                
            ?>
            
            <label for="<?php echo $this->get_field_id( 'bkb_categories' ); ?>">Categories : </label>
            <select multiple="multiple" id="<?php echo $this->get_field_id( 'bkb_categories' ); ?>[]" name="<?php echo $this->get_field_name( 'bkb_categories' ); ?>[]" style="height: 100px;" class="widefat">
               
                <?php 
                
                    if( sizeof($bkb_categories_lists) > 0 ) {
                
                        foreach ($bkb_categories_lists as $category) {
                            
               ?>
                    
                    <option value="<?php echo $category->slug; ?>" <?php if ( in_array( $category->slug , $bkb_categories ) ) { echo ' selected="selected"' ; } ?>><?php echo $category->cat_name; ?></option>
                    
                <?php 
                
                        } 
                    }
                    
                ?>
            </select>
        </p>
        
        
        <!-- Post Type -->   
        
         <p>
                <label for="<?php echo $this->get_field_id('bkb_display_type'); ?>"><?php _e('Display Type:', 'bwl-kb') ?></label> 
                <select id="<?php echo $this->get_field_id('bkb_display_type'); ?>" name="<?php echo $this->get_field_name('bkb_display_type'); ?>" class="widefat" style="width:100%;">
                    
                    <?php 
                    
                        $available_bpvm_display_types =array('recent_posts'=> 'Recent Posts', 
                                                                            'top_up_voted' => 'Top Up Voted( Helpful )', 
                                                                            'top_down_voted'=> 'Top Down Voted', 
                                                                            'top_viewed'=> 'Top Viewed( Popular )',
                                                                            'featured'=> 'Featured',
                                                                        );
 
                        foreach( $available_bpvm_display_types as $bpvm_display_type_key=> $bpvm_display_type_value) :
                           
                    ?>
                    
                        <option value="<?php echo $bpvm_display_type_key; ?>" <?php if ( $instance['bkb_display_type'] == $bpvm_display_type_key ) echo 'selected="selected"'; ?>><?php echo $bpvm_display_type_value; ?></option>
                    
                    <?php

                        endforeach;
                    
                    ?>
                    
                </select>
        </p>
        
        <!-- Order Type -->   
        
         <p>
                <label for="<?php echo $this->get_field_id('bkb_order_type'); ?>"><?php _e('Order Type:', 'bwl-kb') ?></label> 
                <select id="<?php echo $this->get_field_id('bkb_order_type'); ?>" name="<?php echo $this->get_field_name('bkb_order_type'); ?>" class="widefat" style="width:100%;">
                    <option value="asc" <?php if ( $instance['bkb_order_type'] == 'asc' ) echo 'selected="selected"'; ?>><?php _e('Ascending', 'bwl-kb'); ?></option>                        
                    <option value="desc" <?php if ( $instance['bkb_order_type'] == 'desc' ) echo 'selected="selected"'; ?>><?php _e('Descending', 'bwl-kb'); ?></option>                        
                </select>
        </p>
        
        <!-- Display No of Posts  -->
        <p>
            <label for="<?php echo $this->get_field_id('bkb_no_of_post') ?>"><?php _e('No Of Posts' , 'bwl-kb'); ?></label>
            <input type="text" 
                       class="widefat" 
                       id="<?php echo $this->get_field_id('bkb_no_of_post') ?>" 
                       name="<?php echo $this->get_field_name('bkb_no_of_post') ?>"
                       value="<?php echo esc_attr($bkb_no_of_post) ?>"/>
        </p>
        
        <!-- Display View Info  -->
        <p>            
            <label for="<?php echo $this->get_field_id('bkb_display_views'); ?>"><?php _e('Display View Counter' , 'bwl-kb'); ?>: </label>
            <input id="<?php echo $this->get_field_id('bkb_display_views'); ?>" 
                       name="<?php echo $this->get_field_name('bkb_display_views'); ?>" 
                       type="checkbox" <?php checked($bkb_display_views, 'on'); ?> />
        </p>
        
        <!-- Display Like Info  -->
        <p>            
            <label for="<?php echo $this->get_field_id('bkb_display_like'); ?>"><?php _e('Display Like Counter' , 'bwl-kb'); ?>: </label>
            <input id="<?php echo $this->get_field_id('bkb_display_like'); ?>" 
                       name="<?php echo $this->get_field_name('bkb_display_like'); ?>" 
                       type="checkbox" <?php checked($bkb_display_like, 'on'); ?> />
        </p>
        
        <!-- Display Dislike Counter  -->
        <p>            
            <label for="<?php echo $this->get_field_id('bkb_display_dislike'); ?>"><?php _e('Display Dislike Counter' , 'bwl-kb'); ?>: </label>
            <input id="<?php echo $this->get_field_id('bkb_display_dislike'); ?>" 
                       name="<?php echo $this->get_field_name('bkb_display_dislike'); ?>" 
                       type="checkbox" <?php checked($bkb_display_dislike, 'on'); ?> />
        </p>
        
        
        <?php
        
    }
    
    public function update($new_instance, $old_instance) {
        
        $instance                                    = $old_instance;
        
        $instance['title']                           = strip_tags( stripslashes( $new_instance['title'] ) );
        
        $instance['bkb_display_type']  =  strip_tags( stripslashes( $new_instance['bkb_display_type'] ) );
        
        //Updates Category Lists.
        $instance['bkb_categories'] = implode(',', $new_instance['bkb_categories']);
        
        $instance['bkb_order_type']  =  strip_tags( stripslashes( $new_instance['bkb_order_type'] ) );
        
        $instance['bkb_no_of_post']  =  strip_tags( stripslashes( $new_instance['bkb_no_of_post'] ) );
        
        $instance['bkb_display_views']  =  strip_tags( stripslashes( $new_instance['bkb_display_views'] ) );
        
        $instance['bkb_display_like']  =  strip_tags( stripslashes( $new_instance['bkb_display_like'] ) );
        
        $instance['bkb_display_dislike']  =  strip_tags( stripslashes( $new_instance['bkb_display_dislike'] ) );
        
        return $instance;
        
    }
    
    public function widget($args, $instance) {
        
        extract($args);
        
        $title  = apply_filters('widget-title' , $instance['title']);
        
        $bkb_display_type = trim($instance['bkb_display_type']); // top view, top liked, top disliked, recent posts
        
        $bkb_categories = trim($instance['bkb_categories']);  // display by categories 
        
        $bkb_order_type = $instance['bkb_order_type']; // ascending or descending      
        
        $bkb_no_of_post = $instance['bkb_no_of_post']; // how many post we would like to show.
        
        $bkb_display_views = isset( $instance['bkb_display_views'] ) ?  $instance['bkb_display_views'] : "on"; // Display Views Information.
 
        $bkb_display_like = isset( $instance['bkb_display_like'] ) ?  $instance['bkb_display_like'] : "on"; // Display Like Information.
 
        $bkb_display_dislike = isset( $instance['bkb_display_dislike'] ) ?  $instance['bkb_display_dislike'] : "on"; // Display Dislike Information.
        
        $bkb_data = get_option('bkb_options');
        
        /*------------------------------ Add Custom Icon For Like Button  ---------------------------------*/
     
        if( isset($bkb_data ['bkb_like_thumb_icon']) && $bkb_data ['bkb_like_thumb_icon'] != "" ) {

           $bkb_like_thumb_icon = $bkb_data ['bkb_like_thumb_icon'];

           $bkb_like_thumb_html = '<i class="fa ' . $bkb_like_thumb_icon . '"></i> ';

       } else {

           $bkb_like_thumb_icon = "fa-thumbs-o-up";

           $bkb_like_thumb_html = '<i class="fa ' . $bkb_like_thumb_icon . '"></i> ';

       }

       /*------------------------------ Add Custom Icon For Dislike Button  ---------------------------------*/

       if( isset($bkb_data ['bkb_dislike_thumb_icon']) && $bkb_data ['bkb_dislike_thumb_icon'] != "" ) {

           $bkb_dislike_thumb_icon = $bkb_data ['bkb_dislike_thumb_icon'];

           $bkb_dislike_thumb_html = '<i class="fa ' . $bkb_dislike_thumb_icon . '"></i> ';

       } else {

           $bkb_dislike_thumb_icon = "fa-thumbs-o-down";

           $bkb_dislike_thumb_html = '<i class="fa ' . $bkb_dislike_thumb_icon . '"></i> ';

       }
        
        
        
        $args = array(); // Initialize Args.
        
        echo $before_widget;
        
        if($title) :
            
            echo $before_title . $title . $after_title;
        
        endif;
        
        
         if( $bkb_display_type == "top_up_voted") {
             
             $args['meta_key'] = 'bkb_like_votes_count';
             $args['orderby'] = 'meta_value_num';
             
         } else if( $bkb_display_type == "top_down_voted") {
             
              $args['meta_key'] = 'bkb_dislike_votes_count';
              $args['orderby'] = 'meta_value_num';
             
         } else if($bkb_display_type == "top_viewed") {
   
              $args['meta_key'] = 'bkbm_post_views';
              $args['orderby'] = 'meta_value_num';
              
         } else if($bkb_display_type == "featured") {
   
              $args['meta_key'] = 'bkb_featured_status';
              $args['meta_value'] = '1';
              $args['orderby'] = 'meta_value_num';
              
         } else {
             
             $args['meta_key'] = '';
             $args['order_by'] = 'ID';
             
         }
        
         
        if( $bkb_no_of_post ):
    
            
            $args['post_type'] = 'bwl_kb';
            $args['bkb_category'] = $bkb_categories;
            $args['post_status'] = 'publish';
            $args['order'] = $bkb_order_type;
            $args['posts_per_page'] = $bkb_no_of_post;
            $args['ignore_sticky_posts'] = 1;
        
            $loop = new WP_Query($args);
            
            global $post;
            
             $bkb_post_string = "";
            
             if ( $loop->have_posts() ) :
                
                $bkb_post_string .= '<ul class="bkb-widget">';
                
                     while ( $loop->have_posts() ) :
                
                            $loop->the_post();
                     
                                $bkb_view_counter_string = "";
                                $bkb_like_vote_string = "";
                                $bkb_dislike_vote_string = "";
                     
                                $view_counter =  ( get_post_meta($post->ID, "bkbm_post_views", true ) == "" ) ? 0 : get_post_meta($post->ID, "bkbm_post_views", true);  
                                $like_vote_counter = ( get_post_meta($post->ID, "bkb_like_votes_count", true ) == "" ) ? 0 : get_post_meta($post->ID, "bkb_like_votes_count", true);  
                                $dislike_vote_counter = ( get_post_meta($post->ID, "bkb_dislike_votes_count", true ) == "" ) ? 0 : get_post_meta($post->ID, "bkb_dislike_votes_count", true);  
                                
                                $bkb_add_break = 0;
                                $bkb_add_break_string = "";

                                
                                if( $bkb_display_views == "on" ) {
                                    $bkb_view_counter_string = '<i class="fa fa-eye"></i> ' . $view_counter .' &nbsp; ';
                                    $bkb_add_break =1;
                                }
                                
                                if( $bkb_display_like == "on" ) {
                                    $bkb_like_vote_string = $bkb_like_thumb_html . $like_vote_counter .' &nbsp; ';  
                                    $bkb_add_break =1;
                                }
                                
                                if( $bkb_display_dislike == "on" ) {
                                    $bkb_dislike_vote_string = $bkb_dislike_thumb_html  . $dislike_vote_counter .' &nbsp; ';
                                    $bkb_add_break =1;
                                }
                                
                                if( $bkb_add_break == 1 ) {
                                    $bkb_add_break_string = "<br />";
                                }
                                
                                
                                if( $bkb_display_type == 'top_up_voted' ) {
                                    
                                    $bkb_post_string.="<li><a href='" . get_permalink() . "'>" . get_the_title() . '</a>' . $bkb_add_break_string . $bkb_like_vote_string. $bkb_dislike_vote_string ."</li>";
                                    
                                } else if( $bkb_display_type == 'top_down_voted' ) {
                                    
                                    $bkb_post_string.="<li><a href='" . get_permalink() . "'>" . get_the_title() . '</a>' . $bkb_add_break_string .  $bkb_dislike_vote_string . $bkb_like_vote_string ."</li>";
                                    
                                } else if( $bkb_display_type == 'top_viewed') {
                                    
                                    $bkb_post_string.="<li><a href='" . get_permalink() . "'>" . get_the_title() . '</a>' . $bkb_add_break_string .  $bkb_view_counter_string . $bkb_like_vote_string . $bkb_dislike_vote_string ."</li>";
                                    
                                } else {
                                    
                                    $bkb_post_string.="<li><a href='" . get_permalink() . "'>" . get_the_title() . '</a>' . $bkb_add_break_string .  $bkb_view_counter_string . $bkb_like_vote_string . $bkb_dislike_vote_string ."</li>";
                                    
                                }
                
                    endwhile;

                    $bkb_post_string .= '<ul>';
             
            else:
                
                $bkb_post_string .="<p>" .__("No Post Found!", 'bwl-kb') . "</p>";
                
            endif;
            
            echo  $bkb_post_string ;
       
        endif;
    
        echo $after_widget;
        
        wp_reset_query();
        
    }
 
    
}