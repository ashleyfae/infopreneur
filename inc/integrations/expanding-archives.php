<?php
/**
 * Expanding Archives Integration
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

/**
 * Remove Expanding Archives CSS
 *
 * We'll be adding our own CSS.
 *
 * @since 1.0.0
 * @return void
 */
function infopreneur_remove_expanding_archives_css() {
	wp_dequeue_style( 'expanding-archives' );
}

add_action( 'wp_enqueue_scripts', 'infopreneur_remove_expanding_archives_css' );