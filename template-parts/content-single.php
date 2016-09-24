<?php
/**
 * Template part for showing full blog posts in single.php.
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

$meta_position = get_theme_mod( 'meta_position_single', Infopreneur_Customizer::defaults( 'meta_position_single' ) );
$post_class    = ( ! is_singular() ) ? 'full-post' : '';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>

	<?php
	do_action( 'infopreneur/content-single/before-post', get_post() );
	?>

	<header class="entry-header">
		<?php
		/*
		 * Maybe show entry meta
		 */
		if ( 'post' === get_post_type() && 'above' == $meta_position ) {
			infopreneur_entry_meta( 'meta_config_single' );
		}

		/*
		 * Post Title
		 */
		if ( is_single() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}

		do_action( 'infopreneur/content-single/after-post-title', get_post() );

		/*
		 * Maybe show entry meta
		 */
		if ( 'post' === get_post_type() && 'below' == $meta_position ) {
			infopreneur_entry_meta( 'meta_config_single' );
		}
		?>
	</header>

	<?php
	/*
	 * Featured Image
	 */
	do_action( 'infopreneur/content-single/before-featured-image', get_post() );

	if ( has_post_thumbnail() && ! get_theme_mod( 'hide_featured_image', Infopreneur_Customizer::defaults( 'hide_featured_image' ) ) ) {
		the_post_thumbnail( 'full', array( 'class' => 'aligncenter featured-image' ) );
	}
	?>

	<div class="entry-content">
		<?php
		the_content( __( 'Continue Reading &raquo;', 'infopreneur' ) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'infopreneur' ),
			'after'  => '</div>',
		) );
		?>
	</div>

	<?php
	do_action( 'infopreneur/content-single/after-post-content', get_post() );

	/*
	 * Post footer information (tags list).
	 */
	infopreneur_entry_footer();
	?>

</article>