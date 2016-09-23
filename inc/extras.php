<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

/**
 * Get Current View
 *
 * @since 1.0
 * @return string
 */
function infopreneur_get_current_view() {
	$view = '';

	if ( is_post_type_archive( 'book' ) || is_tax( array( 'novelist-genre', 'novelist-series' ) ) ) {
		$view = 'book_archive';
	} elseif ( is_singular( 'book' ) ) {
		$view = 'book_single';
	} elseif ( is_home() || is_archive() || is_search() ) {
		$view = 'blog';
	} elseif ( is_page() ) {
		$view = 'page';
	} elseif ( is_singular() ) {
		$view = 'single';
	}

	return apply_filters( 'infopreneur/get-current-view', $view );
}

/**
 * Get Sidebar Locations
 *
 * Returns an array of all the sidebar options we have.
 *
 * @since 1.0
 * @return array
 */
function infopreneur_get_sidebar_locations() {
	$locations = array(
		'left',
		'right'
	);

	return apply_filters( 'infopreneur/get-sidebar-locations', $locations );
}

/**
 * Body Classes
 *
 * @todo
 *
 * @param array $classes
 *
 * @since 1.0.0
 * @return array
 */
function infopreneur_body_classes( $classes ) {
	/*
	 * Container
	 */
	$layout_style = get_theme_mod( 'layout_style', 'boxed' );
	$classes[]    = 'layout-style-' . sanitize_html_class( $layout_style );

	/*
	 * Sidebar Classes
	 */

	// Get current page template.
	$page_template = get_page_template_slug();

	if ( $page_template != 'page-templates/full-width.php' && $page_template != 'page-templates/landing.php' ) {

		// Get the view.
		$view = infopreneur_get_current_view();

		// Get the option in the Customizer.
		foreach ( infopreneur_get_sidebar_locations() as $location ) {
			$show_sidebar = get_theme_mod( 'sidebar_' . $location . '_' . $view, Infopreneur_Customizer::defaults( 'sidebar_' . $location . '_' . $view ) );

			if ( $show_sidebar ) {
				$classes[] = $location . '-sidebar-is-on';
			}
		}
	}

	return $classes;
}

add_filter( 'body_class', 'infopreneur_body_classes' );

/**
 * Get Custom CSS
 *
 * Generates and returns CSS based on Customizer settings.
 *
 * @since 1.0.0
 * @return string
 */
function infopreneur_get_custom_css() {
	$css = '';

	return apply_filters( 'infopreneur/custom-css', $css );
}