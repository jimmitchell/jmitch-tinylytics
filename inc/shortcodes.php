<?php

/*
 *
 * Shortcode options for WP Tinylytics
 * Since version 1.0.2
 *
 */

// *** Kudos shortcode
function wp_tinylytics_kudos_function() {
	$options = get_option('wp_tinylytics_settings');
	$kudos = $options['display_kudos'];
	if ($kudos) {
		return '<button class="tinylytics_kudos" data-path="'. wp_make_link_relative(get_permalink()) .'"></button>';
	}
}
add_shortcode('tinykudos','wp_tinylytics_kudos_function');

// *** Hits shortcode
function wp_tinylytics_hits_function() {
	$options = get_option('wp_tinylytics_settings');
	$hits = $options['display_hits'];
	if ($hits) {
		return '<span class="tinylytics_hits" data-path="'. wp_make_link_relative(get_permalink()) .'"></span>';
	}
}
add_shortcode('tinyhits','wp_tinylytics_hits_function');

// *** Web ring shortcode
function wp_tinylytics_webring_function() {
	$options = get_option('wp_tinylytics_settings');
	$webring = $options['display_webring'];
	$webring_label = $options['webring_label'];
	$avatars = $options['display_avatars'];
	if ($webring) {
		$show_avatar = $avatars ? '<img class="tinylytics_webring_avatar" src="" style="display: none"/>' : '';
		if ($webring_label === '') {
			$output = '<span class="tiny_webring"><a href="" class="tinylytics_webring" target="_blank" title="Tinylytics Web Ring">🕸️' . $show_avatar . '💍</a></span>';
		} else {
			$output = '<span class="tiny_webring"><a href="" class="tinylytics_webring" target="_blank" title="Tinylytics Web Ring">'. $show_avatar . $webring_label . '</a></span>';
		}
	}
	return $output;
}
add_shortcode('tinywebring','wp_tinylytics_webring_function');

// *** Country flags shortcode
function wp_tinylytics_flags_function() {
	$options = get_option('wp_tinylytics_settings');
	$flags = $options['display_flags'];
	if ($flags) {
		return '<p><span class="tinylytics_countries"></span></p>';
	}
}
add_shortcode('tinyflags','wp_tinylytics_flags_function');

// *** Stats shortcode
function wp_tinylytics_stats_function() {
	$options = get_option('wp_tinylytics_settings');
	$stats = $options['display_stats'];
	$hits = $options['display_hits'];
	$uptime = $options['display_uptime'];
	$output = '';
	if ($stats && $hits) {
		$output .= '<span class="tiny_counter"><a href="" target="_blank" class="tinylytics_public_stats">My Stats</a>: <span class="tinylytics_hits"></span></span>';
	}
	else if ($hits) {
		$output .= '<span class="tiny_counter"><a href="https://tinylytics.app">Tinylytics</a>: <span class="tinylytics_hits"></span></span>';
	}
	if ($uptime) {
		$output .= ' <span class="tiny_uptime">Uptime: <span class="tinylytics_uptime"></span></span>';
	}
	return $output;
}
add_shortcode('tinystats','wp_tinylytics_stats_function');

?>