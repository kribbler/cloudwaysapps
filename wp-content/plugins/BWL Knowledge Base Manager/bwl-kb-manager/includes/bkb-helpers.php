<?php

/*-----------------------------BKB AJAX Settings ----------------------------------*/

if ( ! function_exists('bkb_set_ajax_url') ) {
    
    function bkb_set_ajax_url() {

         $bkb_data = get_option('bkb_options');

         $bkb_tipsy_status =  1;
         $bkb_disable_feedback_status =  0;

         if ( isset($bkb_data['bkb_tipsy_status']) && $bkb_data['bkb_tipsy_status'] == 0 ) {

             $bkb_tipsy_status =  0;

         }
         
         if ( $bkb_tipsy_status == 1 ) {
             wp_enqueue_script( 'bkb-tipsy-script' ); // Load Tooltips
         }
         
         if ( isset($bkb_data['bkb_disable_feedback_status']) && $bkb_data['bkb_disable_feedback_status'] == 1 ) {
         
            $bkb_disable_feedback_status =  1;

        }

    ?>
        <script type="text/javascript">

             var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>',                
                    err_feedback_msg = '<?php _e(' Please Write Your Feedback Message', 'bwl-kb'); ?>',
                    bkb_feedback_thanks_msg = '<?php _e('Thanks for your feedback!', 'bwl-kb'); ?>',
                    bkb_unable_feedback_msg = '<?php _e('Unable to receive your feedback. Please try again !', 'bwl-kb'); ?>',
                    err_bkb_captcha = '<?php _e(' Incorrect Captcha Value!', 'bwl-kb'); ?>',
                    err_bkb_question = '<?php _e(' Write your question. Min length 3 characters !', 'bwl-kb'); ?>',
                    err_bkb_category = '<?php _e(' Select A KB Category!', 'bwl-kb'); ?>',
                    err_bkb_ques_email = '<?php _e(' Valid email address required!', 'bwl-kb'); ?>',
                    bkb_tipsy_status = '<?php echo $bkb_tipsy_status; ?>',
                    bkb_ques_add_msg = '<?php _e('Question successfully added for review!', 'bwl-kb'); ?>',
                    bkb_ques_add_fail_msg = '<?php _e('Unable to add Question. Please try again!', 'bwl-kb'); ?>',
                    bkb_wait_msg = '<?php _e('Please Wait .....', 'bwl-kb'); ?>',
                    bkb_search_no_results_msg = '<?php _e('Sorry Nothing Found!', 'bwl-kb'); ?>',
                    bkb_disable_feedback_status = '<?php echo $bkb_disable_feedback_status; ?>';

        </script>

    <?php

    }

    add_action('wp_head', 'bkb_set_ajax_url');
        
} else {
        
        echo "bkb_set_ajax_url - Function already exist!";
            
}



/*---------------------------BKB Calculate Percentage ------------------------------------*/

if (!function_exists('bkb_calculate_percentage')) {

    function bkb_calculate_percentage( $num_total = 0, $num_amount = 0 ) {

        if ($num_amount == 0) {

            return 0;
        }

        $count1 = $num_amount / $num_total;
        $count2 = $count1 * 100;
        $count = $count2;
        return $count;
    }

} else {

    echo "bkb_calculate_percentage - Function already exist!";
    
}

/*----------------------------Get Column class by no of cols-----------------------------------*/

if ( ! function_exists('bkb_get_grid_col_class') ) {
        
    function bkb_get_grid_col_class( $no_of_cols = "" ) {
        
        if ( $no_of_cols == 3 ) {
            
            return "bkbcol-1-3";
            
        } else if( $no_of_cols == 2 ) {
            
            return "bkbcol-1-2";
            
        } else if( $no_of_cols == 1 ) {
            
            return "bkbcol-1-1";
            
        } else {
            
            return "bkbcol-1-2";
            
        }
        
        
    }
        
        
} else {
        
        echo "bkb_get_grid_col_class - Function already exist!";
            
}

