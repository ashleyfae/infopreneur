<?php
/**
 * Archive for EDD Products
 *
 * @todo      :
 *      Maybe allow for changing column numbers.
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

$page_title   = get_theme_mod( 'edd_page_title', Infopreneur_Customizer::defaults( 'edd_page_title' ) );
$archive_desc = get_theme_mod( 'edd_page_desc', Infopreneur_Customizer::defaults( 'edd_page_desc' ) );

// Include header.php.
get_header();

// Maybe include left sidebar.
infopreneur_maybe_show_sidebar( 'left' );
?>

	<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php if ( $page_title || $archive_desc || is_customize_preview() ) : ?>
				<header class="page-header">
					<?php if ( $page_title || is_customize_preview() ) : ?>
						<h1 class="page-title"><?php echo $page_title; ?></h1>
					<?php endif; ?>

					<?php if ( $archive_desc || is_customize_preview() ) : ?>
						<div class="archive-description">
							<?php echo $archive_desc; ?>
						</div>
					<?php endif; ?>
				</header>
			<?php endif; ?>

			<div id="post-feed" class="layout-grid-3-col">

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
					$slug          = 'download';
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