(function($) {
    
    if ( typeof(inlineEditPost) == 'undefined') {
        return '';
    }
    
    // we create a copy of the WP inline edit post function
    var $wp_inline_edit = inlineEditPost.edit;
    
    // and then we overwrite the function with our own code
    inlineEditPost.edit = function(id) {

        // "call" the original WP edit function
        // we don't want to leave WordPress hanging
        $wp_inline_edit.apply(this, arguments);

        // now we take care of our business

        // get the post ID
        
        var $post_id = 0;
        
        if (typeof(id) == 'object')
            
            $post_id = parseInt(this.getId(id));

        if ($post_id > 0) {

            // define the edit row
            var $edit_row = $('#edit-' + $post_id);

            // Featured Status
            
            var bkb_featured_status = $('#bkb_featured_status-' + $post_id).data('status_code');
            
                 $edit_row.find('select[name="bkb_featured_status"]').val( ( bkb_featured_status > 0 ) ? bkb_featured_status : 0 );
            
            // BKB Authors
            
            var bkb_authors = $('#bkb_authors-' + $post_id).data('bkb_author_id');
             
                 $edit_row.find('select[name="bkb_authors"]').val( bkb_authors );

            // Display Status
            
            var bkb_display_status = $('#bkb_display_status-' + $post_id).data('status_code');
            
                 $edit_row.find('select[name="bkb_display_status"]').val( ( bkb_display_status > 0 ) ? bkb_display_status : 0 );
            
            // Display KB AS POST
            
            if( $('#bkb_kbdabp_status-' + $post_id).length ) {
                    
                    // Get the KB as Post Status.    

                    var bkb_kbdabp_status = $('#bkb_kbdabp_status-' + $post_id).data('status_code');

                    // Set the KB as Post Status.

                    $edit_row.find('select[name="bkb_kbdabp_status"]').val( ( bkb_kbdabp_status == 1 ) ? 1 : 0);
               
               }
            
        }

    };
    
    /*------------------------------ Bulk Edit Settings ---------------------------------*/
    
    $( '#bulk_edit' ).live( 'click', function() {

    // define the bulk edit row
    var $bulk_row = $( '#bulk-edit' );

    // get the selected post ids that are being edited
    var $post_ids = new Array();
    $bulk_row.find( '#bulk-titles' ).children().each( function() {
       $post_ids.push( $( this ).attr( 'id' ).replace( /^(ttle)/i, '' ) );
    });

    // get the $bkb_display_status
    
    var $bkb_featured_status = $bulk_row.find( 'select[name="bkb_featured_status"]' ).val();
    var $bkb_authors = $bulk_row.find( 'select[name="bkb_authors"]' ).val();
    var $bkb_display_status = $bulk_row.find( 'select[name="bkb_display_status"]' ).val();
    var $bkbm_post_views = $bulk_row.find( 'input[name="bkbm_post_views"]:checked' ).length;
    var $bkb_like_votes_count = $bulk_row.find( 'input[name="bkb_like_votes_count"]:checked' ).length;
    var $bkb_dislike_votes_count = $bulk_row.find( 'input[name="bkb_dislike_votes_count"]:checked' ).length;
    
        $bkbm_post_views = ( $bkbm_post_views == 1 ) ? 0 : "";
        $bkb_like_votes_count = ( $bkb_like_votes_count == 1 ) ? 0 : "";
        $bkb_dislike_votes_count = ( $bkb_dislike_votes_count ==  1 ) ? 0 : "";
        
        
    var bkb_kbdabp_status = "";
       
    if( $bulk_row.find( 'select[name="bkb_kbdabp_status"]' ).length ) {

         // Get the FAQ as Post Status.    

         bkb_kbdabp_status = $bulk_row.find( 'select[name="bkb_kbdabp_status"]' ).val();

    }    
 
    // save the data
    $.ajax({
       url: ajaxurl, // this is a variable that WordPress has already defined for us
       type: 'POST',
       async: false,
       cache: false,
       data: {
          action: 'manage_wp_posts_using_bulk_edit_bkbm', // this is the name of our WP AJAX function that we'll set up next
          post_ids: $post_ids, // and these are the 2 parameters we're passing to our function
          bkb_featured_status: $bkb_featured_status,
          bkb_authors: $bkb_authors,
          bkbm_post_views: $bkbm_post_views,
          bkb_display_status: $bkb_display_status,
          bkb_like_votes_count: $bkb_like_votes_count,
          bkb_dislike_votes_count: $bkb_dislike_votes_count,
          bkb_kbdabp_status: bkb_kbdabp_status
       }
    });

 });
 
})(jQuery);