function bkb_get_fa_icons ( $bkb_cmb = FALSE ) {

    //FA-4.3.0
    $fa_icon_array_lists = explode(',' , 'fa-bed,fa-buysellads,fa-cart-arrow-down,fa-cart-plus,fa-connectdevelop,fa-dashcube,fa-diamond,fa-facebook-official,fa-heartbeat,fa-hotel,fa-leanpub,fa-mars,fa-mars-double,fa-mars-stroke,fa-mars-stroke-h,fa-mars-stroke-v,fa-medium,fa-mercury,fa-motorcycle,fa-neuter,fa-pinterest-p,fa-sellsy,fa-server,fa-ship,fa-shirtsinbulk,fa-simplybuilt,fa-skyatlas,fa-street-view,fa-subway,fa-train,fa-transgender,fa-transgender-alt,fa-user-plus,fa-user-secret,fa-user-times,fa-venus,fa-venus-double,fa-venus-mars,fa-viacoin,fa-whatsapp,fa-adjust,fa-anchor,fa-archive,fa-area-chart,fa-arrows,fa-arrows-h,fa-arrows-v,fa-asterisk,fa-at,fa-automobile,fa-ban,fa-bank,fa-bar-chart,fa-bar-chart-o,fa-barcode,fa-bars,fa-bed,fa-beer,fa-bell,fa-bell-o,fa-bell-slash,fa-bell-slash-o,fa-bicycle,fa-binoculars,fa-birthday-cake,fa-bolt,fa-bomb,fa-book,fa-bookmark,fa-bookmark-o,fa-briefcase,fa-bug,fa-building,fa-building-o,fa-bullhorn,fa-bullseye,fa-bus,fa-cab,fa-calculator,fa-calendar,fa-calendar-o,fa-camera,fa-camera-retro,fa-car,fa-caret-square-o-down,fa-caret-square-o-left,fa-caret-square-o-right,fa-caret-square-o-up,fa-cart-arrow-down,fa-cart-plus,fa-cc,fa-certificate,fa-check,fa-check-circle,fa-check-circle-o,fa-check-square,fa-check-square-o,fa-child,fa-circle,fa-circle-o,fa-circle-o-notch,fa-circle-thin,fa-clock-o,fa-close,fa-cloud,fa-cloud-download,fa-cloud-upload,fa-code,fa-code-fork,fa-coffee,fa-cog,fa-cogs,fa-comment,fa-comment-o,fa-comments,fa-comments-o,fa-compass,fa-copyright,fa-credit-card,fa-crop,fa-crosshairs,fa-cube,fa-cubes,fa-cutlery,fa-dashboard,fa-database,fa-desktop,fa-diamond,fa-dot-circle-o,fa-download,fa-edit,fa-ellipsis-h,fa-ellipsis-v,fa-envelope,fa-envelope-o,fa-envelope-square,fa-eraser,fa-exchange,fa-exclamation,fa-exclamation-circle,fa-exclamation-triangle,fa-external-link,fa-external-link-square,fa-eye,fa-eye-slash,fa-eyedropper,fa-fax,fa-female,fa-fighter-jet,fa-file-archive-o,fa-file-audio-o,fa-file-code-o,fa-file-excel-o,fa-file-image-o,fa-file-movie-o,fa-file-pdf-o,fa-file-photo-o,fa-file-picture-o,fa-file-powerpoint-o,fa-file-sound-o,fa-file-video-o,fa-file-word-o,fa-file-zip-o,fa-film,fa-filter,fa-fire,fa-fire-extinguisher,fa-flag,fa-flag-checkered,fa-flag-o,fa-flash,fa-flask,fa-folder,fa-folder-o,fa-folder-open,fa-folder-open-o,fa-frown-o,fa-futbol-o,fa-gamepad,fa-gavel,fa-gear,fa-gears,fa-genderless,fa-gift,fa-glass,fa-globe,fa-graduation-cap,fa-group,fa-hdd-o,fa-headphones,fa-heart,fa-heart-o,fa-heartbeat,fa-history,fa-home,fa-hotel,fa-image,fa-inbox,fa-info,fa-info-circle,fa-institution,fa-key,fa-keyboard-o,fa-language,fa-laptop,fa-leaf,fa-legal,fa-lemon-o,fa-level-down,fa-level-up,fa-life-bouy,fa-life-buoy,fa-life-ring,fa-life-saver,fa-lightbulb-o,fa-line-chart,fa-location-arrow,fa-lock,fa-magic,fa-magnet,fa-mail-forward,fa-mail-reply,fa-mail-reply-all,fa-male,fa-map-marker,fa-meh-o,fa-microphone,fa-microphone-slash,fa-minus,fa-minus-circle,fa-minus-square,fa-minus-square-o,fa-mobile,fa-mobile-phone,fa-money,fa-moon-o,fa-mortar-board,fa-motorcycle,fa-music,fa-navicon,fa-newspaper-o,fa-paint-brush,fa-paper-plane,fa-paper-plane-o,fa-paw,fa-pencil,fa-pencil-square,fa-pencil-square-o,fa-phone,fa-phone-square,fa-photo,fa-picture-o,fa-pie-chart,fa-plane,fa-plug,fa-plus,fa-plus-circle,fa-plus-square,fa-plus-square-o,fa-power-off,fa-print,fa-puzzle-piece,fa-qrcode,fa-question,fa-question-circle,fa-quote-left,fa-quote-right,fa-random,fa-recycle,fa-refresh,fa-remove,fa-reorder,fa-reply,fa-reply-all,fa-retweet,fa-road,fa-rocket,fa-rss,fa-rss-square,fa-search,fa-search-minus,fa-search-plus,fa-send,fa-send-o,fa-server,fa-share,fa-share-alt,fa-share-alt-square,fa-share-square,fa-share-square-o,fa-shield,fa-ship,fa-shopping-cart,fa-sign-in,fa-sign-out,fa-signal,fa-sitemap,fa-sliders,fa-smile-o,fa-soccer-ball-o,fa-sort,fa-sort-alpha-asc,fa-sort-alpha-desc,fa-sort-amount-asc,fa-sort-amount-desc,fa-sort-asc,fa-sort-desc,fa-sort-down,fa-sort-numeric-asc,fa-sort-numeric-desc,fa-sort-up,fa-space-shuttle,fa-spinner,fa-spoon,fa-square,fa-square-o,fa-star,fa-star-half,fa-star-half-empty,fa-star-half-full,fa-star-half-o,fa-star-o,fa-street-view,fa-suitcase,fa-sun-o,fa-support,fa-tablet,fa-tachometer,fa-tag,fa-tags,fa-tasks,fa-taxi,fa-terminal,fa-thumb-tack,fa-thumbs-down,fa-thumbs-o-down,fa-thumbs-o-up,fa-thumbs-up,fa-ticket,fa-times,fa-times-circle,fa-times-circle-o,fa-tint,fa-toggle-down,fa-toggle-left,fa-toggle-off,fa-toggle-on,fa-toggle-right,fa-toggle-up,fa-trash,fa-trash-o,fa-tree,fa-trophy,fa-truck,fa-tty,fa-umbrella,fa-university,fa-unlock,fa-unlock-alt,fa-unsorted,fa-upload,fa-user,fa-user-plus,fa-user-secret,fa-user-times,fa-users,fa-video-camera,fa-volume-down,fa-volume-off,fa-volume-up,fa-warning,fa-wheelchair,fa-wifi,fa-wrench,fa-ambulance,fa-automobile,fa-bicycle,fa-bus,fa-cab,fa-car,fa-fighter-jet,fa-motorcycle,fa-plane,fa-rocket,fa-ship,fa-space-shuttle,fa-subway,fa-taxi,fa-train,fa-truck,fa-wheelchair,fa-circle-thin,fa-genderless,fa-mars,fa-mars-double,fa-mars-stroke,fa-mars-stroke-h,fa-mars-stroke-v,fa-mercury,fa-neuter,fa-transgender,fa-transgender-alt,fa-venus,fa-venus-double,fa-venus-mars,fa-file,fa-file-archive-o,fa-file-audio-o,fa-file-code-o,fa-file-excel-o,fa-file-image-o,fa-file-movie-o,fa-file-o,fa-file-pdf-o,fa-file-photo-o,fa-file-picture-o,fa-file-powerpoint-o,fa-file-sound-o,fa-file-text,fa-file-text-o,fa-file-video-o,fa-file-word-o,fa-file-zip-o,fa-circle-o-notch,fa-cog,fa-gear,fa-refresh,fa-spinner,fa-check-square,fa-check-square-o,fa-circle,fa-circle-o,fa-dot-circle-o,fa-minus-square,fa-minus-square-o,fa-plus-square,fa-plus-square-o,fa-square,fa-square-o,fa-cc-amex,fa-cc-discover,fa-cc-mastercard,fa-cc-paypal,fa-cc-stripe,fa-cc-visa,fa-credit-card,fa-google-wallet,fa-paypal,fa-area-chart,fa-bar-chart,fa-bar-chart-o,fa-line-chart,fa-pie-chart,fa-bitcoin,fa-btc,fa-cny,fa-dollar,fa-eur,fa-euro,fa-gbp,fa-ils,fa-inr,fa-jpy,fa-krw,fa-money,fa-rmb,fa-rouble,fa-rub,fa-ruble,fa-rupee,fa-shekel,fa-sheqel,fa-try,fa-turkish-lira,fa-usd,fa-won,fa-yen,fa-align-center,fa-align-justify,fa-align-left,fa-align-right,fa-bold,fa-chain,fa-chain-broken,fa-clipboard,fa-columns,fa-copy,fa-cut,fa-dedent,fa-eraser,fa-file,fa-file-o,fa-file-text,fa-file-text-o,fa-files-o,fa-floppy-o,fa-font,fa-header,fa-indent,fa-italic,fa-link,fa-list,fa-list-alt,fa-list-ol,fa-list-ul,fa-outdent,fa-paperclip,fa-paragraph,fa-paste,fa-repeat,fa-rotate-left,fa-rotate-right,fa-save,fa-scissors,fa-strikethrough,fa-subscript,fa-superscript,fa-table,fa-text-height,fa-text-width,fa-th,fa-th-large,fa-th-list,fa-underline,fa-undo,fa-unlink,fa-angle-double-down,fa-angle-double-left,fa-angle-double-right,fa-angle-double-up,fa-angle-down,fa-angle-left,fa-angle-right,fa-angle-up,fa-arrow-circle-down,fa-arrow-circle-left,fa-arrow-circle-o-down,fa-arrow-circle-o-left,fa-arrow-circle-o-right,fa-arrow-circle-o-up,fa-arrow-circle-right,fa-arrow-circle-up,fa-arrow-down,fa-arrow-left,fa-arrow-right,fa-arrow-up,fa-arrows,fa-arrows-alt,fa-arrows-h,fa-arrows-v,fa-caret-down,fa-caret-left,fa-caret-right,fa-caret-square-o-down,fa-caret-square-o-left,fa-caret-square-o-right,fa-caret-square-o-up,fa-caret-up,fa-chevron-circle-down,fa-chevron-circle-left,fa-chevron-circle-right,fa-chevron-circle-up,fa-chevron-down,fa-chevron-left,fa-chevron-right,fa-chevron-up,fa-hand-o-down,fa-hand-o-left,fa-hand-o-right,fa-hand-o-up,fa-long-arrow-down,fa-long-arrow-left,fa-long-arrow-right,fa-long-arrow-up,fa-toggle-down,fa-toggle-left,fa-toggle-right,fa-toggle-up,fa-arrows-alt,fa-backward,fa-compress,fa-eject,fa-expand,fa-fast-backward,fa-fast-forward,fa-forward,fa-pause,fa-play,fa-play-circle,fa-play-circle-o,fa-step-backward,fa-step-forward,fa-stop,fa-youtube-play,fa-adn,fa-android,fa-angellist,fa-apple,fa-behance,fa-behance-square,fa-bitbucket,fa-bitbucket-square,fa-bitcoin,fa-btc,fa-buysellads,fa-cc-amex,fa-cc-discover,fa-cc-mastercard,fa-cc-paypal,fa-cc-stripe,fa-cc-visa,fa-codepen,fa-connectdevelop,fa-css3,fa-dashcube,fa-delicious,fa-deviantart,fa-digg,fa-dribbble,fa-dropbox,fa-drupal,fa-empire,fa-facebook,fa-facebook-f,fa-facebook-official,fa-facebook-square,fa-flickr,fa-forumbee,fa-foursquare,fa-ge,fa-git,fa-git-square,fa-github,fa-github-alt,fa-github-square,fa-gittip,fa-google,fa-google-plus,fa-google-plus-square,fa-google-wallet,fa-gratipay,fa-hacker-news,fa-html5,fa-instagram,fa-ioxhost,fa-joomla,fa-jsfiddle,fa-lastfm,fa-lastfm-square,fa-leanpub,fa-linkedin,fa-linkedin-square,fa-linux,fa-maxcdn,fa-meanpath,fa-medium,fa-openid,fa-pagelines,fa-paypal,fa-pied-piper,fa-pied-piper-alt,fa-pinterest,fa-pinterest-p,fa-pinterest-square,fa-qq,fa-ra,fa-rebel,fa-reddit,fa-reddit-square,fa-renren,fa-sellsy,fa-share-alt,fa-share-alt-square,fa-shirtsinbulk,fa-simplybuilt,fa-skyatlas,fa-skype,fa-slack,fa-slideshare,fa-soundcloud,fa-spotify,fa-stack-exchange,fa-stack-overflow,fa-steam,fa-steam-square,fa-stumbleupon,fa-stumbleupon-circle,fa-tencent-weibo,fa-trello,fa-tumblr,fa-tumblr-square,fa-twitch,fa-twitter,fa-twitter-square,fa-viacoin,fa-vimeo-square,fa-vine,fa-vk,fa-wechat,fa-weibo,fa-weixin,fa-whatsapp,fa-windows,fa-wordpress,fa-xing,fa-xing-square,fa-yahoo,fa-yelp,fa-youtube,fa-youtube-play,fa-youtube-square,fa-ambulance,fa-h-square,fa-heart,fa-heart-o,fa-heartbeat,fa-hospital-o,fa-medkit,fa-plus-square,fa-stethoscope,fa-user-md,fa-wheelchair' );
    
    $fa_icons = array();
    
    if ( $bkb_cmb == FALSE ) {
        $fa_icons[''] = __("- Select Icon -", 'bwl-kb');
    }
    
    foreach ($fa_icon_array_lists as $key => $value) {

        $fa_icons['fa '.$value] = ucfirst( str_replace("-", " ", str_replace("fa-", "",  $value) ) );

    }

    return $fa_icons;

}

