<?php
/**
 * Template part for displaying EDD download content in archive-download.php.
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

$thumb = infopreneur_get_post_thumbnail( array( 'alignment' => 'aligncenter' ) );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/Product">

	<?php if ( $thumb ) : ?>
		<div class="edd_download_image">
			<a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php echo $thumb; ?>
			</a>
		</div>
	<?php endif; ?>

	<?php the_title( '<h2 class="entry-title" itemprop="name"><a href="' . esc_url( get_permalink() ) . '" itemprop="url">', infopreneur_get_edd_price( get_the_ID(), ' - ' ) . '</a></h2>' ); ?>

	<a href="<?php echo esc_url( get_permalink() ); ?>" class="more-link"><?php _e( 'Details &raquo;', 'infopreneur' ); ?></a>

</article>