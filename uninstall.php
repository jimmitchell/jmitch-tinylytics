<?php // delete the WP Tinylytics settings on uninstall...

if (!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN')) exit();

// delete options
delete_option('wp_tinylytics_settings');