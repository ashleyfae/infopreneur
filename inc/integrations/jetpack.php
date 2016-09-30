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

	// Portfolio CPT.
	add_theme_support( 'jetpack-portfolio' );
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

/**
 * Display the Portfolio Grid
 *
 * Builds the Jetpack shortcode based on Customizer settings.
 *
 * @since 1.0.0
 * @return void
 */
function infopreneur_jetpack_portfolio() {
	echo do_shortcode( sprintf(
		'[portfolio display_types="%s" display_tags="%s" display_content="%s" include_type="%s" include_tag="%s" columns="%s" showposts="%s" order="%s" orderby="%s"]',
		esc_attr( infopreneur_jetpack_theme_mod( 'portfolio_display_types' ) ),
		esc_attr( infopreneur_jetpack_theme_mod( 'portfolio_display_tags' ) ),
		esc_attr( infopreneur_jetpack_theme_mod( 'portfolio_display_content' ) ),
		esc_attr( get_theme_mod( 'portfolio_include_type', Infopreneur_Customizer::defaults( 'portfolio_include_type' ) ) ),
		esc_attr( get_theme_mod( 'portfolio_include_tag', Infopreneur_Customizer::defaults( 'portfolio_include_tag' ) ) ),
		absint( get_theme_mod( 'portfolio_columns', Infopreneur_Customizer::defaults( 'portfolio_columns' ) ) ),
		esc_attr( get_theme_mod( 'portfolio_showposts', Infopreneur_Customizer::defaults( 'portfolio_showposts' ) ) ),
		esc_attr( get_theme_mod( 'portfolio_order', Infopreneur_Customizer::defaults( 'portfolio_order' ) ) ),
		esc_attr( get_theme_mod( 'portfolio_orderby', Infopreneur_Customizer::defaults( 'portfolio_orderby' ) ) )
	) );
}

/**
 * Get Jetpack Theme Mod
 *
 * Wrapper for retrieving Jetpack theme mods. This is used to convert bool
 * `true` and `false` into string equivalents.
 *
 * @param string $key Theme mod to get the setting for.
 *
 * @since 1.0.0
 * @return string
 */
function infopreneur_jetpack_theme_mod( $key ) {
	$option = get_theme_mod( $key, Infopreneur_Customizer::defaults( $key ) );

	return $option ? 'true' : 'false';
}