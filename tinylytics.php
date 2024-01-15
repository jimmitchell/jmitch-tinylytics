<?php
/**
 * Plugin Name: Tinylytics
 * Plugin URI: https://jimmitchellmedia.net/tinylytics-wp-plugin/
 * Description: A simple plugin for embedding the Tinylytics script.
 * Tags: analytics, ga, google, google analytics, tracking, statistics, stats
 * Author: Jim Mitchell
 * Author URI: https://jimmitchellmedia.net
 * Dontate link: https://ko-fi.com/jimmitchellmedia
 * Requires at least: 4.6
 * Test up to: 6.4
 * Version: 1.0.0
 * Requires PHP: 5.6.20
 * Text Domain: tinylytics-wp
 * Domain Path: /languages
 * License: GPL v2 or later
 */

/*
	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 
	2 of the License, or (at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	with this program. If not, visit: https://www.gnu.org/licenses/
	
	Copyright 2023 Monzilla Media. All rights reserved.
*/

 if (!defined('ABSPATH')) die();

 // Hook functions into WordPress
add_action('admin_init', 'tinylytics_wp_register_settings');
add_action('admin_menu', 'tinylytics_wp_add_menu_page');
add_action('init', 'load_i18n');

// Register the settings
function tinylytics_wp_register_settings() {

    register_setting('tinylytics_wp_settings_group', 'tinylytics_wp_settings', 'tinylytics_wp_sanitize_options');
    
    add_settings_section('tinylytics_wp_general_section', __( 'General Settings','tinylytics-wp' ), 'tinylytics_wp_general_section_callback', 'tinylytics-wp');
    add_settings_section('tinylytics_wp_options_section', __( 'Tinylytics Options','tinylytics-wp' ), 'tinylytics_wp_options_section_callback', 'tinylytics-wp');
    
    add_settings_field('site_id', __( 'Site ID','tinylytics-wp' ), 'tinylytics_wp_site_id_callback', 'tinylytics-wp', 'tinylytics_wp_general_section');
    add_settings_field('display_hits', __( 'Display hits?','tinylytics-wp' ), 'tinylytics_wp_display_hits_callback', 'tinylytics-wp', 'tinylytics_wp_options_section');
    add_settings_field('display_stats', __( 'Link to your public stats?','tinylytics-wp' ), 'tinylytics_wp_display_stats_callback', 'tinylytics-wp', 'tinylytics_wp_options_section');
    add_settings_field('display_uptime', __( 'Display uptime?','tinylytics-wp' ), 'tinylytics_wp_display_uptime_callback', 'tinylytics-wp', 'tinylytics_wp_options_section');
    add_settings_field('display_kudos', __( 'Display Kudos?','tinylytics-wp' ), 'tinylytics_wp_display_kudos_callback', 'tinylytics-wp', 'tinylytics_wp_options_section');
    add_settings_field('kudos_label', __( 'Kudos label','tinylytics-wp' ), 'tinylytics_wp_kudos_label_callback', 'tinylytics-wp', 'tinylytics_wp_options_section');
    add_settings_field('display_webring', __( 'Display webring?','tinylytics-wp' ), 'tinylytics_wp_display_webring_callback', 'tinylytics-wp', 'tinylytics_wp_options_section');
    add_settings_field('webring_label', __( 'Webring label','tinylytics-wp' ), 'tinylytics_wp_webring_label_callback', 'tinylytics-wp', 'tinylytics_wp_options_section');
    add_settings_field('display_avatars', __( 'Display webring avatars?','tinylytics-wp' ), 'tinylytics_wp_display_avatars_callback', 'tinylytics-wp', 'tinylytics_wp_options_section');
    add_settings_field('display_flags', __( 'Display country flags?','tinylytics-wp' ), 'tinylytics_wp_display_flags_callback', 'tinylytics-wp', 'tinylytics_wp_options_section');

}

// Sanitize options
function tinylytics_wp_sanitize_options($input) {

    $sanitized_input = array();

    if (isset($input['site_id'])) {
        $sanitized_input['site_id'] = sanitize_text_field($input['site_id']);
    }

    if (isset($input['kudos_label'])) {
        $sanitized_input['kudos_label'] = sanitize_text_field($input['kudos_label']);
    }
    
    if (isset($input['webring_label'])) {
        $sanitized_input['webring_label'] = sanitize_text_field($input['webring_label']);
    }

    $sanitized_input['display_hits'] = isset($input['display_hits']) ? true : false;
    $sanitized_input['display_stats'] = isset($input['display_stats']) ? true : false;
    $sanitized_input['display_uptime'] = isset($input['display_uptime']) ? true : false;
    $sanitized_input['display_kudos'] = isset($input['display_kudos']) ? true : false;
    $sanitized_input['display_webring'] = isset($input['display_webring']) ? true : false;
    $sanitized_input['display_avatars'] = isset($input['display_avatars']) ? true : false;
    $sanitized_input['display_flags'] = isset($input['display_flags']) ? true : false;

    return $sanitized_input;

}

