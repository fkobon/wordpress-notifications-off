jQuery(document).ready( function($){   

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

