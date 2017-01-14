<?php

require('../../../../wp-load.php');
 
?>

<style type="text/css">
    hr.bkb-shortcode-seperator{
        border: 0px;
        border-top: 1px solid #D0D0D0;
        height: 1px;
    }
    
    .bkb_dn{
        display: none;
    }

    input[type="checkbox"].bkb_checkbox{
        
        margin-top: 5px;
        
    }
    
    .bkb_custom_dn{
        display: none;
    }
    
</style>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        
        var $bkb_parent_container = $("#bkb_editor_popup_content");
        
         
        /*------------------------------Check Box ---------------------------------*/
        var bkb_display_tab_status = $bkb_parent_container.find('#bkb_display_tab_status'),
             bkb_display_category_status = $bkb_parent_container.find('#bkb_display_category_status'),
             bkb_tab_row = $bkb_parent_container.find('.bkb_tab_row'),
             bkb_cat_row = $bkb_parent_container.find('.bkb_cat_row'),
             bkb_tags_row = $bkb_parent_container.find('.bkb_tags_row'),
             bkb_display_tag_status = $bkb_parent_container.find('#bkb_display_tag_status');
//             bkb_string_featured = "<?php _e('Featured','bwl-kb');?>",
//             bkb_string_popular = "<?php _e('Popular','bwl-kb');?>",
//             bkb_string_recent = "<?php _e('Recent','bwl-kb');?>";
             
             bkb_display_tab_status.click(function(){
                 
                  if ( jQuery(this).is(':checked') ) {
                    
                    bkb_tab_row.slideDown(function(){
                        jQuery(this).removeClass("bkb_dn");
                        bkb_sc_scroll_manager();
                    });
                 
                 } else {
                     
                    bkb_tab_row.slideUp(function(){
                        jQuery(this).addClass("bkb_dn");
                        bkb_sc_scroll_manager();
                    });
                    
                 }
                 
             });
             
             bkb_display_category_status.click(function(){
                 
                 if ( jQuery(this).is(':checked') ) {
                    
                    bkb_cat_row.slideDown(function(){
                        jQuery(this).removeClass("bkb_dn");
                        bkb_sc_scroll_manager();
                    });
                 
                 } else {
                     
                    bkb_cat_row.slideUp(function(){
                        jQuery(this).addClass("bkb_dn");
                        bkb_sc_scroll_manager();
                    });
                 }
                 
             });
             
             bkb_display_tag_status.click(function(){
                 
                  if ( jQuery(this).is(':checked') ) {
                    
                    bkb_tags_row.slideDown(function(){
                        jQuery(this).removeClass("bkb_dn");
                        bkb_sc_scroll_manager();
                    });
                 
                 } else {
                     
                    bkb_tags_row.slideUp(function(){
                        jQuery(this).addClass("bkb_dn");
                        bkb_sc_scroll_manager();
                    });
                 }
                 
             });
             
             
        function bkb_sc_scroll_manager() {
            
            var bkb_is_display_scroll = bkb_display_category_status.is(':checked') && bkb_display_tag_status.is(':checked');
            
            if ( bkb_is_display_scroll == true ) {
             
                $bkb_parent_container.addClass('bkb_overflow');
                $('#bkb_editor_popup').animate({
                    scrollTop: $("#bkb_editor_popup_buttons").offset().top
                }, 2000);
            } else {
              
                $bkb_parent_container.removeClass('bkb_overflow');
            }
        }
        
        $("#bkb_editor_popup").css({
            'margin-top' : '40px'
        });
        
        $('#addShortCodebtn').click(function(event) {

            // Columns
            
            // INITIALIZE ALL SHORTCODE TEXT
            var bkb_shortcode = "";
            var sc_bkb_ajax_sbox = "";
            
            /*---------------------------Generate Search Box Shortcode ------------------------------------*/
            
            if( $bkb_parent_container.find('#bkb_ajax_sbox').is(':checked') ) {
                
                sc_bkb_ajax_sbox += '[bkb_search /]';
                        
            }
            
            /*-----------------------------Generate Tab Shortcode ----------------------------------*/
 
            
            var sc_bkb_tab = "";
            
            var sc_bkb_tab_limit_text = "";
            
            if( $bkb_parent_container.find('#bkb_display_tab_status').is(':checked') ) {
                
                sc_bkb_tab += '[bkb_tabs]';
                
                
                /*----------------------------LIMIT -----------------------------------*/
            
                if ( $bkb_parent_container.find('#bkb_no_of_tab_items').val().length !== 0 && ! isNaN( $bkb_parent_container.find('#bkb_no_of_tab_items').val()) ) {

                    sc_bkb_tab_limit_text += ' limit="' + $bkb_parent_container.find('#bkb_no_of_tab_items').val()+ '" ';

                }
                
                /*----------------------------- Conditions ----------------------------------*/
                
                 var selected_bkb_tab = $bkb_parent_container.find('#bkb_tab_items').multipleSelect("getSelects","text"),
                        selected_bkb_tab_slug = $bkb_parent_container.find('#bkb_tab_items').multipleSelect("getSelects");
                        
                 if ( selected_bkb_tab.length > 0 ) {
                    
                      for(var i= 0 ; i< selected_bkb_tab.length; i ++ ) {
                          
                            if (selected_bkb_tab_slug[i] === "featured") {

                              sc_bkb_tab +='[bkb_tab title="'+bkb_string_featured+'"] [bwl_kb bkb_tabify="1" meta_key="bkb_featured_status" meta_value="1" orderby="meta_value_num" order="ASC" ' + sc_bkb_tab_limit_text + '] [/bkb_tab]'; 

                           }

                           if (selected_bkb_tab_slug[i] === "popular") {

                              sc_bkb_tab +='[bkb_tab title="'+bkb_string_popular+'"] [bwl_kb bkb_tabify="1" meta_key="bkbm_post_views" orderby="meta_value_num" order="DESC"' + sc_bkb_tab_limit_text + '] [/bkb_tab]'; 

                          }

                          if (selected_bkb_tab_slug[i] === "recent") {

                              sc_bkb_tab +='[bkb_tab title="'+bkb_string_recent+'"] [bwl_kb bkb_tabify="1" orderby="ID" order="DESC" ' + sc_bkb_tab_limit_text + '] [/bkb_tab]'; 

                         }
                         
               
                    }
                     
              }
              
              sc_bkb_tab +='[/bkb_tabs]';
                        
            }
            
            /*--------------------------- Generate Category Shortcode ------------------------------------*/
            
            var sc_bkb_category = "";
            
            if( $bkb_parent_container.find('#bkb_display_category_status').is(':checked') ) {
                
                sc_bkb_category += '[bkb_category';
                
                /*----------------------------- Conditions ----------------------------------*/
                
                 var selected_bkb_category = $bkb_parent_container.find('#bkb_category').multipleSelect("getSelects","text"),
                        selected_bkb_category_slug = $bkb_parent_container.find('#bkb_category').multipleSelect("getSelects");
                        
                 if ( selected_bkb_category.length > 0 ) {
                    
                     sc_bkb_category +=' categories="'; 
                    
                      for(var i= 0 ; i< selected_bkb_category.length; i ++ ) {
               
                            sc_bkb_category += selected_bkb_category_slug[i] + ","; 
                            
                      }
                      
                      sc_bkb_category = sc_bkb_category.substr(0, sc_bkb_category.length-1)+'"';
                     
                 }
                 
                 /*----------------------------LIMIT -----------------------------------*/
            
                if ( $bkb_parent_container.find('#bkb_no_of_category_items').val().length !== 0 && ! isNaN( $bkb_parent_container.find('#bkb_no_of_category_items').val()) ) {

                    sc_bkb_category += ' limit="' + $bkb_parent_container.find('#bkb_no_of_category_items').val()+ '" ';

                }
                
                /*----------------------------Order By -----------------------------------*/
                
                if ( $bkb_parent_container.find('#bkb_category_orderby').val().length !== 0) {

                    sc_bkb_category +=  ' orderby="' +$bkb_parent_container.find('#bkb_category_orderby').val() + '" ';

                }
                
                /*----------------------------Order -----------------------------------*/
                
                if ( $bkb_parent_container.find('#bkb_category_order').val().length !== 0) {

                    sc_bkb_category +=  ' order="' + $bkb_parent_container.find('#bkb_category_order').val() + '" ';

                }
                
                
                 /*----------------------------Post Counts -----------------------------------*/
                
                if ( $bkb_parent_container.find('#bkb_category_view_style').val().length !== 0 && $bkb_parent_container.find('#bkb_category_view_style').val() == 1 ) {

                    sc_bkb_category +=  ' box_view="' + $bkb_parent_container.find('#bkb_category_view_style').val() + '" ';

                }
                
                 if ( $bkb_parent_container.find('#bkb_display_category_desc').val().length !== 0 && $bkb_parent_container.find('#bkb_display_category_desc').val() == 1 ) {
                     sc_bkb_category +=  ' bkb_desc="1" ';
                }
                
                /*----------------------------Post Counts -----------------------------------*/
                
                if ( $bkb_parent_container.find('#bkb_category_posts_count').val().length !== 0) {

                    sc_bkb_category +=  ' posts_count="' + $bkb_parent_container.find('#bkb_category_posts_count').val() + '" ';

                }
                
                /*----------------------------Category List Type -----------------------------------*/
                
                if ( $bkb_parent_container.find('#bkb_cat_list_type').val().length !== 0) {

                    sc_bkb_category +=  ' bkb_list_type="' + $bkb_parent_container.find('#bkb_cat_list_type').val() + '" ';

                }
                
                /*----------------------------Cols -----------------------------------*/
                
                if ( $bkb_parent_container.find('#bkb_no_of_cat_cols:checked').length === 1 ) {
 
                    sc_bkb_category +=  ' cols="' + $bkb_parent_container.find('#bkb_no_of_cat_cols:checked').val() + '" ';

                }
                
                sc_bkb_category +=' /]';
                        
            }
            
            /*--------------------------- Generate Tag Shortcode ------------------------------------*/
            
            var sc_bkb_tag = "";
            
            if( $bkb_parent_container.find('#bkb_display_tag_status').is(':checked') ) {
                
                sc_bkb_tag += '[bkb_tags';
                
                /*----------------------------- Conditions ----------------------------------*/
                
                 var selected_bkb_tags = $bkb_parent_container.find('#bkb_tags').multipleSelect("getSelects","text"),
                      selected_bkb_tags_slug = $bkb_parent_container.find('#bkb_tags').multipleSelect("getSelects");
                        
                 if ( selected_bkb_tags.length > 0 ) {
                    
                     sc_bkb_tag +=' tags="'; 
                    
                      for(var i= 0 ; i< selected_bkb_tags.length; i ++ ) {
               
                            sc_bkb_tag += selected_bkb_tags_slug[i] + ","; 
                            
                      }
                      
                      sc_bkb_tag = sc_bkb_tag.substr(0, sc_bkb_tag.length-1)+'"';
                     
                 } 
                 
                /*----------------------------LIMIT -----------------------------------*/
            
                if ( $bkb_parent_container.find('#bkb_no_of_tag_items').val().length !== 0 && ! isNaN($bkb_parent_container.find('#bkb_no_of_tag_items').val()) ) {

                    sc_bkb_tag += ' limit="' + $bkb_parent_container.find('#bkb_no_of_tag_items').val()+ '" ';

                }
                
                /*----------------------------Order By -----------------------------------*/
                
                if ( $bkb_parent_container.find('#bkb_tag_orderby').val().length !== 0) {

                    sc_bkb_tag +=  ' orderby="' +$bkb_parent_container.find('#bkb_tag_orderby').val() + '" ';

                }
                
                /*----------------------------Order -----------------------------------*/
                
                if ( $bkb_parent_container.find('#bkb_tag_order').val().length !== 0) {

                    sc_bkb_tag +=  ' order="' + $bkb_parent_container.find('#bkb_tag_order').val() + '" ';

                }
                
                /*----------------------------Post Counts -----------------------------------*/
                
                if ( $bkb_parent_container.find('#bkb_tag_posts_count').val().length !== 0) {

                    sc_bkb_tag +=  ' posts_count="' + $bkb_parent_container.find('#bkb_tag_posts_count').val() + '" ';

                }
                
                 /*----------------------------Tags List Type -----------------------------------*/
                
                if ( $bkb_parent_container.find('#bkb_tag_view_style').val().length !== 0 && $bkb_parent_container.find('#bkb_tag_view_style').val() == 1 ) {

                    sc_bkb_tag +=  ' box_view="' + $bkb_parent_container.find('#bkb_tag_view_style').val() + '" ';

                }
                
              
               if ( $bkb_parent_container.find('#bkb_display_tag_desc').val().length !== 0 && $bkb_parent_container.find('#bkb_display_tag_desc').val() == 1 ) {
                     sc_bkb_tag +=  ' bkb_desc="1" ';
                }
                
                
                if ( $bkb_parent_container.find('#bkb_tag_list_type').val().length !== 0) {

                    sc_bkb_tag +=  ' bkb_list_type="' + $bkb_parent_container.find('#bkb_tag_list_type').val() + '" ';

                }
                
                /*----------------------------Tag -----------------------------------*/
                
                 if ( $bkb_parent_container.find('#bkb_no_of_tag_cols:checked').length === 1 ) {
 
                    sc_bkb_tag +=  ' cols="' + $bkb_parent_container.find('#bkb_no_of_tag_cols:checked').val() + '" ';

                }
                
                sc_bkb_tag +=' /]';
                        
            }

            /*---------------------------Concate All Shortcodes ------------------------------------*/
            
            bkb_shortcode+=sc_bkb_ajax_sbox+sc_bkb_tab+sc_bkb_category+sc_bkb_tag;

            window.send_to_editor(bkb_shortcode);

            $('#bkb_editor_overlay').remove();
            
            return false;
            
        });

        $('#closeShortCodebtn, .btn_bkb_editor_close').click(function(event) {
            $('#bkb_editor_overlay').remove();
            return false;
        });
        
        /*---------------------------------TAB Items------------------------------*/
        
         $('select#bkb_tab_items').add("multiple","multiple");
         
         $('select#bkb_tab_items').multipleSelect({
            placeholder: "- Select -",
            selectAll: true,
            filter: true
           
        });
        
        $('select#bkb_tab_items').multipleSelect("checkAll");
        
        
        /*------------------------------ Category ---------------------------------*/
        
        $('select#bkb_category').add("multiple","multiple");
        
        $('select#bkb_category').multipleSelect({
            placeholder: "- Select -",
            selectAll: true,
            filter: true
           
        });
        
        $('select#bkb_category').multipleSelect("uncheckAll");
        
        /*------------------------------ Topics ---------------------------------*/
        
        $('select#bkb_tags').add("multiple","multiple");
        
         $('select#bkb_tags').multipleSelect({
            placeholder: "- Select -",
            selectAll: true,
            filter: true
           
        });
        
        $('select#bkb_tags').multipleSelect("uncheckAll");
        
        // Enable Drag Drop Of Editor
        
        $("#bkb_editor_popup").draggable({ cursor: "move"});
    });
    
