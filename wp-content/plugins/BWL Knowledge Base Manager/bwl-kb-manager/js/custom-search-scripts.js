jQuery(document).ready(function() {


    var bkb_filter_container = jQuery(".bkb_filter_container");

    bkb_filter_container.each(function() {

        var live_search_field = jQuery(this).find(".s");
        var bkbm_btn_clear = jQuery(this).find(".bkbm-btn-clear");

        live_search_field.val("").addClass('search_icon');

        var filter_timeout;

        live_search_field.on("keyup", function() {

            live_search_field = jQuery(this);

            var search_box_unique_id = live_search_field.data('search-box-unique-id');
            var suggestions = bkb_filter_container.find("#suggestions_" + search_box_unique_id);
            var suggestionsList = bkb_filter_container.find("#suggestionsList_" + search_box_unique_id);

            live_search_field.addClass('load');
            bkbm_btn_clear.addClass('bkbm-dn');

            clearTimeout(filter_timeout);

            var search_keywords = jQuery.trim(live_search_field.val());

            if (search_keywords.length < 2) {
                suggestions.fadeOut();
                live_search_field.removeClass('load');
                bkbm_btn_clear.addClass('bkbm-dn');    
            }

            filter_timeout = (search_keywords.length >= 2) && setTimeout(function() {

                jQuery.when(handle_server_search_response(search_keywords)).done(function(data) {

                    suggestions.fadeIn();
                    bkbm_btn_clear.removeClass('bkbm-dn');    
                    var search_result_html = '<ul>';

                    if (data.length > 0) {

                        jQuery.each(data, function(index, result) {

                            search_result_html += '<li><a href="' + result.link + '">' + result.title + '</a></li>';
                        })

                    } else {
                        search_result_html += '<li class="nothing-found">' + bkb_search_no_results_msg + '</li>';
                    }

                    search_result_html += '</ul>';

                    suggestionsList.html(search_result_html);
                    live_search_field.removeClass('load');

                });

            }, 900);

        });
        
        live_search_field.keypress(function( e ) {
                
            if ( e.keyCode === 13 ) {
                return false;
            }

        })
        
        // Clear Button Click Event.
        
        bkbm_btn_clear.on("click", function(){
            bkbm_btn_clear.addClass('bkbm-dn');        
            live_search_field.val("").addClass('search_icon');
            bkb_filter_container.find('.suggestionsBox').fadeOut();

        });

    });

    function handle_server_search_response(search_keywords) {

        return jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            dataType: 'JSON',
            data: {
                action: 'bkb_get_search_results', // action will be the function name
                bwl_ajax_search: true,
                s: search_keywords
            }
        });

    }

});