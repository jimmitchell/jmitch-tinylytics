<?php

/*
 *
 * Admin shortcode help for Tinylytics
 * Since version 1.0.0
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<h2><?php esc_html_e( 'Shortcodes', 'jmitch-tinylytics' ); ?></h2>

<p><?php esc_html_e( 'Tinylytics comes with a variety of shortcodes which can be embedded directly in a post, page, or theme block to reduce the need for extensive HTML customizations.', 'jmitch-tinylytics' ); ?></p>

<table class="form-table" role="presentation" style="width:100%;">
    <tr><th style="width:20%;">[tinykudos]</th><td><?php esc_html_e( 'Displays an interactive button to track "kudos" given by readers. Best used directly in posts and pages.', 'jmitch-tinylytics' ); ?></td></tr>
	<tr><th>[tinyhits]</th><td><?php esc_html_e( 'Displays a count of page loads of the page viewed. Best used directly in posts and pages.', 'jmitch-tinylytics' ); ?></td></tr>
	<tr><th>[tinystats]</th><td><?php esc_html_e( 'Displays both overall site hits and uptime (Note: a Tinylytics subscription is required to display uptime). Best used in the footer of your site.', 'jmitch-tinylytics' ); ?></td></tr>
	<tr><th>[tinywebring]</th><td><?php esc_html_e( 'Displays a random link to a Tinylytics webring site. Enabling the "Display webring avatars?" option will include the avatar if the site has one. Best used in the footer of your site.', 'jmitch-tinylytics' ); ?></td></tr>
	<tr><th>[tinyflags]</th><td><?php esc_html_e( 'Displays flags from all the countries of site visitors. Best used in the footer of your site.', 'jmitch-tinylytics' ); ?></td></tr>
</table>

<p><?php
printf(
	/* translators: 1: link to the WordPress Shortcode Block documentation, 2: link to the Tinylytics website, 3: link to the Tinylytics documentation */
	esc_html__( 'Learn how to use the %1$s in your theme. More information about %2$s options can be found in the %3$s.', 'jmitch-tinylytics' ),
	'<a href="https://wordpress.org/documentation/article/shortcode-block/" target="_blank">' . esc_html__( 'Shortcode Block', 'jmitch-tinylytics' ) . '</a>',
	'<a href="https://tinylytics.app" target="_blank">Tinylytics</a>',
	'<a href="https://tinylytics.app/docs" target="_blank">' . esc_html__( 'documentation', 'jmitch-tinylytics' ) . '</a>'
);
?></p>