<?php // delete the Tinylytics settings on uninstall...

if (!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN')) exit();

// delete options
delete_option('tinylytics_wp_settings');