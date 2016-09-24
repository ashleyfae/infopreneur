<?php
/**
 * Single Post Template
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

// Include header.php.
get_header();

// Include left sidebar (maybe).
infopreneur_maybe_show_sidebar( 'left' );
?>

	<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) :

			while ( have_posts() ) : the_post();

				/**
				 * Post Content
				 * Pull in template-parts/content-single.php, which displays the post content.
				 */
				get_template_part( 'template-parts/content', 'single' );

				/**
				 * Display the 'below-posts' widget area.
				 */
				if ( is_active_sidebar( 'below-posts' ) ) : ?>
					<div id="below-posts-widget-area" class="widget-area">
						<?php dynamic_sidebar( 'below-posts' ); ?>
					</div>
				<?php endif;

				/**
				 * Comments Template
				 * Pull in the comments template if comments are open or if we have at least one comment.
				 */
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile;

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

	</main>

<?php
// Include right sidebar (maybe).
infopreneur_maybe_show_sidebar( 'right' );

// Include footer.php.
get_footer();