<?php
/**
 * Plugin Name: Tinylytics
 * Plugin URI: https://jimmitchell.org/tinylytics-wp-plugin/
 * Description: A simple plugin to embed a <a href="https://tinylytics.app">Tinylytics</a> tracking script to your site.
 * Tags: analytics, ga, google, google analytics, tracking, statistics, stats, hits
 * Author: Jim Mitchell
 * Author URI: https://jimmitchell.org
 * Donate link: https://donate.stripe.com/9AQ8Ab6Yr8Y67cYdQR
 * Requires at least: 4.6
 * Test up to: 6.6.1
 * Version: 1.1.3
 * Requires PHP: 5.6.20
 * Text Domain: jmitch-tinylytics
 * Domain Path: /languages
 * License: GPL-2.0-or-later
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
	
	Copyright 2024 Jim Mitchell Media. All rights reserved.
*/

if ( ! defined( 'ABSPATH' )) die();

define( 'TINYLYTICS__VERSION', '1.1.2' );

// Hook functions into WordPress
add_action( 'init',         'jmitch_tinylytics_start_session', 1 );
add_action( 'init',         'jmitch_tinylytics_load_i18n' );
add_action( 'admin_init',   'jmitch_tinylytics_register_settings' );
add_action( 'admin_menu',   'jmitch_tinylytics_add_menu_page' );
add_action( 'wp_logout',    'jmitch_tinylytics_end_session' );
add_action( 'wp_login',     'jmitch_tinylytics_end_session' );

// Register the settings
function jmitch_tinylytics_register_settings() {

    register_setting( 'jmitch_tinylytics_settings_group', 'jmitch_tinylytics_settings', 'jmitch_tinylytics_sanitize_options' );
    
    add_settings_section( 'jmitch_tinylytics_general_section', esc_html__( 'General Settings','jmitch-tinylytics' ), 'jmitch_tinylytics_general_section_callback', 'jmitch-tinylytics' );
    add_settings_section( 'jmitch_tinylytics_options_section', esc_html__( 'Tinylytics Options','jmitch-tinylytics' ), 'jmitch_tinylytics_options_section_callback', 'jmitch-tinylytics' );
    
    add_settings_field( 'site_id', esc_html__( 'Site ID','jmitch-tinylytics' ), 'jmitch_tinylytics_site_id_callback', 'jmitch-tinylytics', 'jmitch_tinylytics_general_section' );
    add_settings_field( 'ignore_hits', esc_html__( 'Ignore admin hits?','jmitch-tinylytics' ), 'jmitch_tinylytics_ignore_hits_callback', 'jmitch-tinylytics', 'jmitch_tinylytics_options_section' );
    add_settings_field( 'display_hits', esc_html__( 'Display visitor hits?','jmitch-tinylytics' ), 'jmitch_tinylytics_display_hits_callback', 'jmitch-tinylytics', 'jmitch_tinylytics_options_section' );
    add_settings_field( 'display_stats', esc_html__( 'Link to your public stats?','jmitch-tinylytics' ), 'jmitch_tinylytics_display_stats_callback', 'jmitch-tinylytics', 'jmitch_tinylytics_options_section' );
    add_settings_field( 'stats_label', esc_html__( 'Public stats label','jmitch-tinylytics' ), 'jmitch_tinylytics_stats_label_callback', 'jmitch-tinylytics', 'jmitch_tinylytics_options_section' );
    add_settings_field( 'display_uptime', esc_html__( 'Display uptime?','jmitch-tinylytics' ), 'jmitch_tinylytics_display_uptime_callback', 'jmitch-tinylytics', 'jmitch_tinylytics_options_section' );
    add_settings_field( 'display_kudos', esc_html__( 'Display Kudos?','jmitch-tinylytics' ), 'jmitch_tinylytics_display_kudos_callback', 'jmitch-tinylytics', 'jmitch_tinylytics_options_section' );
    add_settings_field( 'kudos_label', esc_html__( 'Kudos label','jmitch-tinylytics' ), 'jmitch_tinylytics_kudos_label_callback', 'jmitch-tinylytics', 'jmitch_tinylytics_options_section' );
    add_settings_field( 'display_webring', esc_html__( 'Display webring?','jmitch-tinylytics' ), 'jmitch_tinylytics_display_webring_callback', 'jmitch-tinylytics', 'jmitch_tinylytics_options_section' );
    add_settings_field( 'webring_label', esc_html__( 'Webring label','jmitch-tinylytics' ), 'jmitch_tinylytics_webring_label_callback', 'jmitch-tinylytics', 'jmitch_tinylytics_options_section' );
    add_settings_field( 'display_avatars', esc_html__( 'Display webring avatars?','jmitch-tinylytics' ), 'jmitch_tinylytics_display_avatars_callback', 'jmitch-tinylytics', 'jmitch_tinylytics_options_section' );
    add_settings_field( 'display_flags', esc_html__( 'Display country flags?','jmitch-tinylytics' ), 'jmitch_tinylytics_display_flags_callback', 'jmitch-tinylytics', 'jmitch_tinylytics_options_section' );

}

