<?php

/**
 * Icon Widget
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Ashley Gibson
 * @license   GPL2+
 */
class Infopreneur_Icon_Widget extends WP_Widget {

	/**
	 * Infopreneur_Icon_Widget constructor.
	 *
	 * @access public
	 * @since  1.0
	 * @return void
	 */
	public function __construct() {
		parent::__construct(
			'infopreneur_icon',
			__( 'Infopreneur - Icon', 'infopreneur' ),
			array( 'descriptoin' => __( 'Large Font Awesome icon above text.', 'infopreneur' ) )
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

		echo $args['before_widget'];

		if ( $instance['icon'] ) {
			?>
			<div class="info-icon-widget-wrap">
				<i class="fa fa-<?php echo esc_attr( $instance['icon'] ); ?>"></i>
			</div>
			<?php
		}

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		if ( $instance['text'] ) {
			echo '<div class="info-icon-widget-text text-' . esc_attr( $instance['align'] ) . '">' . wpautop( $instance['text'] ) . '</div>';
		}

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
			'icon'  => 'heart',
			'title' => '',
			'text'  => '',
			'align' => 'center'
		) );

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'icon' ); ?>"><?php printf( __( '<a href="%s" target="_blank">Font Awesome</a> Icon Name:', 'infopreneur' ), 'http://fontawesome.io/icons/' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'icon' ); ?>" name="<?php echo $this->get_field_name( 'icon' ); ?>" type="text" value="<?php echo esc_attr( $instance['icon'] ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'infopreneur' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Content:', 'infopreneur' ); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" rows="16" cols="20"><?php echo esc_textarea( $instance['text'] ); ?></textarea>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'align' ); ?>"><?php _e( 'Text Alignment:', 'infopreneur' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'align' ); ?>" name="<?php echo $this->get_field_name( 'align' ); ?>">
				<?php foreach ( $this->text_alignments() as $key => $name ) : ?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $instance['align'], $key ); ?>><?php echo esc_html( $name ); ?></option>
				<?php endforeach; ?>
			</select>
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
		$instance['text']  = wp_kses_post( $new_instance['text'] );

		// Sanitize icon.
		$stripped_icon    = str_replace( array( 'fa-', 'fa ' ), '', $new_instance['icon'] );
		$instance['icon'] = sanitize_html_class( trim( $stripped_icon ) );

		// Sanitize alignment.
		$align             = wp_strip_all_tags( $new_instance['align'] );
		$instance['align'] = array_key_exists( $align, $this->text_alignments() ) ? sanitize_html_class( $align ) : 'center';

		return $instance;

	}

	/**
	 * Allowed Text Alignments
	 *
	 * @access public
	 * @since  1.0.0
	 * @return array
	 */
	public function text_alignments() {
		$alignments = array(
			'left'    => __( 'Left', 'infopreneur' ),
			'center'  => __( 'Centered', 'infopreneur' ),
			'right'   => __( 'Right', 'infopreneur' ),
			'jusitfy' => __( 'Justified', 'infopreneur' )
		);

		return apply_filters( 'infopreneur/widget/icon/text-alignments', $alignments, $this );
	}

}

add_action( 'widgets_init', function () {
	register_widget( 'Infopreneur_Icon_Widget' );
} );