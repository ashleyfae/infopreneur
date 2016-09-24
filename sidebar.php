<?php
/**
 * The sidebar containing the right-hand-side widget area ( `sidebar` ).
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

if ( ! is_active_sidebar( 'sidebar' ) && ! is_customize_preview() ) {
	return;
}
?>

<button class="layout-toggle" aria-controls="sidebar-right" aria-expanded="false"><?php esc_html_e( 'Show Sidebar', 'infopreneur' ); ?></button>

<aside id="sidebar-right" class="widget-area" role="complementary">
	<?php
	if ( is_active_sidebar( 'sidebar' ) ) {
		dynamic_sidebar( 'sidebar' );
	} elseif ( is_customize_preview() ) {
		?>
		<p><?php _e( 'Add some widgets to the \'Sidebar\' widget area.', 'infopreneur' ); ?></p>
		<?php
	}
	?>
</aside>