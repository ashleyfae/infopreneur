<?php
/**
 * Template Tags
 *
 * Functions used within the template files.
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

if ( ! function_exists( 'infopreneur_navigation' ) ) {
	/**
	 * Navigation Menu
	 *
	 * Displays a navigation menu with surrounding markup.
	 *
	 * @param int $number Which number navigation to display
	 *
	 * @hooks :
	 *       + infopreneur/navigation/before
	 *       + infopreneur/navigation/after
	 * Use these hooks to add extra content before/after the navigation.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function infopreneur_navigation( $id = 'menu_1' ) {
		// If this menu isn't set - bail.
		if ( ! has_nav_menu( $id ) ) {
			return;
		}

		do_action( 'infopreneur/navigation/before', $id );
		?>
		<nav id="site-navigation-<?php esc_attr_e( $id ); ?>" class="main-navigation" role="navigation">
			<button class="menu-toggle" aria-controls="menu-<?php esc_attr_e( $id ); ?>" aria-expanded="false"><?php esc_html_e( 'Menu', 'infopreneur' ); ?></button>
			<?php wp_nav_menu( array(
				'theme_location' => $id,
				'menu_id'        => 'menu-' . $id
			) ); ?>
		</nav>
		<?php
		do_action( 'infopreneur/navigation/after', $id );
	}
}

if ( ! function_exists( 'infopreneur_maybe_show_sidebar' ) ) {
	/**
	 * Maybe Show Sidebar
	 *
	 * Sidebar is included if it's turned on in the settings panel.
	 *
	 * @uses  infopreneur_get_current_view()
	 *
	 * @param string $location
	 *
	 * @since 1.0
	 * @return void
	 */
	function infopreneur_maybe_show_sidebar( $location = 'right' ) {
		// Get the view.
		$view = infopreneur_get_current_view();

		// Get the option in the Customizer.
		$show_sidebar = get_theme_mod( 'sidebar_' . $location . '_' . $view, Infopreneur_Customizer::defaults( 'sidebar_' . $location . '_' . $view ) );

		if ( $show_sidebar ) {
			get_sidebar( $location );
		}
	}
}

/**
 * Copyright Text
 *
 * Displays the footer copyright text, as specified in the settings panel.
 *
 * @since 1.0.0
 * @return string
 */
function infopreneur_get_copyright_message() {
	$find    = array(
		'[site-url]',
		'[site-title]',
		'[current-year]',
	);
	$replace = array(
		get_bloginfo( 'url' ),
		get_bloginfo( 'name' ),
		date( 'Y' ),
	);

	return str_replace( $find, $replace, get_theme_mod( 'footer_text', sprintf( __( '&copy; %s %s. All Rights Reserved.', 'gwen' ), '[current-year]', '[site-title]' ) ) );
}

/**
 * Theme URI
 *
 * Gets the URL to the theme's product page with the affiliate ID
 * appended, if entered.
 *
 * @since 1.0.0
 * @return string
 */
function infopreneur_theme_uri() {
	return apply_filters( 'infopreneur/theme-uri', '#' );
}

if ( ! function_exists( 'infopreneur_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function infopreneur_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			esc_html_x( 'Posted on %s', 'post date', 'infopreneur' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			esc_html_x( 'by %s', 'post author', 'infopreneur' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
	}
}

if ( ! function_exists( 'infopreneur_entry_footer' ) ) {
	/**
	 * Prints HTML with meta information for the categories, tags, and comments.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function infopreneur_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' == get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'infopreneur' ) );
			if ( $categories_list ) {
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'infopreneur' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'infopreneur' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'infopreneur' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( esc_html__( 'Leave a comment', 'infopreneur' ), esc_html__( '1 Comment', 'infopreneur' ), esc_html__( '% Comments', 'infopreneur' ) );
			echo '</span>';
		}

		edit_post_link( esc_html__( 'Edit', 'infopreneur' ), '<span class="edit-link">', '</span>' );
	}
}