function bkb_get_sticky_items() {
    
    
    $bkb_data = get_option('bkb_options');
    
    $bkb_sticky_html = "";
    
    if ( !isset($bkb_data['bkb_display_sticky_button']) || $bkb_data['bkb_display_sticky_button'] != "" ) {
        
//        wp_enqueue_script( 'bkb-remodal-script' ); // Load Modal Scripts
        
        $bkb_search_html = "";
        $bkb_search_modal_window = "";
        
        $bkb_search_html .='<li id="bkb_search_popup"  class="bkb_search_popup">
                                           <a href="#" title="'.__('Search Knowledgebase', 'bwl-kb').'"><i class="fa fa-search"></i></a> <span>'.__('Search Knowledgebase', 'bwl-kb').'</span>
                                          </li>';

        $bkb_search_modal_window .= '<div data-remodal-id="bkb_search_modal">'
                                                        .  do_shortcode("[bkb_search /]").
                                                    '</div>';
        
        
        if ( isset($bkb_data['bkb_display_question_submission_form']) && $bkb_data['bkb_display_question_submission_form'] == 1 ) {
                
            $bkb_ask_ques_html = "";
            $bkb_ask_ques_modal = "";
            
        } else {
            
            $bkb_ask_ques_html ='<li id="bkb_ask_ques_popup" class="bkb_ask_ques_popup">
                                                    <a href="#" title="'.__('Ask a new Knowledgebase Question', 'bwl-kb').'"><i class="fa fa-edit"></i></a> <span>'.__('Ask A Question?', 'bwl-kb').'</span>
                                                  </li>';

            $bkb_ask_ques_modal = '<div data-remodal-id="bkb_ask_ques_modal">'
                                                            .  do_shortcode("[bkb_ques_form /]") .
                                                        '</div>';
            
        }


        $bkb_sticky_html .='<div class="bkb-sticky-container">
                                            <ul class="bkb-sticky">
                                            ' . $bkb_search_html . '
                                            ' . $bkb_ask_ques_html . '
                                            </ul>
                                      </div>';



        $bkb_sticky_html = $bkb_sticky_html . $bkb_search_modal_window . $bkb_ask_ques_modal;
    
    }
    
    echo $bkb_sticky_html;
    
}


