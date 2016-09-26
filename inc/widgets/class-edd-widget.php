<?php

/**
 * Displays details about the current EDD product.
 * This widget only appears on single download pages.
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */
class Infopreneur_EDD_Widget extends WP_Widget {

	/**
	 * Infopreneur_EDD_Widget constructor.
	 *
	 * @access public
	 * @since  1.0
	 * @return void
	 */
	public function __construct() {
		parent::__construct(
			'infopreneur_edd',
			__( 'Infopreneur - EDD Product', 'infopreneur' ),
			array( 'descriptoin' => __( 'Display information about the current Easy Digital Downloads product. Only appears on single product pages.', 'infopreneur' ) )
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see    WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 *
	 * @access public
	 * @since  1.0
	 * @return void
	 */
	public function widget( $args, $instance ) {

		$instance = wp_parse_args( $instance, array(
			'title'                => __( 'Product Information', 'infopreneur' ),
			'show_purchase_button' => true,
			'show_published'       => true,
			'show_modified'        => true,
			'show_sales'           => false,
			'show_version'         => false,
			'show_categories'      => true,
			'show_tags'            => true
		) );

		if ( ! is_singular( 'download' ) && apply_filters( 'infopreneur/widgets/edd/only-show-on-single-download', true ) ) {
			return;
		}

		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		if ( $instance['show_purchase_button'] ) {
			echo edd_get_purchase_link( array( 'id' => get_the_ID() ) );
		}
		?>
		<ul>
			<?php if ( $instance['show_published'] ) : ?>
				<li class="info-edd-download-published">
					<span class="info-edd-name"><?php _e( 'Published:', 'infopreneur' ); ?></span>
					<span class="info-edd-value">
						<?php
						printf(
							'<time class="entry-date published" datetime="%1$s">%2$s</time>',
							esc_attr( get_the_date( 'c' ) ),
							esc_html( get_the_date() ),
							esc_attr( get_the_modified_date( 'c' ) ),
							esc_html( get_the_modified_date() )
						);
						?>
					</span>
				</li>
			<?php endif; ?>

			<?php if ( $instance['show_modified'] ) : ?>
				<li class="info-edd-download-updated">
					<span class="info-edd-name"><?php _e( 'Updated:', 'infopreneur' ); ?></span>
					<span class="info-edd-value">
						<?php echo esc_html( get_the_modified_date() ); ?>
					</span>
				</li>
			<?php endif; ?>

			<?php if ( $instance['show_sales'] ) : ?>
				<li class="info-edd-download-sales">
					<span class="info-edd-name"><?php _e( 'Sales:', 'infopreneur' ); ?></span>
					<span class="info-edd-value">
						<?php echo esc_html( apply_filters( 'infopreneur/widgets/edd/number-of-sales', edd_get_download_sales_stats( get_the_ID() ), get_the_ID(), $instance ) ); ?>
					</span>
				</li>
			<?php endif; ?>

			<?php if ( class_exists( 'EDD_Software_Licensing' ) && $instance['show_version'] ) : ?>
				<li class="info-edd-download-version">
					<span class="info-edd-name"><?php _e( 'Version:', 'infopreneur' ); ?></span>
					<span class="info-edd-value">
						<?php
						$version = apply_filters( 'infopreneur/widgets/edd/download-version', get_post_meta( get_the_ID(), '_edd_sl_version', true ), get_the_ID(), $instance );

						echo $version ? esc_html( $version ) : __( 'n/a', 'infopreneur' );
						?>
					</span>
				</li>
			<?php endif; ?>

			<?php if ( $instance['show_categories'] ) :
				$categories = get_the_term_list( get_the_ID(), 'download_category', '', ', ', '' );

				if ( $categories ) :
					?>
					<li class="info-edd-download-categories">
						<span class="info-edd-name"><?php _e( 'Categories:', 'infopreneur' ); ?></span>
						<span class="info-edd-value">
							<?php echo $categories; ?>
						</span>
					</li>
					<?php
				endif;
			endif;
			?>

			<?php if ( $instance['show_tags'] ) :
				$tags = get_the_term_list( get_the_ID(), 'download_tag', '', ', ', '' );

				if ( $tags ) :
					?>
					<li class="info-edd-download-tags">
						<span class="info-edd-name"><?php _e( 'Tags:', 'infopreneur' ); ?></span>
						<span class="info-edd-value">
							<?php echo $tags; ?>
						</span>
					</li>
					<?php
				endif;
			endif;
			?>
		</ul>
		<?php

		echo $args['after_widget'];

	}

	/**
	 * Back-end widget form.
	 *
	 * @see    WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 *
	 * @access public
	 * @since  1.0
	 * @return void
	 */
	public function form( $instance ) {

		$instance = wp_parse_args( $instance, array(
			'title'                => __( 'Product Information', 'infopreneur' ),
			'show_purchase_button' => true,
			'show_published'       => true,
			'show_modified'        => true,
			'show_sales'           => false,
			'show_version'         => false,
			'show_categories'      => true,
			'show_tags'            => true
		) );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'infopreneur' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
		</p>

		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'show_purchase_button' ); ?>" name="<?php echo $this->get_field_name( 'show_purchase_button' ); ?>" value="1" <?php checked( $instance['show_purchase_button'] ); ?>>
			<label for="<?php echo $this->get_field_id( 'show_purchase_button' ); ?>"><?php _e( 'Show purchase button', 'infopreneur' ); ?></label>
		</p>

		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'show_published' ); ?>" name="<?php echo $this->get_field_name( 'show_published' ); ?>" value="1" <?php checked( $instance['show_published'] ); ?>>
			<label for="<?php echo $this->get_field_id( 'show_published' ); ?>"><?php _e( 'Show product publish date', 'infopreneur' ); ?></label>
		</p>

		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'show_modified' ); ?>" name="<?php echo $this->get_field_name( 'show_modified' ); ?>" value="1" <?php checked( $instance['show_modified'] ); ?>>
			<label for="<?php echo $this->get_field_id( 'show_modified' ); ?>"><?php _e( 'Show last updated date', 'infopreneur' ); ?></label>
		</p>

		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'show_sales' ); ?>" name="<?php echo $this->get_field_name( 'show_sales' ); ?>" value="1" <?php checked( $instance['show_sales'] ); ?>>
			<label for="<?php echo $this->get_field_id( 'show_sales' ); ?>"><?php _e( 'Show number of sales', 'infopreneur' ); ?></label>
		</p>

		<?php if ( class_exists( 'EDD_Software_Licensing' ) ) : ?>
			<p>
				<input type="checkbox" id="<?php echo $this->get_field_id( 'show_version' ); ?>" name="<?php echo $this->get_field_name( 'show_version' ); ?>" value="1" <?php checked( $instance['show_version'] ); ?>>
				<label for="<?php echo $this->get_field_id( 'show_version' ); ?>"><?php _e( 'Show version number', 'infopreneur' ); ?></label>
			</p>
		<?php endif; ?>

		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'show_categories' ); ?>" name="<?php echo $this->get_field_name( 'show_categories' ); ?>" value="1" <?php checked( $instance['show_categories'] ); ?>>
			<label for="<?php echo $this->get_field_id( 'show_categories' ); ?>"><?php _e( 'Show categories', 'infopreneur' ); ?></label>
		</p>

		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'show_tags' ); ?>" name="<?php echo $this->get_field_name( 'show_tags' ); ?>" value="1" <?php checked( $instance['show_tags'] ); ?>>
			<label for="<?php echo $this->get_field_id( 'show_tags' ); ?>"><?php _e( 'Show tags', 'infopreneur' ); ?></label>
		</p>
		<?php

	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see    WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @access public
	 * @since  1.0
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		$checkboxes = array(
			'show_purchase_button',
			'show_published',
			'show_modified',
			'show_sales',
			'show_version',
			'show_categories',
			'show_tags'
		);

		foreach ( $checkboxes as $value ) {
			$instance[ $value ] = $new_instance[ $value ] ? true : false;
		}

		return $instance;

	}

}

// Only register this widget if EDD is activated.
if ( class_exists( 'Easy_Digital_Downloads' ) ) {
	add_action( 'widgets_init', function () {
		register_widget( 'Infopreneur_EDD_Widget' );
	} );
}