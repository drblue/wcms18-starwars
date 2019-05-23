<?php
/**
 * Functions for communicating with the StarWars API
 */

function swapi_get_films() {
	// do we have the films cached?
	$films = get_transient('swapi_get_films');

	if ($films) {
		// yep, let's return the cached films
		return $films;
	} else {
		// nope, retrieve the films from the StarWars API
		$result = wp_remote_get('https://swapi.co/api/films/');

		if (wp_remote_retrieve_response_code($result) === 200) {
			$data = json_decode(wp_remote_retrieve_body($result));
			$films = $data->results;
			set_transient('swapi_get_films', $films, 60*60);

			return $films;
		} else {
			return false;
		}
	}
}

function swapi_get_characters() {
	// do we have the characters cached?
	$characters = get_transient('swapi_get_characters');

	if ($characters) {
		// yep, let's return the cached characters
		return $characters;
	} else {
		// nope, retrieve the characters from the StarWars API
		$result = wp_remote_get('https://swapi.co/api/people/');

		if (wp_remote_retrieve_response_code($result) === 200) {
			$data = json_decode(wp_remote_retrieve_body($result));
			$characters = $data->results;
			// set_transient('swapi_get_characters', $characters, 60*60);

			return $characters;
		} else {
			return false;
		}
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
		$result = wp_remote_get('https://swapi.co/api/people/' . $character_id);

		if (wp_remote_retrieve_response_code($result) === 200) {
			$character = json_decode(wp_remote_retrieve_body($result));
			set_transient('swapi_get_character_' . $character_id, $character, 60*60*24*7);

			return $character;
		} else {
			return false;
		}
	}
}

