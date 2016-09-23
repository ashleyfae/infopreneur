<?php
/**
 * layout.php
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

/**
 * Header: Menu #1
 *
 * @uses  infopreneur_navigation()
 *
 * @since 1.0.0
 * @return void
 */
function infopreneur_header_navigation_1() {
	infopreneur_navigation( 'menu_1' );
}

add_action( 'infopreneur/header', 'infopreneur_header_navigation_1', 10 );

/**
 * Header
 *
 * Displays the header image and/or text.
 *
 * @hooks :
 *        + infopreneur/header/site-title/before
 *        + infopreneur/header/site-title/after
 * Use these hooks to add extra content before/after the header.
 *
 * @since 1.0.0
 * @return void
 */
function infopreneur_site_title() {
	do_action( 'infopreneur/header/site-title/before' );
	?>
	<div class="site-branding">
		<?php if ( get_header_image() ) : ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" id="site-banner">
				<img src="<?php header_image(); ?>" alt="<?php echo esc_attr( strip_tags( get_bloginfo( 'name' ) ) ); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>">
			</a>
		<?php endif; ?>

		<h1 class="site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		</h1>

		<?php
		// Display tagline.
		$description = get_bloginfo( 'description', 'display' );
		if ( $description || is_customize_preview() ) : ?>
			<p class="site-description">
				<?php echo $description; ?>
			</p>
		<?php endif; ?>
	</div>
	<?php
	do_action( 'infopreneur/header/site-title/after' );
}

add_action( 'infopreneur/header', 'infopreneur_site_title', 20 );

/**
 * Header: Menu #2
 *
 * @uses  infopreneur_navigation()
 *
 * @since 1.0.0
 * @return void
 */
function infopreneur_header_navigation_2() {
	infopreneur_navigation( 'menu_2' );
}

add_action( 'infopreneur/header', 'infopreneur_header_navigation_2', 30 );