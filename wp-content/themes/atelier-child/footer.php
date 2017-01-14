<?php
						global $sf_options;
						$header_layout = $sf_options['header_layout'];
						if (isset($_GET['header'])) {
							$header_layout = $_GET['header'];
						}

						global $remove_promo_bar;

						if ($remove_promo_bar) {
							remove_action('sf_main_container_end', 'sf_footer_promo', 20);
						}
					?>

				<?php
					/**
					 * @hooked - sf_footer_promo - 20
					 * @hooked - sf_one_page_nav - 30
					**/
					do_action('sf_main_container_end');
				?>

			<!--// CLOSE #main-container //-->
			</div>

			<div id="footer-wrap">
				<?php
					/**
					 * @hooked - sf_footer_widgets - 10
					 * @hooked - sf_footer_copyright - 20
					**/
					do_action('sf_footer_wrap_content');
				?>
			</div>

			<?php do_action('sf_container_end'); ?>

		<!--// CLOSE #container //-->
		</div>

		<?php
			/**
			 * @hooked - sf_back_to_top - 20
			 * @hooked - sf_fw_video_area - 30
			**/
			do_action('sf_after_page_container');
		?>

<script>
    jQuery(document).ready(function($){
        $( '.menu-item-has-children' ).hover(
            function(){
            	//console.log($(this) + '.menu-item-text').html());
        		//$(this).addClass('menu-item-has-children_minus');
            	$(this).addClass('menu-item-has-children2');
            },
            function(){
            	//$(this).removeClass('menu-item-has-children_minus');
            	$(this).removeClass('menu-item-has-children2');
            }
        );

        $('.big_transparent_red').focus(function(){
        	$(this).css('background-color', '#f05223');
        });
        $('.big_transparent_red').focusout(function(){
        	$(this).css('background', 'none');
        });

        $('#home_post_code').focus(function() {
		    $(this).attr('placeholder', '')
		}).blur(function() {
		    $(this).attr('placeholder', 'Indtast postnummer og tjek dækning')
		})
    }); // end ready
</script>

<script>


( function( window ) {

'use strict';

// class helper functions from bonzo https://github.com/ded/bonzo

function classReg( className ) {
  return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
}

// classList support for class management
// altho to be fair, the api sucks because it won't accept multiple classes at once
var hasClass, addClass, removeClass;

if ( 'classList' in document.documentElement ) {
  hasClass = function( elem, c ) {
    return elem.classList.contains( c );
  };
  addClass = function( elem, c ) {
    elem.classList.add( c );
  };
  removeClass = function( elem, c ) {
    elem.classList.remove( c );
  };
}
else {
  hasClass = function( elem, c ) {
    return classReg( c ).test( elem.className );
  };
  addClass = function( elem, c ) {
    if ( !hasClass( elem, c ) ) {
      elem.className = elem.className + ' ' + c;
    }
  };
  removeClass = function( elem, c ) {
    elem.className = elem.className.replace( classReg( c ), ' ' );
  };
}

function toggleClass( elem, c ) {
  var fn = hasClass( elem, c ) ? removeClass : addClass;
  fn( elem, c );
}

var classie = {
  // full names
  hasClass: hasClass,
  addClass: addClass,
  removeClass: removeClass,
  toggleClass: toggleClass,
  // short names
  has: hasClass,
  add: addClass,
  remove: removeClass,
  toggle: toggleClass
};

// transport
if ( typeof define === 'function' && define.amd ) {
  // AMD
  define( classie );
} else {
  // browser global
  window.classie = classie;
}

})( window );


			(function() {
				// trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
				if (!String.prototype.trim) {
					(function() {
						// Make sure we trim BOM and NBSP
						var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
						String.prototype.trim = function() {
							return this.replace(rtrim, '');
						};
					})();
				}

				[].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
					// in case the input is already filled..
					if( inputEl.value.trim() !== '' ) {
						classie.add( inputEl.parentNode, 'input--filled' );
					}

					// events:
					inputEl.addEventListener( 'focus', onInputFocus );
					inputEl.addEventListener( 'blur', onInputBlur );
				} );

				function onInputFocus( ev ) {
					classie.add( ev.target.parentNode, 'input--filled' );
				}

				function onInputBlur( ev ) {
					if( ev.target.value.trim() === '' ) {
						classie.remove( ev.target.parentNode, 'input--filled' );
					}
				}
			})();
		</script>

<script type="text/javascript">
jQuery(document).ready(function($){
	/*$('.home_star').mouseenter(function(){
		var id = $(this).attr('id');
		id = id.split("_");
		id = id[1];
		$('#hs_' + id).css('background-image', 'url(<?php echo get_stylesheet_directory_uri();?>/images/home_star.png)');
		$('#hs_' + id).css('border', '0');		
		$('#hs_' + id).css('color', '#fff');
	});

	$('.home_star').mouseleave(function(){
		var id = $(this).attr('id');
		id = id.split("_");
		id = id[1];
		$('#hs_' + id).css('background', 'none');
		$('#hs_' + id).css('border', '1px solid #f05223');
		$('#hs_' + id).css('color', '#f05223');
	});*/
});
</script>
		<?php wp_footer(); ?>

	<!--// CLOSE BODY //-->
	</body>


<!--// CLOSE HTML //-->
</html>