<?php

/**
 * Adds StarWarsWidget widget.
 */

class StarWarsWidget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'wcms18-starwars-widget', // Base ID
			'WCMS18 StarWars', // Name
			[
				'description' => __('A Widget for displaying some StarWars trivia', 'wcms18-starwars-widget'),
			] // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);

		// start widget
		echo $before_widget;

		// title
		if (! empty($title)) {
			echo $before_title . $title . $after_title;
		}

		// content
		$vehicles = swapi_get_vehicles();
		$json_vehicles = json_encode($vehicles);
		echo $json_vehicles;

		if ($vehicles) {
			echo "<p>Total number of vehicles: " . count($vehicles) . "</p>";
			echo "<ul>";
			foreach ($vehicles as $vehicle) {
				?>
					<li>
						<?php echo $vehicle->name; ?><br>
						<small>
							Manufacturer: <?php echo $vehicle->manufacturer; ?><br>
							Model: <?php echo $vehicle->model; ?><br>
						</small>
					</li>
				<?php
			}
			echo "</ul>";
		} else {
			echo "Something went wrong. Try again?";
		}

		/*
		$films = swapi_get_films();
		if ($films) {
			echo "<p>Total number of films: " . count($films) . "</p>";
			echo "<ul>";
			foreach ($films as $film) {
				?>
					<li>
						<?php echo $film->title; ?><br>
						<small>
							Release date: <?php echo $film->release_date; ?><br>
							Episode: <?php echo $film->episode_id; ?><br>
							Species: <?php echo count($film->species); ?><br>
							Vehicles: <?php echo count($film->vehicles); ?><br>
							Planets visited: <?php echo count($film->planets); ?>
						</small>
					</li>
				<?php
			}
			echo "</ul>";
		} else {
			echo "Something went wrong. Try again?";
		}
		*/

		/*
		$characters = swapi_get_characters();
		if ($characters) {
			echo "<p>Total number of characters: " . count($characters) . "</p>";
			echo "<ul>";
			foreach ($characters as $character) {
				?>
					<li>
						<?php echo $character->name; ?><br>
						<small>
							Birth year: <?php echo $character->birth_year; ?><br>
							Height: <?php echo $character->height; ?> cm<br>
							Mass: <?php echo $character->mass; ?> kg<br>
						</small>
					</li>
				<?php
			}
			echo "</ul>";
		} else {
			echo "Something went wrong. Try again?";
		}
		*/

		/*
		$luke = swapi_get_character(1);
		echo "Luke is {$luke->height} cm tall.<br>";

		$someone = swapi_get_character(2);
		echo "{$someone->name} is {$someone->height} cm tall.<br>";

		$id = 4;
		$a_vehicle = swapi_get_vehicle($id);
		echo "Vehicle {$id}'s name is <strong>{$a_vehicle->name}</strong> and manufactured by {$a_vehicle->manufacturer} of model {$a_vehicle->model}. Say hi!<br>";
		*/

		// close widget
		echo $after_widget;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance) {
		if (isset($instance['title'])) {
			$title = $instance['title'];
		} else {
			$title = __('StarWars Trivia', 'wcms18-starwars-widget');
		}

		?>

		<!-- title -->
		<p>
			<label
				for="<?php echo $this->get_field_name('title'); ?>"
			>
				<?php _e('Title:'); ?>
			</label>

			<input
				class="widefat"
				id="<?php echo $this->get_field_id('title'); ?>"
				name="<?php echo $this->get_field_name('title'); ?>"
				type="text"
				value="<?php echo esc_attr($title); ?>"
			/>
		</p>
		<!-- /title -->
	<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update($new_instance, $old_instance) {
		$instance = [];

		$instance['title'] = (!empty($new_instance['title']))
			? strip_tags($new_instance['title'])
			: '';

		return $instance;
	}

} // class StarWarsWidget
