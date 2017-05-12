jQuery(document).ready( function($){   

	// onclick Listener
	$('.switch-button-background').click(function(){
		
		var nonce = '<?php echo wp_create_nonce( "notifications-nonce" ); ?>';

		// Switch notifications status via Ajax
		jQuery.ajax({
			type : "post",
			dataType : "json",
			url : ajax_var.url,
			data : {action: "no_switch", nonce : nonce},

			success: function(response) {
				location.reload(); // force page reloading
			}
		})  
		
	});

});