add_action('wp_footer', 'bkb_get_sticky_items');


/*-------------------------Clean Up Shortcode--------------------------------------*/


function bkb_clean_shortcodes($content){   
    $array = array (
        '<p>[' => '[', 
        ']</p>' => ']', 
        ']<br />' => ']'
    );
    $content = strtr($content, $array);
    return $content;
}
add_filter('the_content', 'bkb_clean_shortcodes');

/*------------------------------ Filter Category Page Title  ---------------------------------*/



function bkb_custom_cat_page_title($title) {
    
    $bkb_data = get_option('bkb_options');
 
    if ( is_tax( 'bkb_category' ) && isset( $bkb_data ['bkb_custom_cat_page_title_status']['enabled'] ) && $bkb_data ['bkb_custom_cat_page_title_status']['enabled'] == "on" ) {
        
        $bkb_cat_additional_title_text = "";
        $bkb_cat_title = ucfirst( single_cat_title( '', false ) );
        $bkb_cat_custom_title = "";
     
        if ( isset( $bkb_data ['bkb_custom_cat_page_title_status']['bkb_cat_additional_title_text'] ) && $bkb_data ['bkb_custom_cat_page_title_status']['bkb_cat_additional_title_text'] != "" ) {
            
            $bkb_cat_additional_title_text = $bkb_data ['bkb_custom_cat_page_title_status']['bkb_cat_additional_title_text'];
            
        }
        
        if ( isset( $bkb_data ['bkb_custom_cat_page_title_status']['bkb_cat_additional_title_prefix_status'] ) && 
                    $bkb_data ['bkb_custom_cat_page_title_status']['bkb_cat_additional_title_prefix_status'] == "on" ) {
            
            $bkb_cat_custom_title = $bkb_cat_additional_title_text . $bkb_cat_title ;
            
        } else {
            
            $bkb_cat_custom_title = $bkb_cat_title .  $bkb_cat_additional_title_text;
            
        }
        
        return $bkb_cat_custom_title;
    
    } else{
        
        return $title;
        
    }
    
}
 

