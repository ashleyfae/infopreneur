<?php
/**
 * EDD E-Course
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Ashley Gibson
 * @license   GPL2+
 */

/**
 * Remove Footer Actions from E-Course Pages
 *
 * @since 1.0.0
 * @return void
 */
function infopreneur_remove_actions_ecourse_pages() {
	if ( ! function_exists( 'edd_ecourse_is_course_page' ) ) {
		return;
	}

	if ( ! edd_ecourse_is_course_page() ) {
		return;
	}

	remove_action( 'wp_footer', 'infopreneur_search_template' );
}

add_action( 'wp_head', 'infopreneur_remove_actions_ecourse_pages' );