// Sanitize options
function jmitch_tinylytics_sanitize_options($input) {

    $sanitized_input = array();

    if ( isset( $input['site_id'] ) ) {
        $sanitized_input['site_id']         = sanitize_text_field( $input['site_id'] );
    }

    if ( isset( $input['stats_label'] ) ) {
        $sanitized_input['stats_label']     = sanitize_text_field( $input['stats_label'] );
    }
    
    if ( isset( $input['kudos_label'] ) ) {
        $sanitized_input['kudos_label']     = sanitize_text_field( $input['kudos_label'] );
    }
    
    if ( isset( $input['webring_label'] ) ) {
        $sanitized_input['webring_label']   = sanitize_text_field( $input['webring_label'] );
    }

    $sanitized_input['ignore_hits']         = isset( $input['ignore_hits'] ) ? true : false;
    $sanitized_input['display_hits']        = isset( $input['display_hits'] ) ? true : false;
    $sanitized_input['display_stats']       = isset( $input['display_stats'] ) ? true : false;
    $sanitized_input['display_uptime']      = isset( $input['display_uptime'] ) ? true : false;
    $sanitized_input['display_kudos']       = isset( $input['display_kudos'] ) ? true : false;
    $sanitized_input['display_webring']     = isset( $input['display_webring'] ) ? true : false;
    $sanitized_input['display_avatars']     = isset( $input['display_avatars'] ) ? true : false;
    $sanitized_input['display_flags']       = isset( $input['display_flags'] ) ? true : false;

    return $sanitized_input;

}

// Section callbacks
function jmitch_tinylytics_general_section_callback() {

    echo '<p class="section-note">' . esc_html__( 'Your unique site id can be found on your','jmitch-tinylytics' ) . ' <a href="https://tinylytics.app" target="_blank">Tinylytics</a> '. esc_html__( 'site page','jmitch-tinylytics') .'.</p>';

}

function jmitch_tinylytics_options_section_callback() {

    echo '<p class="section-note">' . esc_html__( 'These settings enable the various tracking features of','jmitch-tinylytics' ) . ' <a href="https://tinylytics.app/docs" target="_blank">Tinylytics</a>.</p>';

}

// Site ID callback
function jmitch_tinylytics_site_id_callback() {

    $options = get_option( 'jmitch_tinylytics_settings' );
    echo '<input type="text" id="site_id" size="50" name="jmitch_tinylytics_settings[site_id]" placeholder="' . esc_html__( 'Enter your Tinylytics unique site id...','jmitch-tinylytics' ) . '" value="' . esc_attr( $options['site_id'] ?? '' ) . '" />';

}

// Public stats label callback
function jmitch_tinylytics_stats_label_callback() {

    $options = get_option( 'jmitch_tinylytics_settings' );
    echo '<input type="text" id="stats_label" size="50" name="jmitch_tinylytics_settings[stats_label]" placeholder="' . esc_html__( 'Add a custom public stats label','jmitch-tinylytics' ) . '" value="' . esc_attr( $options['stats_label'] ?? '' ) . '" />';

}

// Kudos label callback
function jmitch_tinylytics_kudos_label_callback() {

    $options = get_option( 'jmitch_tinylytics_settings' );
    echo '<input type="text" id="kudos_label" size="50" name="jmitch_tinylytics_settings[kudos_label]" placeholder="' . esc_html__( 'Enter any combination of text or emoji 👋','jmitch-tinylytics' ) . '" value="' . esc_attr( $options['kudos_label'] ?? '' ) . '" />';

}

// Webring label callback
function jmitch_tinylytics_webring_label_callback() {

    $options = get_option( 'jmitch_tinylytics_settings' );
    echo '<input type="text" id="webring_label" size="50" name="jmitch_tinylytics_settings[webring_label]" placeholder="' . esc_html__( 'Enter any combination of text or emoji 🕸️💍','jmitch-tinylytics' ) . '" value="' . esc_attr( $options['webring_label'] ?? '' ) . '" />';

}