add_filter('wp_title', 'bkb_custom_cat_page_title', 10, 1);
 

/*------------------------------ Filter Tags Page Title  ---------------------------------*/

function bkb_custom_tag_page_title( $title ) {
    
    $bkb_data = get_option('bkb_options');
 
    if ( is_tax( 'bkb_tags' ) && isset( $bkb_data ['bkb_custom_tag_page_title_status']['enabled'] ) && $bkb_data ['bkb_custom_tag_page_title_status']['enabled'] == "on" ) {
        
        $bkb_tag_additional_title_text = "";
        $bkb_tag_title = ucfirst( single_cat_title( '', false ) );
        $bkb_tag_custom_title = "";
     
        if ( isset( $bkb_data ['bkb_custom_tag_page_title_status']['bkb_tag_additional_title_text'] ) && $bkb_data ['bkb_custom_tag_page_title_status']['bkb_tag_additional_title_text'] != "" ) {
            
            $bkb_tag_additional_title_text = $bkb_data ['bkb_custom_tag_page_title_status']['bkb_tag_additional_title_text'];
            
        }
        
        if ( isset( $bkb_data ['bkb_custom_tag_page_title_status']['bkb_tag_additional_title_prefix_status'] ) && 
                    $bkb_data ['bkb_custom_tag_page_title_status']['bkb_tag_additional_title_prefix_status'] == "on" ) {
            
            $bkb_tag_custom_title = $bkb_tag_additional_title_text .  $bkb_tag_title ;
            
        } else {
            
            $bkb_tag_custom_title = $bkb_tag_title . $bkb_tag_additional_title_text;
            
        }
        
        return $bkb_tag_custom_title;
    
    } else{
        
        return $title;
        
    }
    
}
 

