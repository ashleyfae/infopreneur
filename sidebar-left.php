<?php
/**
 * Sidebar - Left
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

if ( ! is_active_sidebar( 'sidebar-left' ) && ! is_customize_preview() ) {
	return;
}
?>

<aside id="sidebar-left" class="widget-area" role="complementary">
	<?php
	if ( is_active_sidebar( 'sidebar-left' ) ) {
		dynamic_sidebar( 'sidebar-left' );
	} elseif ( is_customize_preview() ) {
		?>
		<p><?php _e( 'Add some widgets to the \'Sidebar - Left\' widget area.', 'infopreneur' ); ?></p>
		<?php
	}
	?>
</aside>