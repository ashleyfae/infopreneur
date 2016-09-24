<?php
/**
 * Template part for displaying posts.
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

$meta_position = get_theme_mod( 'meta_position_blog', Infopreneur_Customizer::defaults( 'meta_position_blog' ) );
$summary_type  = get_theme_mod( 'summary_type', Infopreneur_Customizer::defaults( 'summary_type' ) );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php
		/*
		 * Maybe show entry meta
		 */
		if ( 'post' === get_post_type() && 'above' == $meta_position ) {
			infopreneur_entry_meta( 'meta_config_blog' );
		}

		/*
		 * Post Title
		 */
		if ( is_single() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}

		do_action( 'infopreneur/content/after-post-title', get_post() );

		/*
		 * Maybe show entry meta
		 */
		if ( 'post' === get_post_type() && 'below' == $meta_position ) {
			infopreneur_entry_meta( 'meta_config_blog' );
		}
		?>
	</header>

	<?php
	do_action( 'infopreneur/content/before-post-thumbnail', get_post() );

	/**
	 * Display the post thumbnail.
	 */
	echo infopreneur_get_post_thumbnail();

	do_action( 'infopreneur/content/after-post-thumbnail', get_post() )
	?>

	<?php if ( $summary_type != 'none' ) : ?>
		<div class="entry-content">
			<?php
			$summary_type = get_theme_mod( 'summary_type', 'excerpts' );
			if ( $summary_type == 'excerpts' ) {
				the_excerpt();
			} else {
				the_content( __( 'Continue Reading &raquo;', 'infopreneur' ) );
			}

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'infopreneur' ),
				'after'  => '</div>',
			) );
			?>
		</div>
	<?php endif;
	do_action( 'infopreneur/content/after-post-content', get_post() );
	?>

	<footer class="entry-footer">

	</footer>

</article>