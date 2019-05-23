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

function swapi_get($endpoint) {
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
	return $items;
}

function swapi_get_films() {
	// do we have the films cached?
	$films = get_transient('swapi_get_films');

	if ($films) {
		// yep, let's return the cached films
		return $films;
	} else {
		// nope, retrieve the films from the StarWars API
		$items = swapi_get('films');
		set_transient('swapi_get_films', $items, 60*60);

		return $items;
	}
}

function swapi_get_vehicles() {
	// do we have the vehicles cached?
	$vehicles = get_transient('swapi_get_vehicles');

	if ($vehicles) {
		// yep, let's return the cached vehicles
		return $vehicles;
	} else {
		$items = swapi_get('vehicles');
		set_transient('swapi_get_vehicles', $items, 60*60);

		return $items;
	}
}

function swapi_get_characters() {
	// do we have the characters cached?
	$characters = get_transient('swapi_get_characters');

	if ($characters) {
		// yep, let's return the cached characters
		return $characters;
	} else {
		$items = swapi_get('people');
		set_transient('swapi_get_characters', $items, 60*60);

		return $items;
	}
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

