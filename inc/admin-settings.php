<?php
/*
 *
 * Shortcode options for Tinylytics
 * Since version 1.0.2
 *
 */
?>
	<form method="post" action="options.php">
	<?php
		settings_fields('tinylytics_wp_settings_group');
		do_settings_sections('tinylytics-wp');
		submit_button();
		?>
	</form>

