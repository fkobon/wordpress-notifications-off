jQuery(document).ready( function($){   

	// Initialize button switcher
	$("#switch-button").switchButton({
		width: 100,
		height: 40,
		button_width: 70
	});

	// onclick Listener
	$('.switch-button-background').click(function(){
		
		var nonce = '<?php echo wp_create_nonce( "debug-nonce" ); ?>';

		// Switch debugging status via Ajax
		jQuery.ajax({
			type : "post",
			dataType : "json",
			url : ajax_var.url,
			data : {action: "do_switch", nonce : nonce},

			success: function(response) {
				location.reload(); // force page reloading
			}
		})  
		
	});

});
