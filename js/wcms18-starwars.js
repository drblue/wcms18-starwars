(function($){
	// do something
	$(document).ready(function(){
		// document ready
		$('.widget_wcms18-starwars-widget').each(function(i, widget){
			console.log("Widget " + i + ":", widget);

			$.post(
				'someurl',  // URL to POST to
				{}  // DATA to send to the URL
			).done(function(response){
				console.log("Got response", response);
			}).fail(function(error){
				console.log("Something went wrong!", error);
			});
		});
	});
})(jQuery);
