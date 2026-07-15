<?php

/*
 *
 * Shortcode options for Tinylytics
 * Since version 1.0.0
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// *** Kudos shortcode
function jmitch_tinylytics_kudos_function() {
	$output = '';
	$options = get_option( 'jmitch_tinylytics_settings' );
	$kudos = ! empty( $options['display_kudos'] );
	if ( $kudos ) {
		$output = '<button class="tinylytics_kudos" data-path="'. wp_make_link_relative( get_permalink() ) .'"></button>';
	}
	return $output;
}
add_shortcode( 'tinykudos', 'jmitch_tinylytics_kudos_function' );

// *** Hits shortcode
function jmitch_tinylytics_hits_function() {
	$output = '';
	$options = get_option( 'jmitch_tinylytics_settings' );
	$hits = ! empty( $options['display_hits'] );
	if ( $hits ) {
		$output = '<span class="tinylytics_hits" data-path="'. wp_make_link_relative( get_permalink() ) .'"></span>';
	}
	return $output;
}
add_shortcode( 'tinyhits', 'jmitch_tinylytics_hits_function' );

// *** Web ring shortcode
function jmitch_tinylytics_webring_function() {
	$output = '';
	$options = get_option( 'jmitch_tinylytics_settings' );
	$webring = ! empty( $options['display_webring'] );
	$webring_label = $options['webring_label'] ?? '';
	$avatars = ! empty( $options['display_avatars'] );
	if ( $webring ) {
		$show_avatar = $avatars ? '<img class="tinylytics_webring_avatar" src="" style="display: none"/>' : '';
		if ( $webring_label === '' ) {
			$output = '<span class="tiny_webring"><a href="" class="tinylytics_webring" target="_blank" title="Tinylytics '. esc_html__( 'Web Ring', 'jmitch-tinylytics' ) . '">🕸️' . $show_avatar . '💍</a></span>';
		} else {
			$output = '<span class="tiny_webring"><a href="" class="tinylytics_webring" target="_blank" title="Tinylytics '. esc_html__( 'Web Ring', 'jmitch-tinylytics' ) . '">'. $show_avatar . esc_html( $webring_label ) . '</a></span>';
		}
	}
	return $output;
}
add_shortcode( 'tinywebring', 'jmitch_tinylytics_webring_function' );

// *** Country flags shortcode
function jmitch_tinylytics_flags_function() {
	$output = '';
	$options = get_option( 'jmitch_tinylytics_settings' );
	$flags = ! empty( $options['display_flags'] );
	if ( $flags ) {
		$output = '<p><span class="tinylytics_countries"></span></p>';
	}
	return $output;
}
add_shortcode( 'tinyflags', 'jmitch_tinylytics_flags_function' );

// *** Stats shortcode
function jmitch_tinylytics_stats_function() {
	$output = '';
	$options = get_option( 'jmitch_tinylytics_settings' );
	$stats = ! empty( $options['display_stats'] );
	$stats_label = $options['stats_label'] ?? '';
	$hits = ! empty( $options['display_hits'] );
	$uptime = ! empty( $options['display_uptime'] );
	if ( $stats && $hits ) {
		if ( $stats_label === '' ) {
			$stats_label = esc_html__( 'My Stats', 'jmitch-tinylytics' );
		}
		$output .= '<span class="tiny_counter"><a href="" target="_blank" class="tinylytics_public_stats">' . esc_html( $stats_label ) . '</a>: <span class="tinylytics_hits"></span></span>';
	}
	else if ( $hits ) {
		$output .= '<span class="tiny_counter"><a href="https://tinylytics.app">Tinylytics</a>: <span class="tinylytics_hits"></span></span>';
	}
	if ( $uptime ) {
		$output .= ' <span class="tiny_uptime">Uptime: <span class="tinylytics_uptime"></span></span>';
	}
	return $output;
}
add_shortcode( 'tinystats', 'jmitch_tinylytics_stats_function' );

?>