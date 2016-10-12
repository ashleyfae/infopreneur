<?php
/**
 * WooCommerce
 *
 * Functions for integrating with WooCommerce.
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Ashley Gibson
 * @license   GPL2+
 * @since     1.0.0
 */

/**
 * Remove existing template actions.
 *
 * @since 1.0.0
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/**
 * Wrapper - Start
 *
 * @since 1.0.0
 * @return void
 */
function infopreneur_wc_wrapper_start() {
	// Include left sidebar (maybe).
	infopreneur_maybe_show_sidebar( 'left' );

	echo '<main id="main" class="site-main" role="main">';
}

add_action( 'woocommerce_before_main_content', 'infopreneur_wc_wrapper_start', 10 );

/**
 * Wrapper - End
 *
 * @since 1.0.0
 * @return void
 */
function infopreneur_wc_wrapper_end() {
	echo '</main>';

	// Include right sidebar (maybe).
	infopreneur_maybe_show_sidebar( 'right' );
}

add_action( 'woocommerce_after_main_content', 'infopreneur_wc_wrapper_end', 10 );