// Section callbacks
function tinylytics_wp_general_section_callback() {

    echo '<p class="section-note">' . __( 'Your unique site id can be found on your','tinylytics-wp' ) . ' <a href="https://tinylytics.app" target="_blank">Tinylytics</a> '. __( 'site page','tinylytics-wp') .'.</p>';

}

function tinylytics_wp_options_section_callback() {

    echo '<p class="section-note">' . __( 'These settings enable the various tracking features of','tinylytics-wp' ) . ' <a href="https://tinylytics.app/docs" target="_blank">Tinylytics</a>.</p>';

}

// Site ID callback
function tinylytics_wp_site_id_callback() {

    $options = get_option('tinylytics_wp_settings');
    echo '<input type="text" id="site_id" size="40" name="tinylytics_wp_settings[site_id]" placeholder="' . __( 'Enter your Tinylytics unique site id...','tinylytics-wp' ) . '" value="' . esc_attr($options['site_id'] ?? '') . '" />';

}

// Kudos label callback
function tinylytics_wp_kudos_label_callback() {

    $options = get_option('tinylytics_wp_settings');
    echo '<input type="text" id="kudos_label" size="40" name="tinylytics_wp_settings[kudos_label]" placeholder="' . __( 'Enter any combination of text or emoji 👋','tinylytics-wp' ) . '" value="' . esc_attr($options['kudos_label'] ?? '') . '" />';

}

// Webring label callback
function tinylytics_wp_webring_label_callback() {

    $options = get_option('tinylytics_wp_settings');
    echo '<input type="text" id="webring_label" size="40" name="tinylytics_wp_settings[webring_label]" placeholder="' . __( 'Enter any combination of text or emoji 🕸️💍','tinylytics-wp' ) . '" value="' . esc_attr($options['webring_label'] ?? '') . '" />';

}

// Display Hits callback
function tinylytics_wp_display_hits_callback() {

    $options = get_option('tinylytics_wp_settings');
    echo '<input type="checkbox" id="display_hits" name="tinylytics_wp_settings[display_hits]" ' . checked(true, $options['display_hits'] ?? false, false) . ' />';

}

// Display Stats callback
function tinylytics_wp_display_stats_callback() {

    $options = get_option('tinylytics_wp_settings');
    echo '<input type="checkbox" id="display_stats" name="tinylytics_wp_settings[display_stats]" ' . checked(true, $options['display_stats'] ?? false, false) . ' />';

}

// Display Uptime callback
function tinylytics_wp_display_uptime_callback() {

    $options = get_option('tinylytics_wp_settings');
    echo '<input type="checkbox" id="display_uptime" name="tinylytics_wp_settings[display_uptime]" ' . checked(true, $options['display_uptime'] ?? false, false) . ' />';

}

// Display Kudos callback
function tinylytics_wp_display_kudos_callback() {

    $options = get_option('tinylytics_wp_settings');
    echo '<input type="checkbox" id="display_kudos" name="tinylytics_wp_settings[display_kudos]" ' . checked(true, $options['display_kudos'] ?? false, false) . ' />';

}

// Display Webring callback
function tinylytics_wp_display_webring_callback() {

    $options = get_option('tinylytics_wp_settings');
    echo '<input type="checkbox" id="display_webring" name="tinylytics_wp_settings[display_webring]" ' . checked(true, $options['display_webring'] ?? false, false) . ' />';

}

// Display Avatars callback
function tinylytics_wp_display_avatars_callback() {

    $options = get_option('tinylytics_wp_settings');
    echo '<input type="checkbox" id="display_avatars" name="tinylytics_wp_settings[display_avatars]" ' . checked(true, $options['display_avatars'] ?? false, false) . ' />';

}

// Display Flags callback
function tinylytics_wp_display_flags_callback() {

    $options = get_option('tinylytics_wp_settings');
    echo '<input type="checkbox" id="display_flags" name="tinylytics_wp_settings[display_flags]" ' . checked(true, $options['display_flags'] ?? false, false) . ' />';

}

// Add menu page with custom icon
function tinylytics_wp_add_menu_page() {
    
    add_menu_page('Tinylytics', 'Tinylytics', 'manage_options', 'tinylytics-wp', 'tinylytics_wp_settings_page', 'dashicons-chart-bar');

}

