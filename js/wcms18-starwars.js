(function($){
	// do something
	$(document).ready(function(){
		// document ready
		$('.widget_wcms18-starwars-widget').each(function(i, widget){
			$.post(
				wsw_ajax_obj.ajax_url,  // URL to POST to
				{
					action: 'get_starwars_vehicles'
				}  // DATA to send to the URL
			).done(function(response){
				var content = $(widget).find('.content');

				//$(content).html('<strong>Number of vehicles in all films:</strong> ' + response.length);

				var names = [];
				response.forEach(function(vehicle){	// PHP: foreach ($response as $vehicle)
					names.push(vehicle.name);	// PHP: array_push($names, $vehicle->name);
				});

				$(content).html('<strong>All vehicle names:</strong><br><ol><li>' + names.join('</li><li>') + '</li></ol>');	// PHP: implode('</li><li>', $names)

			}).fail(function(error){
				console.log("Something went wrong!", error);
			});
		});
	});
})(jQuery);
