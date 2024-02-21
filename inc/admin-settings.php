<?php

/*
 *
 * Admin settings for Tinylytics
 * Since version 1.0.0
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
	<form method="post" action="options.php">
	<?php
		settings_fields( 'jmitch_tinylytics_settings_group' );
		do_settings_sections( 'jmitch-tinylytics' );
		submit_button();
		?>
	</form>

