<?php
/**
 * archive-portfolio.php
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

$page_title   = get_theme_mod( 'portfolio_page_title', Infopreneur_Customizer::defaults( 'portfolio_page_title' ) );
$archive_desc = get_theme_mod( 'portfolio_page_desc', Infopreneur_Customizer::defaults( 'portfolio_page_desc' ) );

// Include header.php.
get_header();

// Maybe include left sidebar.
infopreneur_maybe_show_sidebar( 'left' );
?>

	<main id="main" class="site-main" role="main">

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

		<div id="jetpack-portfolio-grid">
			<?php infopreneur_jetpack_portfolio(); ?>
		</div>

	</main>

<?php
// Maybe include right sidebar.
infopreneur_maybe_show_sidebar( 'right' );

// Include footer.php.
get_footer();