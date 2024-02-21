<?php // delete the Tinylytics settings on uninstall...

if ( ! defined( 'ABSPATH' ) ) exit();

// delete options
delete_option( 'jmitch_tinylytics_settings' );