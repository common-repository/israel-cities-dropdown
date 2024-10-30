<?php

/*
Plugin Name: Israel cities dropdown
Description: Display Israel cities in checkout page
Version: 1.5
Author: Merav Ben Harush
Author URI: https://meravwebs.com
*/

if( ! defined( 'ABSPATH' ) ) exit;

if( ! function_exists('israel_cities_get_list') ) :	

add_action("wp_ajax_israel_cities_get_list", "israel_cities_get_list");
add_action("wp_ajax_nopriv_israel_cities_get_list", "israel_cities_get_list");
function israel_cities_get_list(  ) {

	global $wpdb;
	$cities = $wpdb->get_results( "SELECT city_name FROM ".$wpdb->prefix . "israel_cities order by city_name", ARRAY_A );
		
	$cities_arr = "";
	
	foreach ($cities as $city)
	{
		$cities_arr .= trim($city['city_name']).',';
	}
	
	$cities_arr = substr($cities_arr, 0, -1);
	
	echo ($cities_arr);
	wp_die();
}

add_action( 'wp_enqueue_scripts', function() {
	
	//wp_localize_script( 'israel_cities', 'israel_cities_Ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ))); 
	
	wp_enqueue_style( 'jquery-ui-styles','https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
    wp_enqueue_style( 'demo-styles','https://jqueryui.com/resources/demos/style.css');
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'jquery-ui-autocomplete' );
    wp_enqueue_script( 'israel_cities', plugins_url( 'js/israel_cities.js', __FILE__ ) );
	
	wp_localize_script( 'israel_cities', 'israel_cities_Ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ))); 
	 
});

/**
 * Activate the plugin.
 */
function israel_cities_activate() { 
    global $wpdb;

   $table_name = $wpdb->prefix . "israel_cities"; 
   
   $sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		city_name varchar(100) DEFAULT '' NOT NULL,
		PRIMARY KEY  (id)
	) CHARACTER SET utf8 COLLATE utf8_general_ci";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	
	$offset = 0;
	$limit = 500;
	$records = 0;
	$run = true;
	do {
		$response = wp_remote_retrieve_body(wp_remote_get( "https://data.gov.il/api/3/action/datastore_search?resource_id=5c78e9fa-c2e2-4771-93ff-7f400a12f7ba&limit=$limit&offset=$offset" ));
		
		$json_res = json_decode($response);

		$insert_arr = array();
		$records = 0;

		foreach ($json_res->result->records as $city)
		{
			$records++;
			$city = trim(str_replace(" (שבט)", "", $city->{'שם_ישוב'}));
			if (strpos($city, '"') === false)
				$insert_arr[] = '("'.$city.'")';
			else
				$insert_arr[] = "('".$city."')";
		}
		
		$offset += $records;

		$wpdb->query("INSERT INTO $table_name (city_name) VALUES ".implode(",", $insert_arr));
		
		if ($records < $limit)
			$run = false;
	}
	while ($run);
}
register_activation_hook( __FILE__, 'israel_cities_activate' );

function israel_cities_deactivate(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'israel_cities';
    $sql = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);
}

register_deactivation_hook(__FILE__, 'israel_cities_deactivate');

endif;