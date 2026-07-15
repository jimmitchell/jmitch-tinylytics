<?php
/**
 * Plugin Name: Tinylytics
 * Plugin URI: https://jimmitchell.org/tinylytics-wp-plugin/
 * Description: A simple plugin to embed a <a href="https://tinylytics.app">Tinylytics</a> tracking script to your site.
 * Tags: analytics, ga, google, google analytics, tracking, statistics, stats, hits
 * Author: Jim Mitchell
 * Author URI: https://jimmitchell.org
 * Donate link: https://donate.stripe.com/9AQ8Ab6Yr8Y67cYdQR
 * Requires at least: 6.3
 * Tested up to: 7.0
 * Version: 1.2.0
 * Requires PHP: 7.4
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

define( 'TINYLYTICS__VERSION', '1.2.0' );

// Hook functions into WordPress
add_action( 'admin_init',   'jmitch_tinylytics_register_settings' );
add_action( 'admin_menu',   'jmitch_tinylytics_add_menu_page' );

// The plugin's settings fields, keyed by option name
function jmitch_tinylytics_get_fields() {

    return array(
        'site_id' => array(
            'type'        => 'text',
            'section'     => 'jmitch_tinylytics_general_section',
            'label'       => __( 'Site ID', 'jmitch-tinylytics' ),
            'placeholder' => __( 'Enter your Tinylytics unique site id...', 'jmitch-tinylytics' ),
        ),
        'ignore_hits' => array(
            'type'    => 'checkbox',
            'section' => 'jmitch_tinylytics_options_section',
            'label'   => __( 'Ignore admin hits?', 'jmitch-tinylytics' ),
        ),
        'display_hits' => array(
            'type'    => 'checkbox',
            'section' => 'jmitch_tinylytics_options_section',
            'label'   => __( 'Display visitor hits?', 'jmitch-tinylytics' ),
        ),
        'display_stats' => array(
            'type'    => 'checkbox',
            'section' => 'jmitch_tinylytics_options_section',
            'label'   => __( 'Link to your public stats?', 'jmitch-tinylytics' ),
        ),
        'stats_label' => array(
            'type'        => 'text',
            'section'     => 'jmitch_tinylytics_options_section',
            'label'       => __( 'Public stats label', 'jmitch-tinylytics' ),
            'placeholder' => __( 'Add a custom public stats label', 'jmitch-tinylytics' ),
        ),
        'display_uptime' => array(
            'type'    => 'checkbox',
            'section' => 'jmitch_tinylytics_options_section',
            'label'   => __( 'Display uptime?', 'jmitch-tinylytics' ),
        ),
        'display_kudos' => array(
            'type'    => 'checkbox',
            'section' => 'jmitch_tinylytics_options_section',
            'label'   => __( 'Display Kudos?', 'jmitch-tinylytics' ),
        ),
        'kudos_label' => array(
            'type'        => 'text',
            'section'     => 'jmitch_tinylytics_options_section',
            'label'       => __( 'Kudos label', 'jmitch-tinylytics' ),
            'placeholder' => __( 'Enter any combination of text or emoji 👋', 'jmitch-tinylytics' ),
        ),
        'display_webring' => array(
            'type'    => 'checkbox',
            'section' => 'jmitch_tinylytics_options_section',
            'label'   => __( 'Display webring?', 'jmitch-tinylytics' ),
        ),
        'webring_label' => array(
            'type'        => 'text',
            'section'     => 'jmitch_tinylytics_options_section',
            'label'       => __( 'Webring label', 'jmitch-tinylytics' ),
            'placeholder' => __( 'Enter any combination of text or emoji 🕸️💍', 'jmitch-tinylytics' ),
        ),
        'display_avatars' => array(
            'type'    => 'checkbox',
            'section' => 'jmitch_tinylytics_options_section',
            'label'   => __( 'Display webring avatars?', 'jmitch-tinylytics' ),
        ),
        'display_flags' => array(
            'type'    => 'checkbox',
            'section' => 'jmitch_tinylytics_options_section',
            'label'   => __( 'Display country flags?', 'jmitch-tinylytics' ),
        ),
    );

}

// Register the settings
function jmitch_tinylytics_register_settings() {

    register_setting(
        'jmitch_tinylytics_settings_group',
        'jmitch_tinylytics_settings',
        array( 'sanitize_callback' => 'jmitch_tinylytics_sanitize_options' )
    );

    add_settings_section( 'jmitch_tinylytics_general_section', esc_html__( 'General Settings','jmitch-tinylytics' ), 'jmitch_tinylytics_general_section_callback', 'jmitch-tinylytics' );
    add_settings_section( 'jmitch_tinylytics_options_section', esc_html__( 'Tinylytics Options','jmitch-tinylytics' ), 'jmitch_tinylytics_options_section_callback', 'jmitch-tinylytics' );

    foreach ( jmitch_tinylytics_get_fields() as $key => $field ) {
        add_settings_field(
            $key,
            esc_html( $field['label'] ),
            'text' === $field['type'] ? 'jmitch_tinylytics_render_text_field' : 'jmitch_tinylytics_render_checkbox',
            'jmitch-tinylytics',
            $field['section'],
            array(
                'label_for'   => $key,
                'placeholder' => $field['placeholder'] ?? '',
            )
        );
    }

}

// Sanitize options
function jmitch_tinylytics_sanitize_options( $input ) {

    $sanitized_input = array();

    foreach ( jmitch_tinylytics_get_fields() as $key => $field ) {
        if ( 'text' === $field['type'] ) {
            $sanitized_input[ $key ] = sanitize_text_field( $input[ $key ] ?? '' );
        } else {
            $sanitized_input[ $key ] = isset( $input[ $key ] );
        }
    }

    return $sanitized_input;

}

// Section callbacks
function jmitch_tinylytics_general_section_callback() {

    printf(
        '<p class="section-note">%s</p>',
        sprintf(
            /* translators: %s: link to the Tinylytics website */
            esc_html__( 'Your unique site id can be found on your %s site page.', 'jmitch-tinylytics' ),
            '<a href="https://tinylytics.app" target="_blank">Tinylytics</a>'
        )
    );

}