add_filter('wp_title', 'bkb_custom_tag_page_title', 10, 1);

/*------------------------------ CUSTOM STYLESHEET ---------------------------------*/

function bkbm_custom_style() {

    $style = '<style type="text/css">
                                    .bkb-custom-icon-font{
                                            display: inline-block; text-align: center; 
                                             font-size: 20px;
                                    }
                                    
                                    .bkb-icon-demo{
                                        display: inline-block;
                                         margin-left: 12px;
                                         font-size: 20px;
                                    }
                                </style>';
    
    $scripts = '<script type="text/javascript"> var bkb_string_featured = "'. __('Featured','bwl-kb').'", bkb_string_popular = "'.__('Popular','bwl-kb').'", bkb_string_recent = "'.__('Recent','bwl-kb').'"</script>';

    echo $style . $scripts;
    
}

add_action('admin_head', 'bkbm_custom_style');


/*------------------------------ Custom Width & Height For Taxomoy Image ---------------------------------*/


function bkb_get_custom_taxonomy_img_size( $size ) {
    
 switch ($size) {
     
    case '16':
        
        return array(
            'width' => '16px',
            'height' => '16px'
        );
        
        break;
    
    case '24':
        
        return array(
            'width' => '24px',
            'height' => '24px'
        );
        
        break;
    
    case '32':
        
        return array(
            'width' => '32px',
            'height' => '32px'
        );
        
        break;
    
    case '48':
        
        return array(
            'width' => '48px',
            'height' => '48px'
        );
        
        break;
    
    case '64':
        
        return array(
            'width' => '64px',
            'height' => '64px'
        );
        
        break;

    
    case '128':
        
        return array(
            'width' => '128px',
            'height' => '128px'
        );
        
        break;
    
    case '256':
        
        return array(
            'width' => '256px',
            'height' => '256px'
        );
        
        break;
    
    default:
        
        return array(
            'width' => '16px',
            'height' => '16px'
        );
        
        break;
}
    
    
}