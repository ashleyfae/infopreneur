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
 * Show Featured Area
 *
 * Determines whether or not we should display the featured area on the
 * current view.
 *
 * @since 1.0
 * @return bool
 */
function infopreneur_show_featured() {
	$view = infopreneur_get_current_view();
	$mod  = wp_strip_all_tags( 'show_featured_' . $view );
	$show = get_theme_mod( $mod, Infopreneur_Customizer::defaults( $mod ) );

	return apply_filters( 'infopreneur/show-featured', $show, $mod, $view );
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
 * @param array $classes
 *
 * @uses  infopreneur_is_plain_page()
 * @uses  infopreneur_get_current_view()
 * @uses  infopreneur_get_sidebar_locations()
 *
 * @since 1.0.0
 * @return array
 */
function infopreneur_body_classes( $classes ) {
	/*
	 * Container
	 */
	$layout_style = get_theme_mod( 'layout_style', Infopreneur_Customizer::defaults( 'layout_style' ) );
	$classes[]    = 'layout-style-' . sanitize_html_class( $layout_style );

	/*
	 * Sidebar Classes
	 */

	// Get current page template.
	$page_template = get_page_template_slug();

	if ( $page_template != 'page-templates/full-width.php' && ! infopreneur_is_plain_page() ) {

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

	// Primary Color
	$primary_dark = infopreneur_adjust_brightness( get_theme_mod( 'primary_color', Infopreneur_Customizer::defaults( 'primary_color' ) ), - 30 );
	$css .= sprintf(
		'a, .navigation a:hover, #header-social a:hover, .page-title span { color: %1$s; }
		.button, button, .more-link, input[type="submit"], .pagination .current { background-color: %1$s; border-color: %1$s; border-bottom-color: %2$s; }
		.button:hover, button:hover, .more-link:hover, input[type="submit"]:hover { background-color: %2$s; border-color: %2$s; }
		',
		esc_html( get_theme_mod( 'primary_color', Infopreneur_Customizer::defaults( 'primary_color' ) ) ),
		esc_html( $primary_dark )
	);

	// Secondary colour
	$css .= sprintf(
		'#colophon { background-color: %1$s; }
		blockquote { border-left-color: %1$s; }',
		esc_html( get_theme_mod( 'secondary_color', Infopreneur_Customizer::defaults( 'secondary_color' ) ) )
	);

	// Lead box BG colour
	$css .= sprintf(
		'.page-template-lead-box { background-color: %1$s; }',
		esc_html( get_theme_mod( 'lead_box_bg', Infopreneur_Customizer::defaults( 'lead_box_bg' ) ) )
	);

	// Featured
	$css .= sprintf(
		'#featured-area { background-color: %1$s; background-image: url(%2$s); background-position: %3$s; color: %4$s; }',
		esc_html( get_theme_mod( 'featured_bg_color', Infopreneur_Customizer::defaults( 'featured_bg_color' ) ) ),
		esc_url( get_theme_mod( 'featured_bg_image', Infopreneur_Customizer::defaults( 'featured_bg_image' ) ) ),
		esc_html( str_replace( '-', ' ', get_theme_mod( 'featured_bg_position', Infopreneur_Customizer::defaults( 'featured_bg_position' ) ) ) ),
		esc_html( get_theme_mod( 'featured_text_color', Infopreneur_Customizer::defaults( 'featured_text_color' ) ) )
	);
	$css .= sprintf(
		'#featured-area.featured-overlay:before { background-color: %1$s; opacity: %2$s }',
		esc_html( get_theme_mod( 'featured_bg_color', Infopreneur_Customizer::defaults( 'featured_bg_color' ) ) ),
		esc_html( get_theme_mod( 'featured_overlay', Infopreneur_Customizer::defaults( 'featured_overlay' ) ) )
	);
	$button_dark = infopreneur_adjust_brightness( get_theme_mod( 'featured_button_bg_color', Infopreneur_Customizer::defaults( 'featured_button_bg_color' ) ), - 30 );
	$css .= sprintf(
		'#featured-area .button { background-color: %1$s; border-color: %1$s; border-bottom-color: %3$s; color: %2$s; }',
		esc_html( get_theme_mod( 'featured_button_bg_color', Infopreneur_Customizer::defaults( 'featured_button_bg_color' ) ) ),
		esc_html( get_theme_mod( 'featured_button_text_color', Infopreneur_Customizer::defaults( 'featured_button_text_color' ) ) ),
		esc_html( $button_dark )
	);
	$css .= sprintf(
		'#featured-area .button:hover { background-color: %1$s; border-color: %1$s; }',
		esc_html( $button_dark )
	);

	return apply_filters( 'infopreneur/custom-css', $css );
}

/**
 * Adjust Colour Brightness
 *
 * @param string $hex   Base hex colour
 * @param int    $steps Number between -255 (darker) and 255 (lighter)
 *
 * @since 1.0
 * @return string
 */
function infopreneur_adjust_brightness( $hex, $steps ) {
	$steps = max( - 255, min( 255, $steps ) );

	// Normalize into a six character long hex string
	$hex = str_replace( '#', '', $hex );
	if ( strlen( $hex ) == 3 ) {
		$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
	}

	// Split into three parts: R, G and B
	$color_parts = str_split( $hex, 2 );
	$return      = '#';

	foreach ( $color_parts as $color ) {
		$color = hexdec( $color ); // Convert to decimal
		$color = max( 0, min( 255, $color + $steps ) ); // Adjust color
		$return .= str_pad( dechex( $color ), 2, '0', STR_PAD_LEFT ); // Make two char hex code
	}

	return $return;
}

/**
 * Auto paragraph the featured area description.
 *
 * @since 1.0.0
 */
add_filter( 'infopreneur/featured/description', 'wpautop', 10 );

/**
 * Get Featured Area Classes
 *
 * Compiles all the classes for the featured area into an array.
 *
 * @hooks :
 *        `infopreneur/featured/get-classes`
 *
 * @since 1.0
 * @return array
 */
function infopreneur_get_featured_classes() {
	$classes = array(
		get_theme_mod( 'featured_alignment', Infopreneur_Customizer::defaults( 'featured_alignment' ) )
	);

	if ( get_theme_mod( 'featured_overlay', Infopreneur_Customizer::defaults( 'featured_overlay' ) ) ) {
		$classes[] = 'featured-overlay';
	}

	return apply_filters( 'infopreneur/featured/get-classes', $classes );
}

/**
 * Featured Area HTML Classes
 *
 * Gets and sanitizes the HTML classes for the featured area, then
 * converts them into a string.
 *
 * @uses  infopreneur_get_featured_classes()
 *
 * @since 1.0
 * @return string
 */
function infopreneur_featured_classes() {
	$classes           = infopreneur_get_featured_classes();
	$sanitized_classes = array_map( 'sanitize_html_class', $classes );

	return implode( ' ', $sanitized_classes );
}

/**
 * Get Social Sites
 *
 * Returns an array of social media sites that can be used in the theme.
 *
 * @hooks :
 *        `infopreneur/get-social-sites`
 *
 * @since 1.0.0
 * @return array
 */
function infopreneur_get_social_sites() {
	$sites = array(
		'twitter'     => array(
			'name' => __( 'Twitter', 'infopreneur' ),
			'icon' => 'fa-twitter-square'
		),
		'facebook'    => array(
			'name' => __( 'Facebook', 'infopreneur' ),
			'icon' => 'fa-facebook-square'
		),
		'pinterest'   => array(
			'name' => __( 'Pinterest', 'infopreneur' ),
			'icon' => 'fa-pinterest-square'
		),
		'instagram'   => array(
			'name' => __( 'Instagram', 'infopreneur' ),
			'icon' => 'fa-instagram'
		),
		'google_plus' => array(
			'name' => __( 'Google+', 'infopreneur' ),
			'icon' => 'fa-google-plus-square'
		),
		'tumblr'      => array(
			'name' => __( 'Tumblr', 'infopreneur' ),
			'icon' => 'fa-tumblr-square'
		),
		'youtube'     => array(
			'name' => __( 'YouTube', 'infopreneur' ),
			'icon' => 'fa-youtube-square'
		),
		'rss'         => array(
			'name' => __( 'RSS', 'infopreneur' ),
			'icon' => 'fa-rss-square'
		)
	);

	return apply_filters( 'infopreneur/get-social-sites', $sites );
}

/**
 * Is Plain Page
 *
 * Determines whether or not we're on a "plain" page. Plain pages omit
 * the header, footer, and other extra flashy areas.
 *
 * @hooks :
 *        `infopreneur/is-plain-page`
 *
 * @since 1.0.0
 * @return bool
 */
function infopreneur_is_plain_page() {
	$is_plain_page = false;

	$plain_templates = array(
		'page-templates/landing.php',
		'page-templates/lead-box.php'
	);

	if ( in_array( get_page_template_slug(), $plain_templates ) ) {
		$is_plain_page = true;
	}

	return apply_filters( 'infopreneur/is-plain-page', $is_plain_page );
}

/**
 * Search Template
 *
 * Adds the search template to the site footer. It's hidden via CSS
 * and revealed via JavaScript - yay!
 *
 * @hooks :
 *        `infopreneur/search-template/before` - Before search form
 *        `infopreneur/search-template/after` - After search form
 *
 * @since 1.0.0
 * @return void
 */
function infopreneur_search_template() {
	?>
	<div id="search-wrap">
		<a href="#" class="search-wrap-close">&times;</a>
		<div class="container">
			<?php
			do_action( 'infopreneur/search-template/before' );

			get_search_form();

			do_action( 'infopreneur/search-template/after' );
			?>

			<a href="#" class="search-wrap-close"><?php _e( 'cancel', 'infopreneur' ); ?></a>
		</div>
	</div>
	<?php
}

add_action( 'wp_footer', 'infopreneur_search_template' );