var table_wrapper = '.debug-on-wrapper ul.domain-list';

jQuery(document).ready( function($){   

	

	// show the domain list in a table
	show_domain_table( table_wrapper );

	// set the an action on click
	$('.debug-on-wrapper .add-domain').click(function(e) { 
		e.preventDefault();

		var domain_url = $('.domain-url').val();
		var nonce = ajax_var.nonce

		jQuery.ajax({
			type : "post",
			dataType : "json",
			url : ajax_var.url,
			data : {action: "do_add_domain_content", domain_url : domain_url, nonce: nonce},

			success: function(response) {
				
				var domain_list = response.domain_list;

				// clearing wrapper
				//$(table_wrapper).html(''); 
				
				// displaying the table
				refresh_domain_table(domain_list, table_wrapper);
				
			}
		})   

		
		

	});
		
	function refresh_domain_table(data, selector){
		// loop through item list and append li with content
		$(data).each(function(i,item) {
			$(selector).append($("<li>").text(i+1 +". " +item.domain_title)); 
		});
	}

	// show the domain list in a table
	function show_domain_table( wrapper ){
		jQuery.ajax({
				type : "post",
				dataType : "json",
				url : ajax_var.url,
				data : {action: "do_get_domain_list"},

				success: function(response) {
					
					var domain_list = response.domain_list;
					
					// loop through item list and append li with content
					refresh_domain_table(domain_list, wrapper);
				}
			})  
	}
		
	 	        
});

