<?php
/**
 * Template for showing page content in page.php.
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

?>

<article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php do_action( 'infopreneur/content-page/before-page', get_post() ); ?>

	<header class="entry-header">
		<?php
		/*
		 * Post Title
		 */
		if ( is_singular() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}

		do_action( 'infopreneur/content-page/after-post-title', get_post() );
		?>
	</header>

	<div class="entry-content">
		<?php
		the_content( __( 'Continue Reading &raquo;', 'infopreneur' ) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'infopreneur' ),
			'after'  => '</div>',
		) );
		?>
	</div>

	<?php do_action( 'infopreneur/content-page/after-page-content', get_post() ); ?>

</article>