// Ignore Hits callback
function jmitch_tinylytics_ignore_hits_callback() {

    $options = get_option( 'jmitch_tinylytics_settings' );
    echo '<input type="checkbox" id="ignore_hits" name="jmitch_tinylytics_settings[ignore_hits]" ' . checked( true, $options['ignore_hits'] ?? false, false ) . ' />';

}

// Display Hits callback
function jmitch_tinylytics_display_hits_callback() {

    $options = get_option( 'jmitch_tinylytics_settings' );
    echo '<input type="checkbox" id="display_hits" name="jmitch_tinylytics_settings[display_hits]" ' . checked( true, $options['display_hits'] ?? false, false ) . ' />';

}

// Display Stats callback
function jmitch_tinylytics_display_stats_callback() {

    $options = get_option( 'jmitch_tinylytics_settings' );
    echo '<input type="checkbox" id="display_stats" name="jmitch_tinylytics_settings[display_stats]" ' . checked( true, $options['display_stats'] ?? false, false ) . ' />';

}

// Display Uptime callback
function jmitch_tinylytics_display_uptime_callback() {

    $options = get_option( 'jmitch_tinylytics_settings' );
    echo '<input type="checkbox" id="display_uptime" name="jmitch_tinylytics_settings[display_uptime]" ' . checked( true, $options['display_uptime'] ?? false, false ) . ' />';

}

// Display Kudos callback
function jmitch_tinylytics_display_kudos_callback() {

    $options = get_option( 'jmitch_tinylytics_settings' );
    echo '<input type="checkbox" id="display_kudos" name="jmitch_tinylytics_settings[display_kudos]" ' . checked( true, $options['display_kudos'] ?? false, false ) . ' />';

}

// Display Webring callback
function jmitch_tinylytics_display_webring_callback() {

    $options = get_option( 'jmitch_tinylytics_settings' );
    echo '<input type="checkbox" id="display_webring" name="jmitch_tinylytics_settings[display_webring]" ' . checked( true, $options['display_webring'] ?? false, false ) . ' />';

}

// Display Avatars callback
function jmitch_tinylytics_display_avatars_callback() {

    $options = get_option( 'jmitch_tinylytics_settings' );
    echo '<input type="checkbox" id="display_avatars" name="jmitch_tinylytics_settings[display_avatars]" ' . checked( true, $options['display_avatars'] ?? false, false ) . ' />';

}

// Display Flags callback
function jmitch_tinylytics_display_flags_callback() {

    $options = get_option( 'jmitch_tinylytics_settings' );
    echo '<input type="checkbox" id="display_flags" name="jmitch_tinylytics_settings[display_flags]" ' . checked( true, $options['display_flags'] ?? false, false ) . ' />';

}

// Add menu page with custom icon
function jmitch_tinylytics_add_menu_page() {
    
    add_menu_page( 'Tinylytics', 'Tinylytics', 'manage_options', 'jmitch-tinylytics', 'jmitch_tinylytics_settings_page', 'dashicons-chart-bar', 89 );

}

// Settings page callback
function jmitch_tinylytics_settings_page() {

    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    if ( isset( $_GET['settings-updated'] ) ) {
		// add settings saved message with the class of "updated"
		add_settings_error( 'jmitch_tinylytics_messages', 'jmitch_tinylytics_message', esc_html__( 'Settings Saved', 'jmitch-tinylytics' ), 'updated' );
	}

    settings_errors( 'jmitch_tinylytics_messages' );

    $default_tab = null;
    $tab = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : $default_tab;

    ?>
    <div class="wrap">
        <h1>Tinylytics <?php esc_html_e( 'for','jmitch-tinylytics' ); ?> WordPress</h1>

        <nav class="nav-tab-wrapper">
            <a href="?page=jmitch-tinylytics" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>"><?php esc_html_e( 'General Settings', 'jmitch-tinylytics' ); ?></a>
            <a href="?page=jmitch-tinylytics&tab=shortcode" class="nav-tab <?php if($tab==='shortcode'):?>nav-tab-active<?php endif; ?>"><?php esc_html_e( 'Shortcodes', 'jmitch-tinylytics' ); ?></a>
        </nav>
        <div class="tab-content">
            <div class="admin-left">
            <?php switch( $tab ) :
                case 'shortcode':
                    include plugin_dir_path( __FILE__ ) . '/inc/admin-shortcodes.php';
                    break;
                default:
                    include plugin_dir_path( __FILE__ ) . '/inc/admin-settings.php';
                    break;
            endswitch; ?>
            </div>
            <div class="admin-right">
            <?php include plugin_dir_path( __FILE__ ) . '/inc/admin-support.php'; ?>
            </div>
        </div>
    </div>
    <?php
}

