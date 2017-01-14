<style type="text/css">
    
    .about-wrap{
        font-family: "verdana", sans-serif, serif;
    }

    .about-wrap ul,
    .about-wrap li,
    .about-wrap p {

        font-size: 13px;

    }
    .about-wrap h2 {

        margin: 0;
        padding: 0;

    }

    .bkbm_addon_install{
        font-size: 12px;
        display: inline-block;
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        border-radius: 2px;
        padding: 3px 5px;
        background: #d54e21;
        color: #FFFFFF;
        font-weight: bold;
    }
    
    .bkbm_addon_install a{
        text-decoration: none;
        color: #FFFFFF;
    }
    
</style>

<div class="wrap about-wrap">
        
    <h2><?php _e('Available Add-ons', 'bwl-kb')?></h2>
    
    <ul>
        <li>
            1. KB Display As Blog Post
            <span class="bkbm_addon_install">
                <?php     if ( ( in_array('kb-display-as-blog-post/kb-display-as-blog-post.php', apply_filters('active_plugins', get_option('active_plugins')))  && class_exists('BKB_kbdabp') )) { ?>
                    <?php _e('Installed', 'bwl-kb')?>
                <?php } else { ?>
                    <a href="http://codecanyon.net/item/kb-display-as-blog-post-knowledge-base-addon/11245275?ref=xenioushk" target="_blank"><?php _e('Install Now', 'bwl-kb')?></a>
                <?php } ?>
            </span>    
        </li>
        
        <li>
            2. KB Tab For WooCommerce
            <span class="bkbm_addon_install">
                <?php     if ( ( in_array('kb-tab-for-woocommerce/kb-tab-for-woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))  && class_exists('BKB_kbtfw') )) { ?>
                    <?php _e('Installed', 'bwl-kb')?>
                <?php } else { ?>
                    <a href="http://codecanyon.net/item/kb-tab-for-woocommerce-knowledge-base-addon/11342283?ref=xenioushk" target="_blank"><?php _e('Install Now', 'bwl-kb')?></a>
                <?php } ?>
            </span>    
        </li>
        
    </ul>
    
</div> 