<?php

	/*
	*
	*	Atelier Functions - Child Theme
	*	------------------------------------------------
	*	These functions will override the parent theme
	*	functions. We have provided some examples below.
	*
	*
	*/
	
	/* LOAD PARENT THEME STYLES
	================================================== */
	function atelier_child_enqueue_styles() {
	    wp_enqueue_style( 'atelier-parent-style', get_template_directory_uri() . '/style.css' );
	
	}
	add_action( 'wp_enqueue_scripts', 'atelier_child_enqueue_styles' );
	
	
	/* LOAD THEME LANGUAGE
	================================================== */
	/*
	*	You can uncomment the line below to include your own translations
	*	into your child theme, simply create a "language" folder and add your po/mo files
	*/
	
	// load_theme_textdomain('swiftframework', get_stylesheet_directory().'/language');
	
	
	/* REMOVE PAGE BUILDER ASSETS
	================================================== */
	/*
	*	You can uncomment the line below to remove selected assets from the page builder
	*/
	
	// function spb_remove_assets( $pb_assets ) {
	//     unset($pb_assets['parallax']);
	//     return $pb_assets;
	// }
	// add_filter( 'spb_assets_filter', 'spb_remove_assets' );	


	/* ADD/EDIT PAGE BUILDER TEMPLATES
	================================================== */
	function custom_prebuilt_templates($prebuilt_templates) {
			
		/*
		*	You can uncomment the lines below to add custom templates
		*/
		// $prebuilt_templates["custom"] = array(
		// 	'id' => "custom",
		// 	'name' => 'Custom',
		// 	'code' => 'your-code-here'
		// );

		/*
		*	You can uncomment the lines below to remove default templates
		*/
		// unset($prebuilt_templates['home-1']);
		// unset($prebuilt_templates['home-2']);

		// return templates array
	    return $prebuilt_templates;

	}
	//add_filter( 'spb_prebuilt_templates', 'custom_prebuilt_templates' );
	
//	function custom_post_thumb_image($thumb_img_url) {
//	    
//	    if ($thumb_img_url == "") {
//	    	global $post;
//	  		ob_start();
//	  		ob_end_clean();
//	  		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
//	  		if (!empty($matches) && isset($matches[1][0])) {
//	  		$thumb_img_url = $matches[1][0];
//	    	}
//	    }
//	    
//	    return $thumb_img_url;
//	}
//	add_filter( 'sf_post_thumb_image_url', 'custom_post_thumb_image' );
	
//	function dynamic_section( $sections ) {
//        //$sections = array();
//        $sections[] = array(
//            'title'  => __( 'Section via hook', 'redux-framework-demo' ),
//            'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo' ),
//            'icon'   => 'el-icon-paper-clip',
//            // Leave this as a blank section, no options just some intro text set above.
//            'fields' => array()
//        );
//        return $sections;
//    }
//	
	
//	function custom_style_sheet() {
//	    echo '<link rel="stylesheet" href="'.get_stylesheet_directory_uri() . '/test.css'.'" type="text/css" media="all" />';
//	}
//	add_action('wp_head', 'custom_style_sheet', 100);
	

	// function custom_wishlist_icon() {
	// 	return '<i class="fa-heart"></i>';
	// }
	// add_filter('sf_wishlist_icon', 'custom_wishlist_icon', 100);
	// add_filter('sf_add_to_wishlist_icon', 'custom_wishlist_icon', 100);
	// add_filter('sf_wishlist_menu_icon', 'custom_wishlist_icon', 100);

