<?php
/**
 * Featured Area
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

if ( ! infopreneur_show_featured() && ! is_customize_preview() ) {
	return;
}

?>

<section id="featured-area" class="<?php echo esc_attr( infopreneur_featured_classes() ); ?>"<?php echo ( ! infopreneur_show_featured() ) ? ' style="display: none;"' : ''; ?>>
	<div class="container">
		<div id="featured-inner">
			<h1 id="featured-heading"><?php echo get_theme_mod( 'featured_heading', Infopreneur_Customizer::defaults( 'featured_heading' ) ); ?></h1>
			<div id="featured-desc">
				<?php echo apply_filters( 'infopreneur/featured/description', get_theme_mod( 'featured_desc', Infopreneur_Customizer::defaults( 'featured_desc' ) ) ); ?>
			</div>
			<div id="featured-cta">
				<a href="<?php echo esc_url( get_theme_mod( 'featured_url', Infopreneur_Customizer::defaults( 'featured_url' ) ) ); ?>" class="button"><?php echo esc_html( get_theme_mod( 'featured_button', Infopreneur_Customizer::defaults( 'featured_button' ) ) ); ?></a>
			</div>
		</div>
	</div>
</section>
