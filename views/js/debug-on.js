jQuery(document).ready( function($){   

	// Initialize button switcher
	$("#switch-button").switchButton({
		width: 100,
		height: 40,
		button_width: 70
	});

	// onclick Listener
	$('.switch-button-background').click(function(){
		alert('switcher clicked');
		location.reload(); // force page reloading
	});
	// Switch on/off the debugging option
	jQuery.ajax({
			type : "post",
			dataType : "json",
			url : ajax_var.url,
			data : {action: "do_switch"},

			success: function(response) {
				var domain_list = response.debug_status;
			}
		})  
});

