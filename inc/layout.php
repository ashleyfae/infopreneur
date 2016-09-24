<?php
/**
 * layout.php
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

/**
 * Header: Start Container
 *
 * @since 1.0.0
 * @return void
 */
function infopreneur_header_container_start() {
	echo '<div class="container">';
}

add_action( 'infopreneur/header', 'infopreneur_header_container_start', 10 );

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

add_action( 'infopreneur/header', 'infopreneur_header_navigation_1', 20 );

/**
 * Display Social Sites
 *
 * Also includes the search icon.
 *
 * @uses  infopreneur_get_social_sites()
 *
 * @since 1.0.0
 * @return void
 */
function infopreneur_header_social() {
	?>
	<nav id="header-social">
		<ul>
			<?php
			foreach ( infopreneur_get_social_sites() as $id => $options ) {
				$url = get_theme_mod( $id );

				if ( ! $url ) {
					continue;
				}
				?>
				<li id="site-<?php echo esc_attr( $id ); ?>">
					<a href="<?php echo esc_url( $url ); ?>" title="<?php printf( esc_attr__( '%s Profile', 'infopreneur' ), $options['name'] ); ?>">
						<i class="fa <?php echo sanitize_html_class( $options['icon'] ); ?>"></i>
					</a>
				</li>
				<?php
			}
			?>
			<li id="search-site">
				<a href="#"><i class="fa fa-search"></i></a>
			</li>
		</ul>
	</nav>
	<?php
}

add_action( 'infopreneur/header', 'infopreneur_header_social', 30 );

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

add_action( 'infopreneur/header', 'infopreneur_site_title', 40 );

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

add_action( 'infopreneur/header', 'infopreneur_header_navigation_2', 50 );

/**
 * Header: End Container
 *
 * @since 1.0.0
 * @return void
 */
function infopreneur_header_container_end() {
	echo '</div>';
}

add_action( 'infopreneur/header', 'infopreneur_header_container_end', 60 );