<?php

    /*
    *
    *	Swift Page Builder - Build Class
    *	------------------------------------------------
    *	Swift Framework
    * 	Copyright Swift Ideas 2015 - http://www.swiftideas.com
    *
    */

    if ( ! defined( 'ABSPATH' ) ) {
        die( '-1' );
    }

    class SFPageBuilderSetup extends SFPageBuilderAbstract {

        public static $version = '2.0';
        protected $swift_page_builder;

        public function __construct() {
        }

        public function init( $settings ) {
            parent::init( $settings );
            $this->swift_page_builder = SwiftPageBuilder::getInstance();
            $this->swift_page_builder->setTheme();
            $this->setUpTheme();
        }

        public function setUpPlugin() {
            register_activation_hook( __FILE__, Array( $this, 'activate' ) );
            if ( ! is_admin() ) {
                $this->addAction( 'template_redirect', 'frontCss' );
                $this->addAction( 'template_redirect', 'frontJsRegister' );
            }
        }

        public function fixPContent( $content = null ) {
            $s = array( "<p><div class=\"row-fluid\"", "</div></p>" );
            $r = array( "<div class=\"row-fluid\"", "</div>" );
            $content = str_ireplace( $s, $r, $content );

            return $content;
        }

        public function activate() {
            //add_option( 'spb_do_activation_redirect', true );
        }

        public function setUpTheme() {
        }
    }

    /* SETUP FOR ADMIN
    ================================================== */

    class SFPageBuilderSetupAdmin extends SFPageBuilderSetup {

        public function __construct() {
            parent::__construct();
        }

        public function setUpTheme() {
            parent::setUpPlugin();

            $this->swift_page_builder->addAction( 'edit_post', 'saveMetaBoxes' );
            $this->swift_page_builder->addAction( 'wp_ajax_spb_get_element_backend_html', 'elementBackendHtmlJavascript_callback' );
            $this->swift_page_builder->addAction( 'wp_ajax_spb_shortcodes_to_builder', 'spbShortcodesJS_callback' );
            $this->swift_page_builder->addAction( 'wp_ajax_spb_show_edit_form', 'showEditFormJavascript_callback' );
            $this->swift_page_builder->addAction( 'wp_ajax_spb_show_small_edit_form', 'showSmallEditFormJavascript_callback' );
            $this->swift_page_builder->addAction( 'wp_ajax_spb_save_template', 'saveTemplateJavascript_callback' );
            $this->swift_page_builder->addAction( 'wp_ajax_spb_load_template', 'loadTemplateJavascript_callback' );
            $this->swift_page_builder->addAction( 'wp_ajax_spb_save_element', 'saveElementJavascript_callback' );
            $this->swift_page_builder->addAction( 'wp_ajax_spb_load_element', 'loadElementJavascript_callback' );
            $this->swift_page_builder->addAction( 'wp_ajax_spb_delete_element', 'deleteElementJavascript_callback' );
            $this->swift_page_builder->addAction( 'wp_ajax_sf_load_template', 'loadSFTemplateJavascript_callback' );
            $this->swift_page_builder->addAction( 'wp_ajax_spb_delete_template', 'deleteTemplateJavascript_callback' );

            /* Add specific CSS class by filter */
            $this->addFilter( 'body_class', 'spb_body_class' );
            $this->addFilter( 'get_media_item_args', 'spb_js_forcesend' );

            //$this->addAction( 'admin_init', 'spb_redirect' );
            $this->addAction( 'admin_init', 'spb_edit_page', 5 );

            $this->addAction( 'admin_init', 'spb_register_css' );
            $this->addAction( 'admin_init', 'spb_register_js' );

            $this->addAction( 'admin_print_scripts-post.php', 'spb_scripts' );
            $this->addAction( 'admin_print_scripts-post-new.php', 'spb_scripts' );
        }

        public function spb_body_class( $classes ) {
            $classes[] = 'page-builder page-builder-version-' . SPB_VERSION;

            return $classes;
        }

        public function spb_js_forcesend( $args ) {
            $args['send'] = true;

            return $args;
        }

        public function spb_scripts() {
            wp_enqueue_style( 'bootstrap' );
            wp_enqueue_style( 'ui-custom-theme' );
            wp_enqueue_style( 'page-builder-css' );
            wp_enqueue_style( 'colorpicker-css' );
            wp_enqueue_style( 'uislider-css' );
            wp_enqueue_style( 'chosen-css' );
            wp_enqueue_style( 'ilightbox-css' );
            wp_enqueue_style( 'ilightbox-dark-css' );
            if ( sf_theme_supports('icon-mind-font') ) {
            wp_enqueue_style( 'ss-iconmind' );
            }
            if ( sf_theme_supports('gizmo-icon-font') ) {
            wp_enqueue_style( 'ss-gizmo' );
            }
            wp_enqueue_style( 'fontawesome' );

            wp_enqueue_script( 'jquery-ui-tabs' );
            wp_enqueue_script( 'jquery-ui-droppable' );
            wp_enqueue_script( 'jquery-ui-draggable' );
            wp_enqueue_script( 'jquery-ui-accordion' );
            wp_enqueue_script( 'jquery-ui-button' );

            wp_enqueue_script( 'bootstrap-js' );
            wp_enqueue_script( 'page-builder-js' );
            wp_enqueue_script( 'colorpicker-js' );
            wp_enqueue_script( 'uislider-js' );
            wp_enqueue_script( 'chosen-js' );
            wp_enqueue_script( 'ilightbox-js' );
            wp_enqueue_script( 'spb-maps' );
        }

        public function spb_register_js() {
            wp_register_script( 'page-builder-js', $this->assetURL( 'js/page-builder.js' ), array( 'jquery' ), SPB_VERSION, true );
            wp_register_script( 'bootstrap-js', $this->assetURL( 'js/bootstrap.min.js' ), false, SPB_VERSION, true );
            wp_register_script( 'colorpicker-js', $this->assetURL( 'js/jquery.minicolors.min.js' ), array( 'jquery' ), SPB_VERSION, true );
            wp_register_script( 'uislider-js', $this->assetURL( 'js/jquery.nouislider.min.js' ), array( 'jquery' ), SPB_VERSION, true );
            wp_register_script( 'chosen-js', $this->assetURL( 'js/chosen.jquery.min.js' ), array( 'jquery' ), SPB_VERSION, true );
            wp_register_script( 'ilightbox-js', $this->assetURL( 'js/ilightbox.min.js' ), array( 'jquery' ), SPB_VERSION, true );
            wp_register_script( 'spb-maps', '//maps.google.com/maps/api/js?sensor=false', 'jquery', null, true );
        }

        public function spb_register_css() {
            wp_register_style( 'bootstrap', $this->assetURL( 'css/bootstrap.css' ), false, SPB_VERSION, false );
            wp_register_style( 'page-builder-css', $this->assetURL( 'css/page-builder.css' ), false, null, false );
            wp_register_style( 'colorpicker-css', $this->assetURL( 'css/jquery.minicolors.css' ), false, null, false );
            wp_register_style( 'uislider-css', $this->assetURL( 'css/jquery.nouislider.min.css' ), false, null, false );
            wp_register_style( 'chosen-css', $this->assetURL( 'css/chosen.min.css' ), false, null, false );
            wp_register_style( 'ilightbox-css', $this->assetURL( 'css/ilightbox.css' ), false, null, false );
            wp_register_style( 'ilightbox-dark-css', $this->assetURL( 'css/ilightbox-dark-skin/skin.css' ), false, null, false );
            if ( sf_theme_supports('icon-mind-font') ) {
            wp_register_style( 'ss-iconmind', get_template_directory_uri() . '/css/iconmind.css', array(), null, 'all' );
            }
           	if ( sf_theme_supports('gizmo-icon-font') ) {
            wp_register_style( 'ss-gizmo', get_template_directory_uri() . '/css/ss-gizmo.css', array(), null, 'all' );
            }
            wp_register_style( 'fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), null, 'all' );
        }

        public function spb_edit_page() {
            $pt_array = $this->swift_page_builder->getPostTypes();
            foreach ( $pt_array as $pt ) {
                add_meta_box( 'swift_page_builder', __( 'Swift Page Builder', 'swift-framework-plugin' ), Array(
                        $this->swift_page_builder->getLayout(),
                        'output'
                    ), $pt, 'normal', 'high' );
            }
        }
    }

?>