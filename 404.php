<?php
/**
 * 404 - Page Not Found
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

$widget_args = $archives_args = array(
	'before_widget' => '<section class="widget %s">',
	'after_widget'  => '</section>',
	'before_title'  => '<h2 class="widget-title">',
	'after_title'   => '</h2>',
);


// Include header.php.
get_header();
?>

	<main id="main" class="site-main" role="main">

		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'infopreneur' ); ?></h1>
			</header>

			<div class="page-content">
				<p class="nothing-found-message"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'infopreneur' ); ?></p>

				<?php get_search_form(); ?>

				<div class="error-404-widgets">
					<?php
					the_widget( 'WP_Widget_Recent_Posts', array(), $widget_args );

					// Only show the widget if site has multiple categories.
					if ( infopreneur_categorized_blog() ) :
						?>

						<section class="widget widget_categories">
							<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'infopreneur' ); ?></h2>
							<ul>
								<?php
								wp_list_categories( array(
									'orderby'    => 'count',
									'order'      => 'DESC',
									'show_count' => false,
									'title_li'   => '',
									'number'     => 10,
								) );
								?>
							</ul>
						</section>

						<?php
					endif;

					/* translators: %1$s: smiley */
					$archive_content              = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'infopreneur' ), convert_smilies( ':)' ) ) . '</p>';
					$archives_args['after_title'] = $archives_args['after_title'] . $archive_content;
					the_widget( 'WP_Widget_Archives', 'dropdown=1', $archives_args );

					the_widget( 'WP_Widget_Tag_Cloud', array(), $widget_args );
					?>
				</div>

			</div>
		</section>

	</main>

<?php
// Include footer.php.
get_footer();