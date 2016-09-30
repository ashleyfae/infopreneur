<?php
/**
 * Sidebar - Left
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

if ( ! is_active_sidebar( 'sidebar-2' ) && ! is_customize_preview() ) {
	return;
}
?>

<aside id="sidebar-left" class="widget-area" role="complementary">
	<?php
	if ( is_active_sidebar( 'sidebar-2' ) ) {
		dynamic_sidebar( 'sidebar-2' );
	} elseif ( is_customize_preview() ) {
		?>
		<p><?php _e( 'Add some widgets to the \'Sidebar - Left\' widget area.', 'infopreneur' ); ?></p>
		<?php
	}
	?>
</aside>