function jmitch_tinylytics_options_section_callback() {

    printf(
        '<p class="section-note">%s</p>',
        sprintf(
            /* translators: %s: link to the Tinylytics documentation */
            esc_html__( 'These settings enable the various tracking features of %s.', 'jmitch-tinylytics' ),
            '<a href="https://tinylytics.app/docs" target="_blank">Tinylytics</a>'
        )
    );

}

// Field callbacks
function jmitch_tinylytics_render_text_field( $args ) {

    $options = get_option( 'jmitch_tinylytics_settings' );
    printf(
        '<input type="text" id="%1$s" size="50" name="jmitch_tinylytics_settings[%1$s]" placeholder="%2$s" value="%3$s" />',
        esc_attr( $args['label_for'] ),
        esc_attr( $args['placeholder'] ),
        esc_attr( $options[ $args['label_for'] ] ?? '' )
    );

}

function jmitch_tinylytics_render_checkbox( $args ) {

    $options = get_option( 'jmitch_tinylytics_settings' );
    printf(
        '<input type="checkbox" id="%1$s" name="jmitch_tinylytics_settings[%1$s]" %2$s />',
        esc_attr( $args['label_for'] ),
        checked( true, ! empty( $options[ $args['label_for'] ] ), false )
    );

}

// Add menu page with custom icon
function jmitch_tinylytics_add_menu_page() {

    $hook = add_menu_page( 'Tinylytics', 'Tinylytics', 'manage_options', 'jmitch-tinylytics', 'jmitch_tinylytics_settings_page', 'dashicons-chart-bar', 89 );

    // Load the admin stylesheet only on the plugin's own settings page
    add_action( 'admin_print_styles-' . $hook, 'jmitch_tinylytics_admin_styles' );

}

function jmitch_tinylytics_admin_styles() {

    wp_enqueue_style( 'jmitch-tinylytics-admin', plugin_dir_url( __FILE__ ) . 'css/style.css', array(), TINYLYTICS__VERSION, 'all' );

}

