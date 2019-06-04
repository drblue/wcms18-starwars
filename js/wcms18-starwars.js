(function($){
	// do something
	$(document).ready(function(){
		// document ready
		$('.widget_wcms18-starwars-widget').each(function(i, widget){
			console.log("Widget " + i + ":", widget);

			$.post(
				wsw_ajax_obj.ajax_url,  // URL to POST to
				{
					action: 'get_starwars_vehicles'
				}  // DATA to send to the URL
			).done(function(response){
				var content = $(widget).find('.content');
				$(content).html('<strong>Number of vehicles in all films:</strong> ' + response.length);
			}).fail(function(error){
				console.log("Something went wrong!", error);
			});
		});
	});
})(jQuery);