// Settings page callback
function tinylytics_wp_settings_page() {

    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    if ( isset( $_GET['settings-updated'] ) ) {
		// add settings saved message with the class of "updated"
		add_settings_error( 'tinylytics_wp_messages', 'tinylytics_wp_message', __( 'Settings Saved', 'tinylytics-wp' ), 'updated' );
	}

    settings_errors( 'tinylytics_wp_messages' );

    $default_tab = null;
    $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;

    ?>
    <div class="wrap">
        <h1>Tinylytics</h1>

        <nav class="nav-tab-wrapper">
            <a href="?page=tinylytics-wp" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>"><?php _e('General Settings','tinylytics-wp'); ?></a>
            <a href="?page=tinylytics-wp&tab=shortcode" class="nav-tab <?php if($tab==='shortcode'):?>nav-tab-active<?php endif; ?>"><?php _e('Shortcodes','tinylytics-wp'); ?></a>
        </nav>
        <div class="tab-content">
            <div>
            <?php switch($tab) :
                case 'shortcode':
                    include plugin_dir_path( __FILE__ ) . '/inc/admin-shortcodes.php';
                    break;
                default:
                    include plugin_dir_path( __FILE__ ) . '/inc/admin-settings.php';
                    break;
            endswitch; ?>
            <hr />
            <?php include plugin_dir_path( __FILE__ ) . '/inc/admin-support.php'; ?>
            </div>
        </div>
    </div>
    <?php
}

function tinylytics_wp_output_script() {

    $options = get_option('tinylytics_wp_settings');

    $site_id = esc_attr($options['site_id'] ?? '');
    $hits = $options['display_hits'];
    $stats = $options['display_stats'];
    $uptime = $options['display_uptime'];
    $kudos = $options['display_kudos'];
    $kudos_label = esc_attr($options['kudos_label'] ?? '');
    $webring = $options['display_webring'];
    $webring_label = esc_attr($options['webring_label'] ?? '');
    $avatars = $options['display_avatars'];
	$flags = $options['display_flags'];
	
    if (!empty($site_id)) {
        $script_url = "https://tinylytics.app/embed/{$site_id}.js?";
        $script_url .= $hits ? 'hits&' : '';
        $script_url .= $stats ? 'publicstats&' : '';
        $script_url .= $uptime ? 'uptime&' : '';
        $script_url .= $kudos && !$kudos_label ? 'kudos&' : '';
        $script_url .= $kudos && $kudos_label ? 'kudos=' . $kudos_label . '&' : '';
        $script_url .= $webring && !$avatars ? 'webring&' : '';
        $script_url .= $webring && $avatars ? 'webring=avatars&' : '';
        $script_url .= $flags ? 'countries&' : '';
        $script_url = rtrim($script_url, '&?');
        
        echo '<script defer="defer" src="' . esc_url($script_url) . '"></script>' . PHP_EOL;
    }

}
add_action('wp_footer', 'tinylytics_wp_output_script');

// *** Enqueue user scripts
function tinylytics_wp_user_scripts() {
	$plugin_url = plugin_dir_url( __FILE__ );
	wp_enqueue_style( 'style',  $plugin_url . "/css/style.css");
}
add_action( 'admin_print_styles', 'tinylytics_wp_user_scripts' );


// *** Add a settings link to the plugin overview page for easy access
function tinylytics_wp_settings_link( $links ) {

	$url = esc_url( add_query_arg(
		'page',
		'tinylytics-wp',
		get_admin_url() . 'admin.php'
	) );
	
    $settings_link = '<a href="'. $url .'">' . __( 'Settings', 'tinylytics-wp' ) . '</a>';
	
    array_push(
		$links,
		$settings_link
	);
	return $links;
}
add_filter( 'plugin_action_links_tinylytics/tinylytics.php', 'tinylytics_wp_settings_link' );


function load_i18n() {
			
    $domain = 'tinylytics-wp';
    $locale = apply_filters('tinylytics_locale', get_locale(), $domain);
    $dir    = trailingslashit(WP_LANG_DIR);
    $file   = $domain .'-'. $locale .'.mo';
    $path_1 = $dir . $file;
    $path_2 = $dir . $domain .'/'. $file;
    $path_3 = $dir .'plugins/'. $file;
    $path_4 = $dir .'plugins/'. $domain .'/'. $file;
    $paths = array($path_1, $path_2, $path_3, $path_4);
    
    foreach ($paths as $path) {
        if ($loaded = load_textdomain($domain, $path)) {
            return $loaded;
        } else {
            return load_plugin_textdomain($domain, false, dirname(plugin_basename(__FILE__)) .'/languages/');
        }
    }

}


// *** Wordpress shortcodes to use in posts and pages
include plugin_dir_path( __FILE__ ) . '/inc/user-shortcodes.php';