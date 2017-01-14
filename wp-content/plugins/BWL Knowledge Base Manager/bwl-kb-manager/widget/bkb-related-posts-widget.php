<?php

/***********************************************************
* @Description: BKB Related Posts Widget
* @Created At: 25-04-2014
* @Last Edited AT: 25-04-2014
* @Created By: Mahbub
***********************************************************/

function bkb_related_posts_widget_init() {
   
    register_widget('BKB_Related_Posts_Widget');
     
}

add_action( 'widgets_init', 'bkb_related_posts_widget_init' ); 


class BKB_Related_Posts_Widget extends WP_Widget {

    public function __construct() {     
 
            parent::__construct(
                    'bkb_related_posts_widget_init',
                    __('BKBM Related Posts' , 'bwl-kb'),
                    array(
                            'classname'     =>  'BKB_Related_Posts_Widget',
                            'description'    =>   __('Display related posts in single pages widget area' , 'bwl-kb')
                    )
            );
        
    }
    
    public function form($instance) {
 
        $defaults = array(
            'title'                   =>  __('Related Knowledge Base Posts' , 'bwl-kb'),
            'bkb_related_posts_type'    => 'category',
            'bkb_no_of_post'   =>  '5'
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
        
        <!-- Related Posts Type -->   
        
         <p>
                <label for="<?php echo $this->get_field_id('bkb_related_posts_type'); ?>"><?php _e('Related Posts Type:', 'bwl-kb') ?></label> 
                <select id="<?php echo $this->get_field_id('bkb_related_posts_type'); ?>" name="<?php echo $this->get_field_name('bkb_related_posts_type'); ?>" class="widefat" style="width:100%;">
                    
                    <?php 
                    
                        $bkb_related_posts_types =array('category'=> 'Category', 
                                                                            'tags' => 'Tags'
                                                                        );
 
                        foreach( $bkb_related_posts_types as $bkb_related_posts_type_key=> $bkb_related_posts_type_value) :
                           
                    ?>
                    
                        <option value="<?php echo $bkb_related_posts_type_key; ?>" <?php if ( $instance['bkb_related_posts_type'] == $bkb_related_posts_type_key ) echo 'selected="selected"'; ?>><?php echo $bkb_related_posts_type_value; ?></option>
                    
                    <?php

                        endforeach;
                    
                    ?>
                    
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
        
        <?php
        
    }
    
    public function update($new_instance, $old_instance) {
        
        $instance                                    = $old_instance;
        
        $instance['title']                           = strip_tags( stripslashes( $new_instance['title'] ) );
        
        $instance['bkb_related_posts_type']  =  strip_tags( stripslashes( $new_instance['bkb_related_posts_type'] ) );
        
        
        if ( ! is_numeric( $new_instance['bkb_no_of_post'] )) {
            
            $instance['bkb_no_of_post']  =  5;
            
        } else {
            
            $instance['bkb_no_of_post']  =  strip_tags( stripslashes( $new_instance['bkb_no_of_post'] ) );
            
        }
        return $instance;
        
    }
    
    public function widget($args, $instance) {
        
       if ( is_singular('bwl_kb') ) {
        
            extract($args);

            $title  = apply_filters('widget-title' , $instance['title']);

            $bkb_related_posts_type = trim($instance['bkb_related_posts_type']); // Category/Tags 

            $bkb_no_of_post = $instance['bkb_no_of_post']; // how many post we would like to show.

            $args = array(); // Initialize Args.

            echo $before_widget;

            if($title) :

                echo $before_title . $title . $after_title;

            endif;

                $id = get_the_ID();
                
                $bkb_related_post_filter_type = 'category';

                if (isset($bkb_related_posts_type) && $bkb_related_posts_type != "" && $bkb_related_posts_type == 'tags') {

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
                        'showposts' => $bkb_no_of_post,
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
                    
                if (isset($bkb_related_posts_type) && $bkb_related_posts_type != "" && $bkb_related_posts_type == 'tags') {
                    
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
                        'showposts' => $bkb_no_of_post,
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

             $loop = new WP_Query($args);

             global $post;

             $bkb_post_string = "";

                 if ( $loop->have_posts() ) :

                    $bkb_post_string .= '<ul class="bkb-widget">';

                         while ( $loop->have_posts() ) :

                                $loop->the_post();

                                    $like_vote_counter = ( get_post_meta($post->ID, "bkb_like_votes_count", true ) == "" ) ? 0 : get_post_meta($post->ID, "bkb_like_votes_count", true);  
                                    $dislike_vote_counter = ( get_post_meta($post->ID, "bkb_dislike_votes_count", true ) == "" ) ? 0 : get_post_meta($post->ID, "bkb_dislike_votes_count", true);  
                                    $view_counter = ( get_post_meta($post->ID, "bkbm_post_views", true ) == "" ) ? 0 : get_post_meta($post->ID, "bkbm_post_views", true);  

                                    $bkb_post_string.="<li><a href='" . get_permalink() . "'>" . get_the_title() . '</a><br /><i class="fa fa-eye"></i> ' . $view_counter .' &nbsp; <i class="fa fa-thumbs-up"></i> ' . $like_vote_counter .' &nbsp; <i class="fa fa-thumbs-down"></i> '. $dislike_vote_counter ."</li>";

                        endwhile;

                        $bkb_post_string .= '<ul>';

                else:

                    $bkb_post_string .="<p>" .__("No Post Found!", 'bwl-kb') . "</p>";

                endif;

                echo  $bkb_post_string ;


            echo $after_widget;
        
            wp_reset_query();
        }
    
     }
 
    
}

 
?>