function jmitch_tinylytics_output_script() {

    $options = get_option( 'jmitch_tinylytics_settings' );

    $ignore = false;
    if( isset( $_SESSION['isAdmin'] ) && $options['ignore_hits'] == true ) {
        $ignore = $_SESSION['isAdmin'];
    }
    
    if ( $options && esc_attr( $options['site_id'] ) != '' ) {

        $site_id = esc_attr( $options['site_id'] ?? '' );
        $hits = $options['display_hits'];
        $stats = $options['display_stats'];
        $uptime = $options['display_uptime'];
        $kudos = $options['display_kudos'];
        $kudos_label = esc_attr( $options['kudos_label'] ?? '' );
        $webring = $options['display_webring'];
        $webring_label = esc_attr( $options['webring_label'] ?? '' );
        $avatars = $options['display_avatars'];
        $flags = $options['display_flags'];
        
        $script_url = "https://tinylytics.app/embed/{$site_id}.js?";
        $script_url .= $ignore ? 'ignore&' : '';
        $script_url .= $hits ? 'hits&' : '';
        $script_url .= $stats ? 'publicstats&' : '';
        $script_url .= $uptime ? 'uptime&' : '';
        $script_url .= $kudos && !$kudos_label ? 'kudos&' : '';
        $script_url .= $kudos && $kudos_label ? 'kudos=' . $kudos_label . '&' : '';
        $script_url .= $webring && !$avatars ? 'webring&' : '';
        $script_url .= $webring && $avatars ? 'webring=avatars&' : '';
        $script_url .= $flags ? 'countries&' : '';
        $script_url = rtrim( $script_url, '&?' );
        
        wp_enqueue_script(
            'jmitch-tinylytics',
            esc_url_raw( $script_url ),
            array(),
            TINYLYTICS__VERSION,
            array(
                'strategy'  => 'defer',
                'in_footer' => true
            ),
        );
    }
}
add_action( 'wp_footer', 'jmitch_tinylytics_output_script' );


// *** Enqueue user scripts
function jmitch_tinylytics_user_scripts() {
	$plugin_url = plugin_dir_url( __FILE__ );
	wp_enqueue_style( 'style',  $plugin_url . "css/style.css", array(), TINYLYTICS__VERSION, 'all' );
}
add_action( 'admin_print_styles', 'jmitch_tinylytics_user_scripts' );


// *** Add a settings link to the plugin overview page for easy access
function jmitch_tinylytics_settings_link( $links ) {

	$url = esc_url( add_query_arg(
		'page',
		'jmitch-tinylytics',
		get_admin_url() . 'admin.php'
	) );
	
    $settings_link = '<a href="'. $url .'">' . esc_html__( 'Settings', 'jmitch-tinylytics' ) . '</a>';
    $donate_link = '<a href="https://donate.stripe.com/9AQ8Ab6Yr8Y67cYdQR" target="_blank">' . esc_html__( 'Donate', 'jmitch-tinylytics' ) . '</a>';
	
    array_push(
		$links,
		$settings_link,
        $donate_link
	);
	return $links;
}
add_filter( 'plugin_action_links_jmitch-tinylytics/jmitch-tinylytics.php', 'jmitch_tinylytics_settings_link' );


function jmitch_tinylytics_load_i18n() {
			
    $domain = 'jmitch-tinylytics';
    $locale = apply_filters( 'jmitch_tinylytics_locale', get_locale(), $domain );
    $dir    = trailingslashit( WP_LANG_DIR );
    $file   = $domain . '-' . $locale . '.mo';
    $path_1 = $dir . $file;
    $path_2 = $dir . $domain . '/' . $file;
    $path_3 = $dir . 'plugins/' . $file;
    $path_4 = $dir . 'plugins/' . $domain . '/' . $file;
    $paths = array( $path_1, $path_2, $path_3, $path_4 );
    
    foreach ( $paths as $path ) {
        if ( $loaded = load_textdomain( $domain, $path ) ) {
            return $loaded;
        } else {
            return load_plugin_textdomain( $domain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
        }
    }

}


// *** Session management
function jmitch_tinylytics_start_session() {
    
    if( !session_id() ) {
        session_start( ['read_and_close' => true,] );
    }
    if ( current_user_can( 'manage_options' ) ) {
        $_SESSION[ 'isAdmin' ] = true;
    }
    
}
function jmitch_tinylytics_end_session() {
    
    session_destroy();
    
}


// *** WordPress shortcodes to use in posts and pages
include plugin_dir_path( __FILE__ ) . '/inc/user-shortcodes.php';