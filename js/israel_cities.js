jQuery(document).ready(function($){	
	var cities = null;
    $('#billing_city').click(function(){
		$.ajax({
			url : israel_cities_Ajax.ajaxurl,
			data : {action: "israel_cities_get_list"},
			success:    function(response) {
				cities = response.split(',');
				$("#billing_city").autocomplete({ source: cities });
			}
		})
   });
   
   $('#shipping_city').click(function(){
		$.ajax({
			url : israel_cities_Ajax.ajaxurl,
			data : {action: "israel_cities_get_list"},
			success:    function(response) {
				cities = response.split(',');
				$("#shipping_city").autocomplete({ source: cities });
			}
		})
   });
});