<?php
/**
 * Search Results
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

// Include header.php.
get_header();

// Maybe include left sidebar.
infopreneur_maybe_show_sidebar( 'left' );
?>

	<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php if ( ! get_theme_mod( 'suppress_archive_headings' ) ) : ?>
				<header class="page-header">
					<h1 class="page-title"><?php printf( __( 'Search results for: %s', 'infopreneur' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header>
			<?php endif; ?>

			<div id="post-feed" class="layout-<?php echo esc_attr( get_theme_mod( 'post_layout', Infopreneur_Customizer::defaults( 'post_layout' ) ) ); ?>">

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post();

					/**
					 * Allow child themes to modify the template part. By default it's template-parts/content.php.
					 *
					 * @param string  $slug Template slug to use.
					 * @param WP_Post $post Current post.
					 *
					 * @since 1.0
					 */
					$slug          = '';
					$post          = get_post();
					$template_slug = apply_filters( 'infopreneur/index/template-slug', $slug, $post );

					/**
					 * Include the template part.
					 */
					get_template_part( 'template-parts/content', $template_slug );

				endwhile; ?>

			</div>

			<nav class="pagination">
				<?php echo paginate_links(); ?>
			</nav>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

	</main>

<?php
// Maybe include right sidebar.
infopreneur_maybe_show_sidebar( 'right' );

// Include footer.php.
get_footer();