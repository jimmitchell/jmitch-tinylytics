<?php // delete the Tinylytics settings on uninstall...

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit();

// delete options
delete_option( 'jmitch_tinylytics_settings' );