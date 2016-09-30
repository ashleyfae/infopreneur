<?php
/**
 * Jetpack Integration
 *
 * @link      https://jetpack.com/
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

/**
 * Setup Jetpack Integration
 *
 * Add support for infinite scroll and responsive videos.
 *
 * @link  https://jetpack.com/support/infinite-scroll/
 * @link  https://jetpack.com/support/responsive-videos/
 *
 * @since 1.0.0
 * @return void
 */
function infopreneur_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'container' => 'post-feed',
		'render'    => 'infopreneur_infinite_scroll_render',
		'footer'    => 'page'
	) );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );
}

add_action( 'after_setup_theme', 'infopreneur_jetpack_setup' );

/**
 * Render Infinite Scroll
 *
 * @since 1.0.0
 * @return void
 */
function infopreneur_infinite_scroll_render() {

	while ( have_posts() ) {

		the_post();
		if ( is_search() ) :

			$slug          = '';
			$post          = get_post();
			$template_slug = apply_filters( 'infopreneur/index/template-slug', $slug, $post );
			get_template_part( 'template-parts/content', $template_slug );

		else :

			$slug          = '';
			$post          = get_post();
			$template_slug = apply_filters( 'infopreneur/index/template-slug', $slug, $post );
			get_template_part( 'template-parts/content', $template_slug );

		endif;

	}

}