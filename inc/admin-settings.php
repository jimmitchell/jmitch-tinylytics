<?php
/*
 *
 * Shortcode options for WP Tinylytics
 * Since version 1.0.2
 *
 */
?>
	<form method="post" action="options.php">
	<?php
		settings_fields('wp_tinylytics_settings_group');
		do_settings_sections('wp-tinylytics');
		submit_button();
		?>
	</form>

