<?php
/**
 * Footer
 *
 * The template for displaying the footer.
 * Contains the closing of the #content div and all content after.
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

?>

</div><!-- #content -->

<footer id="colophon" class="site-footer" role="contentinfo">
	<?php do_action( 'infopreneur/footer/before-site-info' ); ?>

	<div class="site-info">
		<?php
		/*
		 * Display the copyright message.
		 */
		?>
		<span id="infopreneur-copyright"><?php infopreneur_get_copyright_message(); ?></span>

		<span id="infopreneur-credits">
			<?php
			printf(
				'<a href="' . esc_url( 'https://github.com/nosegraze/infopreneur' ) . '" target="_blank" rel="nofollow">%1$s</a>',
				__( 'Infopreneur Theme', 'gwen' )
			);

			do_action( 'infopreneur/footer/attribution' ); ?>
		</span>
	</div>

	<?php do_action( 'infopreneur/footer/after-site-info' ); ?>
</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>