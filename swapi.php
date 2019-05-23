<?php
/**
 * Functions for communicating with the StarWars API
 */

function swapi_get_url($url) {
	$response = wp_remote_get($url);
	if (is_wp_error($response)) {
		return false;
	}

	return json_decode(wp_remote_retrieve_body($response));
}

function swapi_get($endpoint, $expiry = 3600) {
	$transient_key = "swapi_get_{$endpoint}";
	$items = get_transient($transient_key);

	if ($items) {
		return $items;

	} else {
		$items = [];
		$url = "https://swapi.co/api/{$endpoint}/";
		while ($url) {
			$data = swapi_get_url($url);
			if (!$data) {
				return false;
			}
			$items = array_merge($items, $data->results);

			$url = $data->next; // "https://swapi.co/" | null
		}

		// save for future use
		set_transient($transient_key, $items, $expiry);

		// return items
		return $items;
	}
}

function swapi_get_films() {
	return swapi_get('films');
}

function swapi_get_vehicles() {
	return swapi_get('vehicles');
}

function swapi_get_characters() {
	return swapi_get('people');
}

function swapi_get_character($character_id) {
	// do we have the films cached?
	$character = get_transient('swapi_get_character_' . $character_id);

	if ($character) {
		// yep, let's return the cached character
		return $character;
	} else {
		// nope, retrieve the character from the StarWars API
		$data = swapi_get_url('https://swapi.co/api/people/' . $character_id);
		if (!$data) {
			return false;
		}
		set_transient('swapi_get_character_' . $character_id, $data, 60*60*24*7);

		return $data;
	}
}

