<?php

/***********************************************************
* @Description: Widget For Display Knowledge Base Tags
* @Created At: 14-02-2013
* @Last Edited AT: 03-06-2014
* @Created By: Mahbub
***********************************************************/

function bkb_tags_widget_init() {
   
    register_widget('BKB_tags_widget');
     
}

add_action( 'widgets_init', 'bkb_tags_widget_init' ); 

class BKB_tags_widget extends WP_Widget {
    
    //widget init.
    public function __construct() {
         parent::__construct(
                 'bkb_tags_widget',
                 'BKBM Tags Widget',
                 array('description' => __('Display Knowledget Base Tags.' , 'bwl-kb'))
            );
    }
    
    //output the widget options in the back-end
    
    public function form($instance) {
        
        $defaults = array(
            'title' => __('Tags' , 'bwl-kb'),
            'entries_display' => 10,
            'show_post_count' => "false"
        );
        
        $instance = wp_parse_args((array) $instance, $defaults);
        
        ?>

        <!-- Title  -->        
        <p>
            <label for="<?php echo $this->get_field_id('title') ?>"><?php _e('Title' , 'bwl-kb'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" class="widefat" value="<?php echo esc_attr($instance['title']) ?>"/>
        </p>
        
        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id('show_post_count'); ?>" name="<?php echo $this->get_field_name('show_post_count'); ?>" <?php checked($instance['show_post_count'], 'on'); ?> />&nbsp; Display Post Count?
        </p>
        
        <?php
        
    }
    
    //process widget option for saving
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        
        // Widget Title
        $instance['title'] =  strip_tags($new_instance['title']);
        $instance['show_post_count'] =  $new_instance['show_post_count'];
        
        return $instance;
    }
    
    //Displays the widgets on the front end.
    public function widget($args, $instance) {
        extract($args);
        
        $title = apply_filters('widget-title' , $instance['title']);
        
        echo $before_widget;
        
        if($title) :
            echo $before_title.$title.$after_title;
        endif;
         
        $show_count = 0;
        
        $show_post_count = $instance['show_post_count'];
       
        
        if( $show_post_count == 'on' )  {
            $show_count = 1;
        } 
        
        
        ?>
         
        <ul class="bkb-widget">
        
            <?php wp_list_categories(array('title_li'=> '', 'taxonomy'=> 'bkb_tags',  'show_count' => $show_count, 'depth'=> 2)); ?>
        
        </ul>
        
        <?php
           
        echo $after_widget;
        
    }
    
}


 
?>