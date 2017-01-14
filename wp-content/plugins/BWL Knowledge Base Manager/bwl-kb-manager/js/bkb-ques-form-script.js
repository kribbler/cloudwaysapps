jQuery(document).ready(function($) {

    function bkb_randomNum( maxNum ){
        
        return Math.floor(Math.random()*maxNum+1);//return a number between 1 - 10
        
    }
    
    function bkb_checkRegexp ( o, regexp ) {
            
            if ( !( regexp.test( o.val() ) ) ) {
                
                    return false;
                    
                } else {
                    
                    return true;
                
            }
            
        }

    /*------------------------------ASK A KB FORM---------------------------------*/
    
    if ( jQuery(".bkb_ques_form").length ) {
        
        // Reset Question Form Field.
        
        jQuery(".bkb_ques_form").find("input#title, input#email, input#captcha").val("");
        jQuery(".bkb_ques_form").find("select#cat").val("-1");
        
        
        // Knowledgebase Question Form Submission.
        
        jQuery(".bkb_ques_form").find("input[type=submit]").click(function() {
        
        var bkb_ask_email_status = 0;

        var bkb_ques_form_submit_button = jQuery(this),
                bkb_ques_form_id = bkb_ques_form_submit_button.attr('bkb_ques_form_id'),
                bkb_ques_form_box_container = jQuery("#" + bkb_ques_form_id),
                bkb_ques_form_field_container = jQuery("#" + bkb_ques_form_id + " .bkb_ques_form"),
                emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;

        var bkb_ques_message_box = bkb_ques_form_box_container.find('.bkb-ques-form-message-box'),
                bkb_ques_title = bkb_ques_form_field_container.find('#title'),
                bkb_ques_cat = bkb_ques_form_field_container.find('#cat'),
                bkb_ques_email = bkb_ques_form_field_container.find('#email'),
                bkb_ques_captcha_status = bkb_ques_form_field_container.find('#captcha_status');

        if (bkb_ques_captcha_status.val() == 1) {

            var num1 = bkb_ques_form_field_container.find('#num1');
            var num2 = bkb_ques_form_field_container.find('#num2');
            var captcha = bkb_ques_form_field_container.find('#captcha');
            var all_fields = jQuery([]).add(bkb_ques_title).add(bkb_ques_cat).add(captcha);

        } else {

            var all_fields = jQuery([]).add(bkb_ques_title).add(bkb_ques_cat);

        }

        if( bkb_ques_email.length == 1 ) {
            all_fields = jQuery(all_fields).add( bkb_ques_email);
        }

        var bkb_bValid = true,
                required_field_msg = "",
                ok_border = "border: 1px solid #EEEEEE",
                error_border = "border: 1px solid #E63F37";


        if (jQuery.trim(bkb_ques_title.val()).length < 3) {

            bkb_title_bValid = false;
            bkb_ques_title.attr("style", error_border);
            required_field_msg += "" + err_bkb_question + "<br />";

        } else {

            bkb_title_bValid = true;
            bkb_ques_title.attr("style", ok_border);
            required_field_msg += "";

        }

        bkb_bValid = bkb_bValid && bkb_title_bValid;


        if (jQuery.trim(bkb_ques_cat.val()) == -1) {

            bkb_cat_bValid = false;
            bkb_ques_cat.attr("style", error_border);
            required_field_msg += "" + err_bkb_category;

        } else {

            bkb_cat_bValid = true;
            bkb_ques_cat.attr("style", ok_border);
            required_field_msg += "";

        }
        
        bkb_bValid = bkb_bValid && bkb_cat_bValid;
        
        var bkb_ques_email_val = "";
        
        if( bkb_ques_email.length == 1 ) {
        
            // Email Validation 
            if ( jQuery.trim(bkb_ques_email.val()).length == 0 || bkb_checkRegexp( bkb_ques_email , emailRegex) == false ) {

                bkb_ques_email_bValid = false;
                bkb_ques_email.attr("style", error_border);
                required_field_msg += "" + err_bkb_ques_email + "<br />";

            } else {

                bkb_ques_email_bValid = true;
                bkb_ques_email.attr("style", ok_border);
                required_field_msg += "";
                bkb_ques_email_val = bkb_ques_email.val();
            }

            bkb_bValid = bkb_bValid && bkb_ques_email_bValid;
        
        }

        if (bkb_ques_captcha_status.val() == 1) {

            if ((parseInt(jQuery.trim(num1.val())) + parseInt(jQuery.trim(num2.val())) != parseInt(jQuery.trim(captcha.val())))) {

                bkb_captcha_bValid = false;
                captcha.attr("style", error_border);
                required_field_msg += "" + err_bkb_captcha;

            } else {

                bkb_captcha_bValid = true;
                captcha.attr("style", ok_border);
                required_field_msg += "";

            }

            bkb_bValid = bkb_bValid && bkb_captcha_bValid;

        }

        //Alert Message Box For Required Fields.

        if (bkb_bValid == false) {

            bkb_ques_message_box.html("").addClass("bkb-ques-form-error-box").html(required_field_msg).slideDown("slow");

        }


        if (bkb_bValid == true) {
            all_fields.attr("style", ok_border);
            all_fields.addClass('bkb_ques_disabled_field').attr('disabled', 'disabled');
            bkb_ques_form_submit_button.addClass('bkb_ques_disabled_field').attr('disabled', 'disabled');
            bkb_ques_message_box.html("").removeClass("bkb-ques-form-error-box").addClass("bkb-ques-form-wait-box").html(bkb_wait_msg).slideDown("slow");

            jQuery.ajax({
                url: ajaxurl,
                type: 'POST',
                dataType: 'JSON',
                data: {
                    action: 'bkb_ques_save_post_data', // action will be the function name,
                    title: bkb_ques_title.val(),
                    cat: bkb_ques_cat.val(),
                    email: bkb_ques_email_val,
                    post_type: bkb_ques_form_field_container.find('#post_type').val(),
                    name_of_nonce_field: bkb_ques_form_field_container.find('#name_of_nonce_field').val(),
                },
                success: function(data) {

                    if (data.bwl_kb_add_status == 1) {

                        //Reload For New Number.

                        if (bkb_ques_captcha_status.val() == 1) {

                            num1.val(bkb_randomNum(15));
                            num2.val(bkb_randomNum(20));

                        }

                        bkb_ques_message_box.removeClass('bkb-ques-form-wait-box').html("").html(bkb_ques_add_msg).addClass("bkb-ques-form-success-box").delay(3000).slideUp("slow");
                        all_fields.val("").removeAttr('disabled').removeClass('bkb_ques_disabled_field');
                        bkb_ques_cat.val("-1");
                        bkb_ques_form_submit_button.removeAttr('disabled').removeClass('bkb_ques_disabled_field');

                    } else {

                        bkb_ques_message_box.removeClass('bkb-ques-form-wait-box').html("").html(bkb_ques_add_fail_msg).addClass("bkb-ques-form-error-box").delay(3000).slideUp("slow");
                        all_fields.removeAttr('disabled').removeClass('bkb_ques_disabled_field');
                        bkb_ques_cat.val("-1");
                        bkb_ques_form_submit_button.removeAttr('disabled').removeClass('bkb_ques_disabled_field');
                    }

                },
                error: function(xhr, textStatus, e) {

                    bkb_ques_message_box.removeClass('bkb-ques-form-wait-box').html("").html(bkb_ques_add_fail_msg).addClass("bkb-ques-form-error-box").delay(3000).slideUp("slow");
                    all_fields.removeAttr('disabled').removeClass('bkb_ques_disabled_field');
                    bkb_ques_form_submit_button.removeAttr('disabled').removeClass('bkb_ques_disabled_field');
                    return;
                }

            });

        }

        return false;

    });
    
    
    }

});