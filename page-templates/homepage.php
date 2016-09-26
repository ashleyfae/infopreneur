<?php
/**
 * Template Name: Homepage
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

// Include header.php.
get_header();
?>

	<main id="main" class="site-main" role="main">

		<?php
		for ( $i = 1; $i <= 3; $i ++ ) {
			if ( is_active_sidebar( 'home-' . absint( $i ) ) ) {
				$columns = absint( get_theme_mod( 'home_widget_' . absint( $i ) . '_cols', Infopreneur_Customizer::defaults( 'home_widget_' . absint( $i ) . '_cols' ) ) );
				?>
				<div id="home-widget-<?php echo esc_attr( $i ); ?>" class="home-widget-area home-widget-area-<?php echo esc_attr( $columns ); ?>-cols widget-area">
					<?php dynamic_sidebar( 'home-' . absint( $i ) ); ?>
				</div>
				<?php
			}
		}
		?>

	</main>

<?php
// Include footer.php.
get_footer();