</script>

<h3><?php _e('BWL Knowledge Base Shortcode Editor', 'bwl-kb'); ?>

<span class="btn_bkb_editor_close">X</span>

</h3>

<div id="bkb_editor_popup_content">
<?php 

        $bkb_data = get_option('bkb_options');

        $bkb_tab_items = array(
            'featured' => 'Featured KB',
            'popular' => 'Popular KB',
            'recent' => 'Recent KB',
        );
        
        $bkb_category_args = array(
                'taxonomy' => 'bkb_category',
                'hide_empty' => 1,
                'orderby' => 'title', 
                'order' => 'ASC',
                'suppress_filters' => FALSE
        );
            
        $bkb_categories = get_categories( $bkb_category_args );
        
        $bkb_tags_args = array(
            
                'taxonomy' => 'bkb_tags',
                'hide_empty' => 1,
                'orderby' => 'title', 
                'order' => 'ASC',
                'suppress_filters' => FALSE
        );
            
        $bkb_tags = get_categories( $bkb_tags_args );
        
        ?>
    
    <div class="row">
        
        <label for="bkb_ajax_sbox"><?php _e('Search Box', 'bwl-kb')?></label>
        <input type="checkbox" id="bkb_ajax_sbox" name="bkb_ajax_sbox" value="1" class="bkb_checkbox" />
        
    </div> <!-- end row  -->
    
    <hr class="bkb-shortcode-seperator"/>
    
    <div class="row">
        
        <label for="bkb_display_tab_status"><?php _e('Display Tab Items?', 'bwl-kb')?></label>
        <input type="checkbox" id="bkb_display_tab_status" name="bkb_display_tab_status" value="1" class="bkb_checkbox"/>
        
    </div> <!-- end row  -->
    
    <div class="row bkb_dn bkb_tab_row">
        
        <label for="bkb_tab_items"><?php _e('TAB Items', 'bwl-kb'); ?></label>
        
        <select id="bkb_tab_items" name="bkb_tab_items">
        
            <?php

                foreach($bkb_tab_items as $tab_items_key => $tab_items_value ):

            ?>        
                <option value="<?php echo $tab_items_key; ?>"><?php echo $tab_items_value; ?></option>

            <?php 

                endforeach;

            ?>            
            
        </select>
        
    </div>
    
    <div class="row bkb_dn bkb_tab_row">
        <label for="bkb_no_of_tab_items"><?php _e('No of Items','bwl-kb'); ?></label>
        <input type="text" id="bkb_no_of_tab_items" name="bkb_no_of_tab_items" value="5" style="width: 50px;"/> <small>e.g: Any number like 1,2,3 </small>
    </div>
    
    <hr class="bkb-shortcode-seperator"/>
    
    <div class="row">
        
        <label for="bkb_display_category_status"><?php _e('Display Category Items?', 'bwl-kb')?></label>
        <input type="checkbox" id="bkb_display_category_status" name="bkb_display_category_status" value="1" class="bkb_checkbox"/>
        
    </div> <!-- end row  -->
    
    <div class="row bkb_dn bkb_cat_row">
        
        <label for="bkb_category"><?php _e('Select Categories', 'bwl-kb'); ?></label>
        
        <select id="bkb_category" name="bkb_category">
        
        <?php
        
            foreach($bkb_categories as $category):
        
        ?> 
            
            <option value="<?php echo $category->slug ?>"><?php echo ucwords( $category->name ); ?> ( <?php echo $category->count; ?> )</option>
        
        <?php 
        
                endforeach;
        
            wp_reset_query();
        
        ?>            
            
        </select>
        
    </div>
     
    <div class="row bkb_dn bkb_cat_row">
        <label for="bkb_no_of_cat_cols"><?php _e('No of Columns','bwl-kb'); ?></label>
        <input type="radio" id="bkb_no_of_cat_cols" name="bkb_no_of_cat_cols" value="1"/>1 &nbsp;
        <input type="radio" id="bkb_no_of_cat_cols" name="bkb_no_of_cat_cols" value="2" checked="checked"/>2 &nbsp;
        <input type="radio" id="bkb_no_of_cat_cols" name="bkb_no_of_cat_cols" value="3"/>3
    </div>
    
    <div class="row bkb_dn bkb_cat_row">
        <label for="bkb_no_of_category_items"><?php _e('No of Items','bwl-kb'); ?></label>
        <input type="text" id="bkb_no_of_category_items" name="bkb_no_of_category_items" value="" style="width: 50px;"/> <small>e.g: Any number like 1,2,3 </small>
    </div>
     
    <div class="row bkb_dn bkb_cat_row">
        <label for="bkb_category_orderby"><?php _e('Order Settings', 'bwl-kb'); ?></label>
        <select id="bkb_category_orderby" name="bkb_category_orderby" style="width: 150px;">
            <option value="" selected>- <?php _e('Order By', 'bwl-kb'); ?> -</option>
            <option value="id"><?php _e('ID', 'bwl-kb'); ?></option>
            <option value="title"><?php _e('Title', 'bwl-kb'); ?></option>
            <option value="date"><?php _e('Date', 'bwl-kb'); ?></option>            
            <option value="rand"><?php _e('Random Order', 'bwl-kb'); ?></option>
        </select>
         
        <select id="bkb_category_order" name="bkb_category_order" style="width: 150px;">
            <option value="" selected>- <?php _e('Order Type', 'bwl-kb'); ?> -</option>
            <option value="ASC"><?php _e('Ascending', 'bwl-kb'); ?></option>
            <option value="DESC"><?php _e('Descending', 'bwl-kb'); ?></option>            
        </select>
    </div>
    
    <div class="row bkb_dn bkb_cat_row">
        <label for="bkb_category_view_style"><?php _e('Display Settings', 'bwl-kb'); ?></label>
         
        <select id="bkb_category_view_style" name="bkb_category_view_style" style="width: 150px;">
            <option value="" selected>- <?php _e('View Type', 'bwl-kb'); ?> -</option>
            <option value="0"><?php _e('Lists View', 'bwl-kb'); ?></option>
            <option value="1"><?php _e('Boxed View', 'bwl-kb'); ?></option>
        </select>
        
        <select id="bkb_cat_list_type" name="bkb_cat_list_type" style="width: 150px;">
            <option value="" selected>- <?php _e('Lists Style', 'bwl-kb'); ?> -</option>
            <option value="rounded"><?php _e('Rounded', 'bwl-kb'); ?></option> 
            <option value="rectangle"><?php _e('Rectangle', 'bwl-kb'); ?></option>           
            <option value="iconized"><?php _e('Iconized', 'bwl-kb'); ?></option>            
            <option value="none"><?php _e('None', 'bwl-kb'); ?></option>            
        </select>
    </div>
    
    
    <div class="row bkb_dn bkb_cat_row">
        
        <label for="bkb_category_posts_count">&nbsp;</label>
        
        <select id="bkb_category_posts_count" name="bkb_category_posts_count" style="width: 140px;">
            <option value="" selected>- <?php _e('Post Count', 'bwl-kb'); ?> -</option>
            <option value="1"><?php _e('Yes', 'bwl-kb'); ?></option>
            <option value="0"><?php _e('No', 'bwl-kb'); ?></option>            
        </select>
        
        <select id="bkb_display_category_desc" name="bkb_display_category_desc" style="width: 160px;">
            <option value="" selected>- <?php _e('Show Description', 'bwl-kb'); ?> -</option>
            <option value="1"><?php _e('Yes', 'bwl-kb'); ?></option>
            <option value="0"><?php _e('No', 'bwl-kb'); ?></option>            
        </select>
        
    </div> <!-- end row  -->
    
    
    <hr class="bkb-shortcode-seperator"/>
    
    <div class="row">
        
        <label for="bkb_display_tag_status"><?php _e('Display Tag Items?', 'bwl-kb')?></label>
        <input type="checkbox" id="bkb_display_tag_status" name="bkb_display_tag_status" value="1" class="bkb_checkbox"/>
        
    </div> <!-- end row  -->
    
    <div class="row bkb_dn bkb_tags_row">
        
        <label for="bkb_tags"><?php _e('Select Tags', 'bwl-kb'); ?></label>
        
        <select id="bkb_tags" name="bkb_tags">
        
        <?php
        
            foreach($bkb_tags as $tags):
        
        ?>        
            
            <option value="<?php echo $tags->slug ?>"><?php echo ucwords( $tags->name ); ?> ( <?php echo $tags->count; ?> )</option>
        
        <?php 
        
                endforeach;
        
            wp_reset_query();
        
        ?>            
            
        </select>
        
    </div>

    <div class="row bkb_dn bkb_tags_row">
        <label for="bkb_no_of_tag_cols"><?php _e('No of Columns','bwl-kb'); ?></label>
        <input type="radio" id="bkb_no_of_tag_cols" name="bkb_no_of_tag_cols" value="1"/>1 &nbsp;
        <input type="radio" id="bkb_no_of_tag_cols" name="bkb_no_of_tag_cols" value="2" checked="checked"/>2 &nbsp;
        <input type="radio" id="bkb_no_of_tag_cols" name="bkb_no_of_tag_cols" value="3"/>3
    </div>
    
    <div class="row bkb_dn bkb_tags_row">
        <label for="bkb_no_of_tag_items"><?php _e('No of Items','bwl-kb'); ?></label>
        <input type="text" id="bkb_no_of_tag_items" name="bkb_no_of_tag_items" value="" style="width: 50px;"/> <small>e.g: Any number like 1,2,3 </small>
    </div>
     
    <div class="row bkb_dn bkb_tags_row">
        <label for="bkb_tag_orderby"><?php _e('Order Settings', 'bwl-kb'); ?></label>
        <select id="bkb_tag_orderby" name="bkb_tag_orderby" style="width: 150px;">
            <option value="" selected>- <?php _e('Order By', 'bwl-kb'); ?> -</option>
            <option value="id"><?php _e('ID', 'bwl-kb'); ?></option>
            <option value="title"><?php _e('Title', 'bwl-kb'); ?></option>
            <option value="date"><?php _e('Date', 'bwl-kb'); ?></option>            
            <option value="rand"><?php _e('Random Order', 'bwl-kb'); ?></option>
        </select>
         
        <select id="bkb_tag_order" name="bkb_tag_order" style="width: 150px;">
            <option value="" selected>- <?php _e('Order Type', 'bwl-kb'); ?> -</option>
            <option value="ASC"><?php _e('Ascending', 'bwl-kb'); ?></option>
            <option value="DESC"><?php _e('Descending', 'bwl-kb'); ?></option>            
        </select>
    </div>
    
    <div class="row bkb_dn bkb_tags_row">
        <label for="bkb_tag_posts_count"><?php _e('Display Settings', 'bwl-kb'); ?></label>
         
        <select id="bkb_tag_view_style" name="bkb_tag_view_style" style="width: 150px;">
            <option value="" selected>- <?php _e('View Type', 'bwl-kb'); ?> -</option>
            <option value="0"><?php _e('Lists View', 'bwl-kb'); ?></option>
            <option value="1"><?php _e('Boxed View', 'bwl-kb'); ?></option>
        </select>
        
        <select id="bkb_tag_list_type" name="bkb_tag_list_type" style="width: 150px;">
            <option value="" selected>- <?php _e('Lists Style', 'bwl-kb'); ?> -</option>
            <option value="rounded"><?php _e('Rounded', 'bwl-kb'); ?></option> 
            <option value="rectangle"><?php _e('Rectangle', 'bwl-kb'); ?></option>           
            <option value="iconized"><?php _e('Iconized', 'bwl-kb'); ?></option>            
            <option value="none"><?php _e('None', 'bwl-kb'); ?></option>            
        </select>
    </div>
    
    <div class="row bkb_dn bkb_tags_row">
        
        <label for="bkb_tag_list_type">&nbsp;</label>
        
        
        <select id="bkb_tag_posts_count" name="bkb_tag_posts_count" style="width: 140px;">
            <option value="" selected>- <?php _e('Post Count', 'bwl-kb'); ?> -</option>
            <option value="1"><?php _e('Yes', 'bwl-kb'); ?></option>
            <option value="0"><?php _e('No', 'bwl-kb'); ?></option>            
        </select>
        
        <select id="bkb_display_tag_desc" name="bkb_display_tag_desc" style="width: 160px;">
            <option value="" selected>- <?php _e('Show Description', 'bwl-kb'); ?> -</option>
            <option value="1"><?php _e('Yes', 'bwl-kb'); ?></option>
            <option value="0"><?php _e('No', 'bwl-kb'); ?></option>            
        </select>
        
    </div> <!-- end row  -->
    

    <div id="bkb_editor_popup_buttons">
        <input id="addShortCodebtn" name="addShortCodebtn" class="button-primary" type="button" value="Add Shortcode" />
        <input id="closeShortCodebtn" name="closeShortCodebtn" class="button" type="button" value="Close" />
    </div>

</div>