function child_widgets_init(){
    register_sidebar( array(
        'name' => __( 'Header Top Left' ),
        'id' => 'header-top-left',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );

    register_sidebar( array(
        'name' => __( 'Header Top Right' ),
        'id' => 'header-top-right',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );

    register_sidebar( array(
        'name' => __( 'Header Bottom Right' ),
        'id' => 'header-bottom-right',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
    ) );

	register_sidebar( array(
        'name' => __( 'Header Top Right' ),
        'id' => 'header-top-right',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );    
}

add_action( 'widgets_init', 'child_widgets_init' );


	/*
	*	HEADER WRAP OVERRIDE
	*	------------------------------------------------
	*	@original - /swift-framework/core/sf-header.php
	*
	================================================== */
	if (!function_exists('sf_header_wrap')) {
		function sf_header_wrap($header_layout) {
			global $post, $sf_options;

			$header_wrap_class = $logo_class = "";
			if ( function_exists( 'sf_page_classes' ) ) {
				$page_classes = sf_page_classes();
				$header_layout = $page_classes['header-layout'];
				$header_wrap_class = $page_classes['header-wrap'];
				$logo_class = $page_classes['logo'];
			}

			$page_header_type = "standard";

			if (is_page() && $post) {
				$page_header_type = sf_get_post_meta($post->ID, 'sf_page_header_type', true);
			} else if (is_singular('post') && $post) {
				$post_header_type = sf_get_post_meta($post->ID, 'sf_page_header_type', true);
				$fw_media_display = sf_get_post_meta($post->ID, 'sf_fw_media_display', true);
				$page_title_style = sf_get_post_meta($post->ID, 'sf_page_title_style', true);
				if ($page_title_style == "fancy" || $fw_media_display == "fw-media-title" || $fw_media_display == "fw-media") {
					$page_header_type = $post_header_type;
				}
			} else if (is_singular('portfolio') && $post) {
				$port_header_type = sf_get_post_meta($post->ID, 'sf_page_header_type', true);
				$fw_media_display = sf_get_post_meta($post->ID, 'sf_fw_media_display', true);
				$page_title = sf_get_post_meta($post->ID, 'sf_page_title', true);
				$page_title_style = sf_get_post_meta($post->ID, 'sf_page_title_style', true);
				if ($page_title_style == "fancy" || !$page_title) {
					$page_header_type = $port_header_type;
				}
			}

			$fullwidth_header = $sf_options['fullwidth_header'];
			$enable_mini_header = $sf_options['enable_mini_header'];
			$enable_tb = $sf_options['enable_tb'];
			$tb_left_config = $sf_options['tb_left_config'];
			$tb_right_config = $sf_options['tb_right_config'];
			$tb_left_text = __($sf_options['tb_left_text'], 'swiftframework');
			$tb_right_text = __($sf_options['tb_right_text'], 'swiftframework');
			$header_left_config = $sf_options['header_left_config'];
			$header_right_config = $sf_options['header_right_config'];

			if (($page_header_type == "naked-light" || $page_header_type == "naked-dark") && ($header_layout == "header-vert" || $header_layout == "header-vert-right")) {
				$header_layout = "header-4";
				$enable_tb = false;
			}

			$tb_left_output = $tb_right_output = "";
			if ($tb_left_config == "social") {
			$tb_left_output .= do_shortcode('[social]'). "\n";
			} else if ($tb_left_config == "account") {
			$tb_left_output .= sf_get_account(). "\n";
			} else if ($tb_left_config == "menu") {
			$tb_left_output .= sf_top_bar_menu(). "\n";
			} else {
			$tb_left_output .= '<div class="tb-text">'.do_shortcode($tb_left_text).'</div>'. "\n";
			}

			if ($tb_right_config == "social") {
			$tb_right_output .= do_shortcode('[social]'). "\n";
			} else if ($tb_right_config == "account") {
			$tb_right_output .= sf_get_account(). "\n";
			} else if ($tb_right_config == "menu") {
			$tb_right_output .= sf_top_bar_menu(). "\n";
			} else {
			$tb_right_output .= '<div class="tb-text">'.do_shortcode($tb_right_text).'</div>'. "\n";
			}
		?>
			<?php if ($enable_tb) { ?>
			<!--// TOP BAR //-->
			<div id="top-bar">
				<?php if ($fullwidth_header) { ?>
				<div class="container fw-header">
				<?php } else { ?>
				<div class="container">
				<?php } ?>
					<div class="col-sm-6 tb-left"><?php echo $tb_left_output; ?></div>
					<div class="col-sm-6 tb-right"><?php echo $tb_right_output; ?></div>
				</div>
			</div>
			<?php } ?>

			<!--// HEADER //-->
			<div class="header-wrap <?php echo esc_attr($header_wrap_class); ?> page-header-<?php echo esc_attr($page_header_type); ?>">

				<div id="header-section" class="<?php echo esc_attr($header_layout); ?> <?php echo esc_attr($logo_class); ?>">
					<?php if ($enable_mini_header) {
							echo sf_header($header_layout);
						} else {
							echo '<div class="sticky-wrapper">'.sf_header($header_layout).'</div>';
						}
					?>
				</div>

				<?php
					// Fullscreen Search
					echo sf_fullscreen_search();
				?>

				<?php
					// Fullscreen Search
					if (isset($header_left_config) && array_key_exists('supersearch', $header_left_config['enabled']) || isset($header_right_config) && array_key_exists('supersearch', $header_right_config['enabled'])) {
					echo sf_fullscreen_supersearch();
					}
				?>

				<?php
					// Overlay Menu
					if (isset($header_left_config) && array_key_exists('overlay-menu', $header_left_config['enabled']) || isset($header_right_config) && array_key_exists('overlay-menu', $header_right_config['enabled'])) {
						echo sf_overlay_menu();
					}
				?>

				<?php
					// Contact Slideout
					if (isset($header_left_config) && array_key_exists('contact', $header_left_config['enabled']) || isset($header_right_config) && array_key_exists('contact', $header_right_config['enabled'])) {
						echo sf_contact_slideout();
					}
				?>

			</div>

		<?php }
		add_action('sf_container_start', 'sf_header_wrap', 20);
	}

/* HEADER
    ================================================== */
    if ( ! function_exists( 'sf_header' ) ) {
        function sf_header( $header_layout ) {
            // VARIABLES
            global $sf_options;
            $header_output       = $main_menu = '';
            $fullwidth_header    = $sf_options['fullwidth_header'];
            $header_left_output  = sf_header_aux( 'left' ) . "\n";
            $header_right_output = sf_header_aux( 'right' ) . "\n";

            if ( $header_layout == "header-1" ) {

                $header_output .= '<header id="header" class="clearfix">' . "\n";
                $header_output .= '<div class="container">' . "\n";
                $header_output .= '<div class="row">' . "\n";
                $header_output .= '<div class="header-left col-sm-4">' . $header_left_output . '</div>' . "\n";
                $header_output .= sf_logo( 'col-sm-4 logo-center' );
                $header_output .= '<div class="header-right col-sm-4">' . $header_right_output . '</div>' . "\n";
                $header_output .= '</div> <!-- CLOSE .row -->' . "\n";
                $header_output .= '</div> <!-- CLOSE .container -->' . "\n";
                $header_output .= '</header>' . "\n";
                $header_output .= '<div id="main-nav" class="sticky-header">' . "\n";
                $header_output .= sf_main_menu( 'main-navigation', 'full' );
                $header_output .= '</div>' . "\n";

            } else if ( $header_layout == "header-2" ) {

                $header_output .= '<header id="header" class="clearfix">' . "\n";
                $header_output .= '<div class="container">' . "\n";
                $header_output .= '<div class="row">' . "\n";
                $header_output .= sf_logo( 'col-sm-4 logo-left' );
                $header_output .= '<div class="header-right col-sm-8">' . $header_right_output . '</div>' . "\n";
                $header_output .= '</div> <!-- CLOSE .row -->' . "\n";
                $header_output .= '</div> <!-- CLOSE .container -->' . "\n";
                $header_output .= '</header>' . "\n";
                $header_output .= '<div id="main-nav" class="sticky-header">' . "\n";
                $header_output .= sf_main_menu( 'main-navigation', 'full' );
                $header_output .= '</div>' . "\n";

            } else if ( $header_layout == "header-3" ) {

                if ( $fullwidth_header ) {
                    $header_output .= '<header id="header" class="sticky-header fw-header clearfix">' . "\n";
                } else {
                    $header_output .= '<header id="header" class="sticky-header clearfix">' . "\n";
                }
                $header_output .= '<div class="container">' . "\n";
                $header_output .= '<div class="row">' . "\n";
                $header_output .= sf_logo( 'col-sm-4 logo-left' );
                $header_output .= sf_main_menu( 'main-navigation', 'float-2' );
                $header_output .= '<div class="header-right col-sm-4">' . $header_right_output . '</div>' . "\n";
                $header_output .= '</div> <!-- CLOSE .row -->' . "\n";
                $header_output .= '</div> <!-- CLOSE .container -->' . "\n";
                $header_output .= '</header>' . "\n";

            } else if ( $header_layout == "header-4" ) {

                if ( $fullwidth_header ) {
                    $header_output .= '<header id="header" class="sticky-header fw-header clearfix">' . "\n";
                } else {
                    $header_output .= '<header id="header" class="sticky-header clearfix">' . "\n";
                }
                $header_output .= '<div class="container">' . "\n";
                $header_output .= '<div class="row">' . "\n";
                $header_output .= sf_logo( 'col-sm-4 logo-left' );
                if ( sf_theme_opts_name() == "sf_atelier_options" ) {
                $header_output .= '<div class="header-right">' . $header_right_output . '</div>' . "\n";
                }

                /*
                $header_output .= '<div class="container">';
                $header_output .= '<div class="row">';
                $header_output .= '<div class="col-sm-6">';
                $header_output .= get_dynamic_sidebar('header-top-left');
                $header_output .= '</div>';

                $header_output .= '<div class="col-sm-6">';
                $header_output .= get_dynamic_sidebar('header-top-right');
                $header_output .= '</div>';

                $header_output .= '</div>';
                $header_output .= '</div>';
				*/
                

                $header_output .= sf_main_menu( 'main-navigation', 'float-2' );
                $header_output .= '</div> <!-- CLOSE .row -->' . "\n";
                $header_output .= '</div> <!-- CLOSE .container -->' . "\n";
                $header_output .= '</header>' . "\n";

            } else if ( $header_layout == "header-5" ) {

                $header_output .= '<header id="header" class="clearfix">' . "\n";
                $header_output .= '<div class="container sticky-header">' . "\n";
                $header_output .= '<div class="row">' . "\n";
                $header_output .= sf_logo( 'col-sm-4 logo-left' );
                $header_output .= sf_main_menu( 'main-navigation', 'float-2' );
                $header_output .= '</div> <!-- CLOSE .row -->' . "\n";
                $header_output .= '</div> <!-- CLOSE .container -->' . "\n";
                $header_output .= '</header>' . "\n";

            } else if ( $header_layout == "header-6" ) {

                $header_output .= '<header id="header" class="clearfix">' . "\n";
                $header_output .= '<div class="container">' . "\n";
                $header_output .= '<div class="row">' . "\n";
                $header_output .= '<div class="header-left col-sm-4">' . $header_left_output . '</div>' . "\n";
                $header_output .= sf_logo( 'col-sm-4 logo-center' );
                $header_output .= '<div class="header-right col-sm-4">' . $header_right_output . '</div>' . "\n";
                $header_output .= '</div> <!-- CLOSE .row -->' . "\n";
                $header_output .= '</div> <!-- CLOSE .container -->' . "\n";
                $header_output .= '</header>' . "\n";
                $header_output .= '<div id="main-nav" class="sticky-header center-menu">' . "\n";
                $header_output .= sf_main_menu( 'main-navigation', 'full' );
                $header_output .= '</div>' . "\n";

            } else if ( $header_layout == "header-7" ) {

                if ( $fullwidth_header ) {
                    $header_output .= '<header id="header" class="sticky-header fw-header clearfix">' . "\n";
                } else {
                    $header_output .= '<header id="header" class="sticky-header clearfix">' . "\n";
                }
                $header_output .= '<div class="container">' . "\n";
                $header_output .= '<div class="row">' . "\n";
                $header_output .= sf_logo( 'col-sm-4 logo-left' );
                $header_output .= '<div class="header-right col-sm-8">' . $header_right_output . '</div>' . "\n";
                $header_output .= '</div> <!-- CLOSE .row -->' . "\n";
                $header_output .= '</div> <!-- CLOSE .container -->' . "\n";
                $header_output .= '</header>' . "\n";

            } else if ( $header_layout == "header-8" ) {

                if ( $fullwidth_header ) {
                    $header_output .= '<header id="header" class="sticky-header fw-header clearfix">' . "\n";
                } else {
                    $header_output .= '<header id="header" class="sticky-header clearfix">' . "\n";
                }
                $header_output .= '<div class="container">' . "\n";
                $header_output .= '<div class="row">' . "\n";
                $header_output .= '<div class="header-left col-sm-4">' . $header_left_output . '</div>' . "\n";
                $header_output .= sf_logo( 'col-sm-4 logo-center' );
                $header_output .= '<div class="header-right col-sm-4">' . $header_right_output . '</div>' . "\n";
                $header_output .= '</div> <!-- CLOSE .row -->' . "\n";
                $header_output .= '</div> <!-- CLOSE .container -->' . "\n";
                $header_output .= '</header>' . "\n";

            } else if ( $header_layout == "header-9" ) {

                $header_output .= '<header id="header" class="clearfix">' . "\n";
                $header_output .= '<div class="container">' . "\n";
                $header_output .= '<div class="row">' . "\n";
                $header_output .= sf_logo( 'col-sm-12 logo-center' );
                $header_output .= '</div> <!-- CLOSE .row -->' . "\n";
                $header_output .= '</div> <!-- CLOSE .container -->' . "\n";
                $header_output .= '</header>' . "\n";
                $header_output .= '<div id="main-nav" class="sticky-header center-menu">' . "\n";
                $header_output .= '<div class="container">' . "\n";
                $header_output .= sf_main_menu( 'main-navigation', 'float-2' );
                $header_output .= '</div>' . "\n";
                $header_output .= '</div>' . "\n";

            } else if ( $header_layout == "header-vert" ) {

                $header_output .= '<header id="header" class="clearfix">' . "\n";
                $header_output .= sf_logo( 'logo-center' );
                $header_output .= '</header>' . "\n";
                $header_output .= '<div id="vertical-nav" class="vertical-menu">' . "\n";
                $header_output .= sf_main_menu( 'main-navigation', 'vertical' );
                $header_output .= '</div>' . "\n";

            } else if ( $header_layout == "header-vert-right" ) {

                $header_output .= '<header id="header" class="clearfix">' . "\n";
                $header_output .= sf_logo( 'logo-center' );
                $header_output .= '</header>' . "\n";
                $header_output .= '<div id="vertical-nav" class="vertical-menu vertical-menu-right">' . "\n";
                $header_output .= sf_main_menu( 'main-navigation', 'vertical' );
                $header_output .= '</div>' . "\n";

            } else if ( $header_layout == "header-split" ) {

                if ( $fullwidth_header ) {
                    $header_output .= '<header id="header" class="sticky-header fw-header clearfix">' . "\n";
                } else {
                    $header_output .= '<header id="header" class="sticky-header clearfix">' . "\n";
                }
                $header_output .= '<div class="container">' . "\n";
                $header_output .= '<div class="row">' . "\n";
                $header_output .= '<div class="header-left col-sm-4">' . $header_left_output . '</div>' . "\n";
                $header_output .= sf_logo( 'logo-center' );
                $header_output .= sf_main_menu( 'main-navigation', 'float-2' );
                $header_output .= '<div class="header-right col-sm-4">' . $header_right_output . '</div>' . "\n";
                $header_output .= '</div> <!-- CLOSE .row -->' . "\n";
                $header_output .= '</div> <!-- CLOSE .container -->' . "\n";
                $header_output .= '</header>' . "\n";

            } else if ( $header_layout == "header-4-alt" ) {

                $header_output .= '<header id="header" class="sticky-header fw-header clearfix">' . "\n";
                $header_output .= '<div class="container">' . "\n";
                $header_output .= '<div class="row">' . "\n";
                $header_output .= '<div class="header-left">' . $header_left_output . '</div>' . "\n";
                $header_output .= sf_logo( 'col-sm-4 logo-left' );
                $header_output .= '<div class="header-right">' . $header_right_output . '</div>' . "\n";
                $header_output .= sf_main_menu( 'main-navigation', 'float-2' );
                $header_output .= '</div> <!-- CLOSE .row -->' . "\n";
                $header_output .= '</div> <!-- CLOSE .container -->' . "\n";
                $header_output .= '</header>' . "\n";

            }

            // HEADER RETURN
            return $header_output;

        }
    }

	/*
	*	HEADER MENU OVERRIDE
	*	------------------------------------------------
	*	@original - /swift-framework/core/sf-header.php
	*
	================================================== */
	if (!function_exists('sf_main_menu')) {
		function sf_main_menu($id, $layout = "") {

			// VARIABLES
			global $sf_options, $post;

			$show_cart = $show_wishlist = false;
			if ( isset($sf_options['show_cart']) ) {
			$show_cart            = $sf_options['show_cart'];
			}
			if ( isset($sf_options['show_wishlist']) ) {
			$show_wishlist            = $sf_options['show_wishlist'];
			}
			$header_search_type = $sf_options['header_search_type'];
			$vertical_header_text = __($sf_options['vertical_header_text'], 'swiftframework');
			$page_menu = $menu_output = $menu_full_output = $menu_with_search_output = $menu_float_output = $menu_vert_output = "";

			if ($post) {
			$page_menu = sf_get_post_meta($post->ID, 'sf_page_menu', true);
			}
			$main_menu_args = array(
				'echo'            => false,
				'theme_location' => 'main_navigation',
				'walker' => new sf_mega_menu_walker,
				'fallback_cb' => '',
				'menu' => $page_menu
			);


			// MENU OUTPUT
			$menu_output .= '<nav id="'.$id.'" class="std-menu clearfix">'. "\n";

			if(function_exists('wp_nav_menu')) {
				if (has_nav_menu('main_navigation')) {
					$menu_output .= wp_nav_menu( $main_menu_args );
				}
				else {
					$menu_output .= '<div class="no-menu">'.__("Please assign a menu to the Main Menu in Appearance > Menus", "swiftframework").'</div>';
				}
			}
			$menu_output .= '</nav>'. "\n";


			// FULL WIDTH MENU OUTPUT
			if ($layout == "full") {

				$menu_full_output .= '<div class="container">'. "\n";
				$menu_full_output .= '<div class="row">'. "\n";
				$menu_full_output .= '<div class="menu-left">'. "\n";
				$menu_full_output .= $menu_output . "\n";
				$menu_full_output .= '</div>'. "\n";
				$menu_full_output .= '<div class="menu-right">'. "\n";
				$menu_full_output .= sf_header_aux('right'). "\n";
				$menu_full_output .= '</div>'. "\n";
				$menu_full_output .= '</div>'. "\n";
				$menu_full_output .= '</div>'. "\n";

				$menu_output = $menu_full_output;

			} else if ($layout == "float" || $layout == "float-2") {

				$menu_float_output .= '<div class="float-menu container">'. "\n";

				$menu_float_output .= '<div class="top_of_menu">';
				$menu_float_output .= '<div class="col-sm-6">';
				$menu_float_output .= get_dynamic_sidebar('header-top-left');
				$menu_float_output .= '</div>';
				$menu_float_output .= '<div class="col-sm-4">';
				$menu_float_output .= get_dynamic_sidebar('header-top-right');
				$menu_float_output .= '</div>';
				$menu_float_output .= '</div>';

				$menu_float_output .= '<div class="top_of_menu2">';
				
				$menu_float_output .= '<div class="col-sm-8">';
				$menu_float_output .= $menu_output . "\n";
				$menu_float_output .= '</div>';

				$menu_float_output .= '<div class="col-sm-4">';
				$menu_float_output .= get_dynamic_sidebar('header-bottom-right');
				$menu_float_output .= '</div>';
				$menu_float_output .= '</div>';
				

				
				$menu_float_output .= '</div>'. "\n";

				$menu_output = $menu_float_output;

			} else if ($layout == "vertical") {

				$menu_vert_output .= $menu_output . "\n";
				$menu_vert_output .= '<div class="vertical-menu-bottom">'. "\n";
				$menu_vert_output .= sf_header_aux('right');
				$menu_vert_output .= '<div class="copyright">'.do_shortcode(stripslashes($vertical_header_text)).'</div>'. "\n";
				$menu_vert_output .= '</div>'. "\n";

				$menu_output = $menu_vert_output;
			}

			// MENU RETURN
			return $menu_output;
		}
	}

if(!function_exists('get_dynamic_sidebar')){
	function get_dynamic_sidebar($index = 1) {
		$sidebar_contents = "";
		ob_start();
		dynamic_sidebar($index);
		$sidebar_contents = ob_get_clean();
		return $sidebar_contents;
	}
}

add_filter( 'gform_field_input', 'map_input', 10, 5 );

function map_input( $input, $field, $value, $lead_id, $form_id ) {

	/*echo '<pre>'; var_dump($input);
	var_dump($field);
	var_dump($value);
	var_dump($lead_id);
	var_dump($form_id);
	echo '</pre>';*/
	//var_dump($field->type);
//return $input;
	if ($field->type == 'checkbox') {
		//$input .= $field->label;
	} else if ($field->type == 'radio') {

	}
	else if ($field->type != 'checkbox' || $field->type != 'radio') {
		$input .= '<span class="input input--jiro">
						<input class="input__field input__field--jiro" id="input_'.$form_id.'_'.$field->id.'" type="text" name="input_'.$field->id.'">
						<label class="input__label input__label--jiro" for="input_'.$form_id.'_'.$field->id.'">
							<span class="input__label-content input__label-content--jiro">'.$field->label.'</span>
						</label>
					</span>';
	}
	return $input;
}