// Settings page callback
function jmitch_tinylytics_settings_page() {

    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    if ( isset( $_GET['settings-updated'] ) ) { // phpcs:ignore
		// add settings saved message with the class of "updated"
		add_settings_error( 'jmitch_tinylytics_messages', 'jmitch_tinylytics_message', esc_html__( 'Settings Saved', 'jmitch-tinylytics' ), 'updated' );
	}

    settings_errors( 'jmitch_tinylytics_messages' );

    $default_tab = null;
    $tab = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : $default_tab; // phpcs:ignore

    ?>
    <div class="wrap">
        <h1>Tinylytics</h1>

        <?php
        $settings_url  = admin_url( 'admin.php?page=jmitch-tinylytics' );
        $shortcode_url = add_query_arg( 'tab', 'shortcode', $settings_url );
        ?>
        <nav class="nav-tab-wrapper">
            <a href="<?php echo esc_url( $settings_url ); ?>" class="nav-tab <?php if($tab === null):?>nav-tab-active<?php endif; ?>"><?php esc_html_e( 'General Settings', 'jmitch-tinylytics' ); ?></a>
            <a href="<?php echo esc_url( $shortcode_url ); ?>" class="nav-tab <?php if($tab === 'shortcode'):?>nav-tab-active<?php endif; ?>"><?php esc_html_e( 'Shortcodes', 'jmitch-tinylytics' ); ?></a>
        </nav>
        <div class="tab-content">
            <div class="admin-left">
            <?php switch( $tab ) :
                case 'shortcode':
                    include plugin_dir_path( __FILE__ ) . 'inc/admin-shortcodes.php';
                    break;
                default:
                    include plugin_dir_path( __FILE__ ) . 'inc/admin-settings.php';
                    break;
            endswitch; ?>
            </div>
            <div class="admin-right">
            <?php include plugin_dir_path( __FILE__ ) . 'inc/admin-support.php'; ?>
            </div>
        </div>
    </div>
    <?php
}

function jmitch_tinylytics_output_script() {

    $options = get_option( 'jmitch_tinylytics_settings' );

    if ( ! empty( $options['site_id'] ) ) {

        $ignore = ! empty( $options['ignore_hits'] ) && current_user_can( 'manage_options' );

        $site_id = rawurlencode( $options['site_id'] );
        $hits = ! empty( $options['display_hits'] );
        $stats = ! empty( $options['display_stats'] );
        $uptime = ! empty( $options['display_uptime'] );
        $kudos = ! empty( $options['display_kudos'] );
        $kudos_label = $options['kudos_label'] ?? '';
        $webring = ! empty( $options['display_webring'] );
        $avatars = ! empty( $options['display_avatars'] );
        $flags = ! empty( $options['display_flags'] );

        $script_url = "https://tinylytics.app/embed/{$site_id}.js?";
        $script_url .= $ignore ? 'ignore&' : '';
        $script_url .= $hits ? 'hits&' : '';
        $script_url .= $stats ? 'publicstats&' : '';
        $script_url .= $uptime ? 'uptime&' : '';
        $script_url .= $kudos && !$kudos_label ? 'kudos&' : '';
        $script_url .= $kudos && $kudos_label ? 'kudos=' . rawurlencode( $kudos_label ) . '&' : '';
        $script_url .= $webring && !$avatars ? 'webring&' : '';
        $script_url .= $webring && $avatars ? 'webring=avatars&' : '';
        $script_url .= $flags ? 'countries&' : '';
        $script_url = rtrim( $script_url, '&?' );

        wp_enqueue_script(
            'jmitch-tinylytics',
            esc_url_raw( $script_url ),
            array(),
            null, // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- remote third-party script; a version query arg cannot bust Tinylytics' cache and pollutes their URL
            array(
                'strategy'  => 'defer',
                'in_footer' => true
            ),
        );
    }
}
add_action( 'wp_enqueue_scripts', 'jmitch_tinylytics_output_script' );


// *** Add a settings link to the plugin overview page for easy access
function jmitch_tinylytics_settings_link( $links ) {

	$url = esc_url( admin_url( 'admin.php?page=jmitch-tinylytics' ) );

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


// *** WordPress shortcodes to use in posts and pages
include plugin_dir_path( __FILE__ ) . 'inc/user-shortcodes.php';
