<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the homepage when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

global $wp_query;
$post_layout = get_theme_mod( 'post_layout', Infopreneur_Customizer::defaults( 'post_layout' ) );

// Include header.php.
get_header();

// Maybe include left sidebar.
infopreneur_maybe_show_sidebar( 'left' );
?>

	<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<div id="post-feed" class="layout-<?php echo esc_attr( $post_layout ); ?>">

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post();

					$number_full_posts = get_theme_mod( 'number_full_posts', Infopreneur_Customizer::defaults( 'number_full_posts' ) );

					/**
					 * Display a few full posts.
					 */
					if ( ( ( $number_full_posts > 0 ) && $wp_query->current_post < $number_full_posts && ! is_paged() ) ) {

						get_template_part( 'template-parts/content', 'single' );

					} else {

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
						$template_slug = apply_filters( 'bookstagram/index/template-slug', $slug, $post );

						/**
						 * Include the template part.
						 */
						get_template_part( 'template-parts/content', $template_slug );

					}

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