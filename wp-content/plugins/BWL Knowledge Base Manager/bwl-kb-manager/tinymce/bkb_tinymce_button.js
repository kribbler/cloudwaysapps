jQuery(document).ready(function($) {

    tinymce.create('tinymce.plugins.bkb', {
        init: function(ed, url) {
            ed.addButton('bkb', {
                title: 'BWL Knowledge Base Manager',
                image: url + '/icons/bkb-editor.png',
                onclick: function() {
               
                    if ($('#shortcode_controle').length) {
                       
                        $('#shortcode_controle').remove();
                    }
                    else
                    {
                      
                        $('body').append('<div id="bkb_editor_overlay"><div id="bkb_editor_popup"></div></div>');

                        $('#bkb_editor_popup').load(url + '/bkb_shortcode_editor.php');

                        $('#bkb_editor_popup').css('margin-top', $(window).height() / 2 - $('#bkb_editor_popup').height() / 2);
                        
                        $(window).resize(function() {
                            $('#bkb_editor_popup').css('margin-top', '10px');
                        });
                        
                    }
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        }
    });
    
    tinymce.PluginManager.add('bkb', tinymce.plugins.bkb);

});