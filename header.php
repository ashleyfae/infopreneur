<?php
/**
 * Header
 *
 * Displays all of the <head> section and everything up utnil <div id="content">
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>

	<?php do_action( 'infopreneur/head' ); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'infopreneur' ); ?></a>

	<?php if ( ! infopreneur_is_plain_page() ) : ?>
		<header id="masthead" class="site-header" role="banner">
			<?php
			/**
			 * The following functions are hooked in:
			 *
			 * @see infopreneur_header_container_start() - 10
			 * @see infopreneur_header_navigation_1() - 20
			 * @see infopreneur_header_social() - 30
			 * @see infopreneur_site_title() - 40
			 * @see infopreneur_header_navigation_2() - 50
			 * @see infopreneur_header_container_end() - 60
			 */
			do_action( 'infopreneur/header' );
			?>
		</header>

		<?php
		/**
		 * Featured banner area.
		 */
		get_template_part( 'template-parts/featured' );

		/**
		 * Below header widget.
		 */
		if ( is_active_sidebar( 'below-header' ) ) {
			?>
			<div id="below-header-area" class="widget-area">
				<?php dynamic_sidebar( 'below-header' ); ?>
			</div>
			<?php
		}
	endif;
	?>

	<div id="content" class="site-content container">

<?php do_action( 'infopreneur/inside-content/top' ); ?>