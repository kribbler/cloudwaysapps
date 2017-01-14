/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

(function($) {
    
if($('select[name=bkb_fa_id]')) {
    
    function bkb_display_demo_icon($bkb_fa_id, $bkb_current_icon) {

        if( $bkb_current_icon.length == 0 ) {
            $("span.bkb-icon-demo").html('');
        } else {
            $("span.bkb-icon-demo").html('<i class="'+$bkb_current_icon+'"></i>');
        }
        
    }
    
    var $bkb_fa_id = $('select[name=bkb_fa_id]');
         $bkb_fa_id.after('<span class="bkb-icon-demo"></span>');
    
    // Default on page Load Event.
    if( $bkb_fa_id.length > 0 ) {
        bkb_display_demo_icon($bkb_fa_id, $bkb_fa_id.val());
    }
    
    // Mouse change Event.
    $bkb_fa_id.on("change", function(){
        
        var $bkb_current_icon = $(this).val();
             bkb_display_demo_icon($bkb_fa_id, $bkb_current_icon);
        
    });
    
    // Keyboard Change Event.
    $bkb_fa_id.on("keyup", function(event){
        
        var $bkb_current_icon = $(this).val();

    var key = event.which;                
            switch(key) {
              case 37:
                  // Key left.
//                  console.log("Key left");
                  bkb_display_demo_icon($bkb_fa_id, $bkb_current_icon);
                  break;
              case 38:
                  // Key up.
//                  console.log("Key up");
                  bkb_display_demo_icon($bkb_fa_id, $bkb_current_icon);
                  break;
              case 39:
                  // Key right.
//                  console.log("Key right");
                  bkb_display_demo_icon($bkb_fa_id, $bkb_current_icon);
                  break;
              case 40:
                  // Key down.
//                  console.log("Key down");
                  bkb_display_demo_icon($bkb_fa_id, $bkb_current_icon);
                  break;
        }   
  });
    
    
}
 
})(jQuery);