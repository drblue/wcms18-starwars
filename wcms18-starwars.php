<?php
/**
 * Plugin Name: WCMS18 StarWars Widget
 * Plugin URI:  https://thehiveresistance.com/wcms18-starwars
 * Description: This plugin for displaying some StarWars trivia.
 * Version:     0.1
 * Author:      Johan Nordström
 * Author URI:  https://thehiveresistance.com
 * License:     WTFPL
 * License URI: http://www.wtfpl.net/
 * Text Domain: wcms18-starwars
 * Domain Path: /languages
 */

require("swapi.php");
require("class.StarWarsWidget.php");

function wsw_widgets_init() {
	register_widget('StarWarsWidget');
}
add_action('widgets_init', 'wsw_widgets_init');

/**
 * Respond to AJAX-query for 'action: get_starwars_vehicles'
 *
 *
 */
function wsw_ajax_get_starwars_vehicles() {
	$vehicles = swapi_get_vehicles();

	wp_send_json($vehicles);
}
add_action('wp_ajax_get_starwars_vehicles', 'wsw_ajax_get_starwars_vehicles');
add_action('wp_ajax_nopriv_get_starwars_vehicles', 'wsw_ajax_get_starwars_vehicles');
