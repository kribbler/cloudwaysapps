<?php

/**
* Plugin Name: BWL Knowledge Base Manager
* Plugin URI: http://bit.ly/bwl-knowledge-base
* Description: Knowledge Base Manager plugin comes with lots of unique and flexible features to create unlimited number of Knowledge Base question and answers for your website content. Sticky and shortcode base Ajax search options give your user best experiences to find there required asnwers. It has an awesome shortcode editor that provide you all kinds of options to insert shortcode in tinymce editor. Built-in widgets display latest/top up voted/top down voted/popular knowledge base in sidebar area.
* Author: Md Mahbub Alam Khan
* Version: 1.0.8
* Author URI: http://bit.ly/bwl-knowledge-base
* WP Requires at least: 3.6+
* Text Domain: bwl-kb
*/

Class BWL_KB_Manager{
    
    function __construct() {
        
//        delete_option('bkb_options');
        
         /*------------------------------ PLUGIN COMMON CONSTANTS ---------------------------------*/
        define( "BWL_KB_PLUGIN_TITLE", 'BWL Knowledge Base Manager');
        define( "BWL_KB_PLUGIN_DIR", plugins_url() .'/bwl-kb-manager/' );
        define( "BWL_KB_PLUGIN_VERSION", '1.0.8');
        define( "BWL_KB_PLUGIN_PRODUCTION_STATUS", 1); // Change this value in to 0 in Devloper mode :)
        $this->register_post_type();
        $this->taxonomies();     
        $this->included_files();
        $this->enqueue_plugin_scripts();
        $this->bkb_version_manager(BWL_KB_PLUGIN_VERSION);
        $this->bkb_cau();
    }
    
    function bkb_version_manager($latest_version) {
        
        $current_version = get_option('bwl_kb_plugin_version');
 
        if( $current_version == "" ) {
            
            update_option('bwl_kb_plugin_version', $latest_version);
            
        } elseif( $current_version != $latest_version ) {
            
            update_option('bwl_kb_plugin_version', $latest_version);
            
        } else {
            // Do nothing!
        }
        
        
    }
    
    function included_files() {

        include_once dirname(__FILE__) . '/includes/bkb-helpers.php'; 
        include_once dirname(__FILE__) . '/includes/bkb-ajax-search.php'; 
        include_once dirname(__FILE__) . '/includes/bkb-single-post-functions.php'; 
        include_once dirname(__FILE__) . '/shortcode/bkb-shortcodes.php';       
        include_once dirname(__FILE__) . '/shortcode/bkb-tabify-shortcode.php';
        include_once dirname(__FILE__) . '/shortcode/bkb-shortcode-kb-question-submit-form.php';
        include_once dirname(__FILE__) . '/includes/bkb-vote-counter.php';  
        include_once dirname(__FILE__) . '/includes/bkb-custom-theme.php';
       include_once dirname(__FILE__) . '/includes/custom-tax-class/bkb-custom-taxnomy.php'; 
       include_once dirname(__FILE__) . '/includes/custom-tax-class/bkb-tax-custom-column.php'; 
            
        if( is_admin() ) {
            
            $bkb_data = get_option('bkb_options');

            if( ! isset( $bkb_data['bkb_attachment_status'] ) || $bkb_data['bkb_attachment_status'] == 0 ) {
               include_once dirname(__FILE__) . '/includes/bkb-cmb/bkb-custom-meta-fields.php';
            }
            
            include_once dirname(__FILE__) . '/includes/bkb-custom-column.php';  
            include_once dirname(__FILE__) . '/includes/bkb-custom-meta-box.php';  
            include_once dirname(__FILE__) . '/includes/bkb-related-post-custom-meta-box.php';  
            include_once dirname(__FILE__) . '/includes/bkb-quick-edit.php';
            include_once dirname(__FILE__) . '/includes/bkb-admin-column-filter.php'; 
            include_once dirname(__FILE__) . '/tinymce/bkb-tiny-mce-config.php';
            include_once dirname(__FILE__) . '/option-panel/plugin-option-panel-menu.php';  
            include_once dirname(__FILE__) . '/option-panel/plugin-option-panel-settings.php';
            include_once dirname(__FILE__) . '/option-panel/bkb-addon-settings.php';
            
        }
        
    }
    
    public function bkb_cau(){
        
        $bkb_data = get_option('bkb_options');
        
        if( isset( $bkb_data['bkb_auto_update_status'] ) && $bkb_data['bkb_auto_update_status'] == 1 && is_admin()) {
        
           include_once dirname(__FILE__) . '/includes/bkb-update-notifier.php';  // INTEGRATE AUTO UPDATER [VERSION: 1.0.1]
        
        }
        
        
    }
    
    function enqueue_plugin_scripts(){
        
        $bkb_data = get_option('bkb_options');
        
        if ( ! is_admin()) {
          
            /*------------------------------ Add Custom Styles ---------------------------------*/

            if( ! isset( $bkb_data['bkb_fontawesome_status'] ) || $bkb_data['bkb_fontawesome_status'] == 1 ) {
                wp_enqueue_style( 'bkb-font-awesome-styles' , plugins_url( 'css/font-awesome.min.css' , __FILE__ ), array(), BWL_KB_PLUGIN_VERSION );
            }

            $bkbm_custom_styles_url = plugins_url('css/bkbm-custom-styles.css', __FILE__);
            $bkbm_rtl_styles_url = plugins_url('css/bkbm-rtl-styles.css', __FILE__);
            
            wp_enqueue_style( 'bkbm-custom-styles', $bkbm_custom_styles_url, array(), BWL_KB_PLUGIN_VERSION );
            
            if( isset( $bkb_data['bkb_rtrl_support'] ) && $bkb_data['bkb_rtrl_support'] == 1 ) {
            
                wp_enqueue_style( 'bkbm-rtl-styles', $bkbm_rtl_styles_url, array(), BWL_KB_PLUGIN_VERSION );
            
            }
            
            /*----------------------------- Add Custom JavaScripts ----------------------------------*/
            
            wp_register_script( 'bkb-remodal-script', plugins_url( 'js/jquery.remodal.js' , __FILE__ ) , array( 'jquery'), BWL_KB_PLUGIN_VERSION, TRUE );
            wp_register_script( 'bkb-tipsy-script', plugins_url( 'js/jquery.tipsy.js' , __FILE__ ) , array( 'jquery'), BWL_KB_PLUGIN_VERSION, TRUE );
            wp_register_script( 'bkb-custom-search-script', plugins_url( 'js/custom-search-scripts.js' , __FILE__ ) , array( 'jquery'), BWL_KB_PLUGIN_VERSION, TRUE );
            wp_register_script( 'bkb-tabify-script', plugins_url( 'js/bkb-tabify.js' , __FILE__ ) , array( 'jquery'), BWL_KB_PLUGIN_VERSION, TRUE );
            wp_register_script( 'bkb-ques-form-script', plugins_url( 'js/bkb-ques-form-script.js' , __FILE__ ) , array( 'jquery'), BWL_KB_PLUGIN_VERSION, TRUE );
            wp_register_script( 'bkb-custom-script', plugins_url( 'js/bkb-custom.js' , __FILE__ ) , array( 'jquery'), BWL_KB_PLUGIN_VERSION, TRUE );
            wp_enqueue_script( 'bkb-remodal-script' ); // Load Modal Scripts
            wp_enqueue_script( 'bkb-custom-script' );
            
        }
        
        if( is_admin() ){
            
            
            wp_enqueue_style( 'bkb-admin-font-awesome-styles' , plugins_url( 'css/font-awesome.min.css' , __FILE__ ), array(), BWL_KB_PLUGIN_VERSION );
            wp_enqueue_style( 'bkb-shortcode-editor-multiple-select-style' , plugins_url( 'tinymce/css/multiple-select.css' , __FILE__ ) );        
            wp_enqueue_style( 'bkb-shortcode-editor-style' , plugins_url( 'tinymce/css/bkb-shortcode-editor-style.css' , __FILE__ ) );        
            
            wp_register_script( 'bkb-admin-mutiple-select-script', plugins_url( 'tinymce/js/jquery.multiple.select.js' , __FILE__ ) , array( 'jquery' ,'jquery-ui-core','jquery-ui-draggable', 'jquery-ui-droppable' ), '', TRUE );
            wp_enqueue_script( 'bkb-admin-mutiple-select-script' );
            
            wp_register_script( 'bkb-admin-script', plugins_url( 'js/bkb-admin-custom.js' , __FILE__ ) , array( 'jquery'), '', TRUE );
            wp_enqueue_script( 'bkb-admin-script' );
            
            wp_register_script( 'bkb-fa-live', plugins_url( 'js/bkb-fa-live.js' , __FILE__ ) , array( 'jquery'), BWL_KB_PLUGIN_VERSION, TRUE );
            wp_enqueue_script( 'bkb-fa-live' );
        }
        
        
        
    }
   
    
    /*------------------------------ Define Custom Post Type  ---------------------------------*/
    
    public function register_post_type() {
        
        /*
         * Custom Slug Section.
         */        
        
        $bkb_options = get_option('bkb_options');
        
        $bkb_custom_slug = "bwl-knowledge-base";
        
        if( isset($bkb_options['bkb_custom_slug']) && $bkb_options['bkb_custom_slug'] != "" ) {
        
            $bkb_custom_slug = trim( $bkb_options['bkb_custom_slug'] );

        }
        
        define("BKB_CUSTOM_SLUG", $bkb_custom_slug);
        
        $labels = array(
            'name'                         => __('All Knowledge Base', 'bwl-kb'),
            'singular_name'            => __('Knowledge Base', 'bwl-kb'),
            'add_new'                    => __('Add New KB', 'bwl-kb'),
            'add_new_item'           => __('Add New KB', 'bwl-kb'),
            'edit_item'                   => __('Edit KB', 'bwl-kb'),
            'new_item'                  => __('New KB', 'bwl-kb'),
            'all_items'                    => __('All KB Items', 'bwl-kb'),
            'view_item'                  => __('View KB Items', 'bwl-kb'),
            'search_items'             => __('Search KB Items', 'bwl-kb'),
            'not_found'                  => __('No KB found', 'bwl-kb'),
            'not_found_in_trash'    => __('No KB found in Trash', 'bwl-kb'),
            'parent_item_colon'     => '',
            'menu_name'              => __('BWL KB', 'bwl-kb')
        );
        
        
        $bkb_supports = array('title', 'editor');
        
        if( isset($bkb_options['bkb_comment_status']) && $bkb_options['bkb_comment_status'] == 1 ) {
        
            $bkb_supports[] = 'comments';

        }
        
        if ( ( in_array('kb-display-as-blog-post/kb-display-as-blog-post.php', apply_filters('active_plugins', get_option('active_plugins')))  && class_exists('BKB_kbdabp_Admin') )) {
            $bkb_supports[] = 'thumbnail';
        }


        $args = array(
            'labels'                       => $labels,
            'query_var'                => 'bwl_kb',    
            'show_in_nav_menus' => true,
            'public'                       => true,        
            'show_ui'                   => true,
            'show_in_menu'         => true,
            'rewrite'                     => array(
                                                 'slug' => $bkb_custom_slug 
                                               ),
            'publicly_queryable'     => true,
            'capability_type'          => 'post',
            'has_archive'              => FALSE,
            'hierarchical'               => false,
            'show_in_admin_bar'  => true,
            'supports'                   => $bkb_supports,
            'menu_icon'                => BWL_KB_PLUGIN_DIR . 'images/bwl_kb_menu_icon.png'
        );        
      
      
        register_post_type('bwl_kb', $args); // text domian limitations :D
        
    }
    
    public function taxonomies() {
        
        /*
         * Custom Slug Section.
         */        
        
        $bkb_options = get_option('bkb_options');
        
        $bkb_custom_slug = "bwl-knowledge-base";
        
        if( isset($bkb_options['bkb_custom_slug']) && $bkb_options['bkb_custom_slug'] != "" ) {
        
            $bkb_custom_slug = trim( $bkb_options['bkb_custom_slug'] );

        }
        
        $taxonomies = array();
        
        $taxonomies['bkb_category'] = array(
            'hierarchical'      => true,
            'query_var'       => 'bkb_category',
            'rewrite'            => array(
                                        'slug' => $bkb_custom_slug. '-category'
                                        ),            
            'labels'              => array(
                                            'name' => __('KB Category', 'bwl-kb'),
                                            'singular_name' => __('Category', 'bwl-kb'),
                                            'edit_item' => __('Edit Category', 'bwl-kb'),
                                            'update_item' =>__('Update category', 'bwl-kb'),
                                            'add_new_item' => __('Add Category', 'bwl-kb'),
                                            'new_item_name' => __('Add New category', 'bwl-kb'),
                                            'all_items' => __('All categories', 'bwl-kb'),
                                            'search_items' => __('Search categories', 'bwl-kb'),
                                            'popular_items' => __('Popular categories', 'bwl-kb'),
                                            'separate_items_with_comments' => __('Separate categories with commas', 'bwl-kb'),
                                            'add_or_remove_items' => __('Add or remove category', 'bwl-kb'),
                                            'choose_from_most_used' => __('Choose from most used categories', 'bwl-kb')
                                        )
                
         );     
        
        //  INTRODUCED CATEGORY FILTERING IN ADMIN PANEL FROM VESTION 1.4.8 VERSION
        
        if(is_admin()) {
            $taxonomies['bkb_category']['query_var'] = TRUE;
        }
        
        $taxonomies['bkb_tags'] = array(
            'hierarchical'      => true,
            'query_var'       => 'bkb_tags',            
            'rewrite'            => array(
                                                'slug' => $bkb_custom_slug. '-tags'
                                            ),            
            'labels'              => array(
                                                'name'                                         => __('KB Tags', 'bwl-kb'),
                                                'singular_name'                            => __('Tags', 'bwl-kb'),
                                                'edit_item'                                    => __('Edit Tags', 'bwl-kb'),
                                                'update_item'                               => __('Update Tags', 'bwl-kb'),
                                                'add_new_item'                            => __('Add Tag', 'bwl-kb'),
                                                'new_item_name'                         => __('Add New Tag', 'bwl-kb'),
                                                'all_items'                                     => __('All Tags', 'bwl-kb'),
                                                'search_items'                              => __('Search Tags', 'bwl-kb'),
                                                'popular_items'                             => __('Popular Tags', 'bwl-kb'),
                                                'separate_items_with_comments' => __('Separate Tags with commas', 'bwl-kb'),
                                                'add_or_remove_items'                => __('Add or remove Tags', 'bwl-kb'),
                                                'choose_from_most_used'            => __('Choose from most used Tags', 'bwl-kb')
                                          )
                
        );
      
        if(is_admin()) {
            $taxonomies['bkb_tags']['query_var'] = TRUE;
        }
        
        $this->register_all_taxonomies($taxonomies);
    } 
    
    
    function register_all_taxonomies($taxonomies) {
        
        foreach ($taxonomies as $name=> $arr) {
            register_taxonomy($name, array('bwl_kb'), $arr);
        }
        
    }
    
}

/*------------------------------ Initialization ---------------------------------*/

function init_bwl_kb_manager() {
    new BWL_KB_Manager();
}

add_action('init', 'init_bwl_kb_manager');

/*------------------------------  TRANSLATION FILE ---------------------------------*/

load_plugin_textdomain('bwl-kb', FALSE, dirname(plugin_basename(__FILE__)) . '/lang/');

/*------------------------------ Custom Meta Box ---------------------------------*/
$bkb_data = get_option('bkb_options');

if ( ! ( in_array('woocommerce-product-faq-manager/woocommerce-product-faq-manager.php', apply_filters('active_plugins', get_option('active_plugins')))  && ! class_exists('BWL_Woo_Faq_Manager') )) {
    include_once dirname(__FILE__) . '/includes/bkb-cmb/custom-meta-boxes.php';
}

/*------------------------------ Integrate Widgets ---------------------------------*/
 
include_once dirname(__FILE__) . '/widget/bkb-widget.php';  

include_once dirname(__FILE__) . '/widget/bkb-category-widget.php';  

include_once dirname(__FILE__) . '/widget/bkb-tags-widget.php';

include_once dirname(__FILE__) . '/widget/bkb-related-posts-widget.php'; // Introduced in version 1.0.2