<?php
/**
 * `[downloads]` Shortcode - Thumbnail
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

if ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail( get_the_ID() ) ) : ?>
	<div class="edd_download_image">
		<a href="<?php the_permalink(); ?>">
			<?php echo get_the_post_thumbnail( get_the_ID(), apply_filters( 'infopreneur/edd/shortcode-content-image/size', 'infopreneur_product_image' ) ); ?>
		</a>
	</div>
<?php endif;