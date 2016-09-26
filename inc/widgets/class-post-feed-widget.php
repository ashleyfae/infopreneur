<?php

/**
 * Post Feed Widget
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */
class Infopreneur_Post_Feed_Widget extends WP_Widget {

	/**
	 * Infopreneur_Post_Feed_Widget constructor.
	 *
	 * @access public
	 * @since  1.0
	 * @return void
	 */
	public function __construct() {
		parent::__construct(
			'infopreneur_post_feed',
			__( 'Infopreneur - Post Feed', 'infopreneur' ),
			array( 'descriptoin' => __( 'Display a list of blog posts.', 'infopreneur' ) )
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

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		// Build our WP Query
		$query_args = array(
			'orderby'        => $instance['orderby'],
			'order'          => $instance['order'],
			'posts_per_page' => $instance['number_posts']
		);

		if ( $instance['cat'] > 0 ) {
			$query_args['cat'] = absint( $instance['cat'] );
		}

		$feed_query = new WP_Query( apply_filters( 'infopreneur/widget/post-feed/query-args', $query_args ) );

		if ( $feed_query->have_posts() ) : ?>

			<div id="post-feed" class="layout-<?php echo esc_attr( $instance['layout'] ); ?>">

				<?php while ( $feed_query->have_posts() ) : $feed_query->the_post();

					/**
					 * Display a few full posts.
					 */
					if ( $instance['full_posts'] > 0 && $feed_query->current_post < $instance['full_posts'] ) {

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
						$slug          = 'feed-widget';
						$post          = get_post();
						$template_slug = apply_filters( 'infopreneur/widget/post-feed/template-slug', $slug, $post );

						if ( $template_slug ) {
							$template_slug = '-' . $template_slug . '.php';
						} else {
							$template_slug = $template_slug . '.php';
						}

						/**
						 * Include the template part.
						 *
						 * I'm using a normal `include` here instead of `get_template_part()` so I still
						 * have access to the `$instance` variable here.
						 */
						$template = locate_template( 'template-parts/content' . $template_slug );

						if ( $template ) {
							include $template;
						}

					}

				endwhile;
				wp_reset_postdata(); ?>

			</div>

		<?php else :

			get_template_part( 'template-parts/content', 'none' );

		endif;

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
			'title'        => __( 'Latest Blog Posts', 'infopreneur' ),
			'cat'          => - 1,
			'orderby'      => 'date',
			'order'        => 'DESC',
			'layout'       => 'grid-3-col',
			'number_posts' => 6,
			'full_posts'   => 0,
			'post_content' => 'excerpts',
			'thumb_align'  => 'aligncenter'
		) );

		$cat_args = array(
			'show_option_all' => __( 'All Categories', 'infopreneur' ),
			'orderby'         => 'name',
			'order'           => 'ASC',
			'name'            => $this->get_field_name( 'cat' ),
			'id'              => $this->get_field_id( 'cat' ),
			'class'           => 'widefat',
			'selected'        => intval( $instance['cat'] )
		);
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'infopreneur' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'cat' ); ?>"><?php _e( 'Category:', 'infopreneur' ); ?></label>
			<?php wp_dropdown_categories( $cat_args ); ?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order By:', 'infopreneur' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
				<option value="date" <?php selected( $instance['orderby'], 'date' ); ?>><?php esc_html_e( 'Date', 'infopreneur' ); ?></option>
				<option value="title" <?php selected( $instance['orderby'], 'title' ); ?>><?php esc_html_e( 'Post Title', 'infopreneur' ); ?></option>
				<option value="comment_count" <?php selected( $instance['orderby'], 'comment_count' ); ?>><?php esc_html_e( 'Comment Count', 'infopreneur' ); ?></option>
				<option value="rand" <?php selected( $instance['orderby'], 'rand' ); ?>><?php esc_html_e( 'Random', 'infopreneur' ); ?></option>
			</select>
		</p>

		<p>
			<?php _e( 'Order:', 'infopreneur' ); ?> <br>
			<input type="radio" value="DESC" id="<?php echo $this->get_field_id( 'order' ); ?>_desc" name="<?php echo $this->get_field_name( 'order' ); ?>" <?php checked( $instance['order'], 'DESC' ); ?>>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>_desc"><?php esc_html_e( 'DESC (3, 2, 1; c, b, a)', 'infopreneur' ); ?></label>
			<br>

			<input type="radio" value="ASC" id="<?php echo $this->get_field_id( 'order' ); ?>_asc" name="<?php echo $this->get_field_name( 'order' ); ?>" <?php checked( $instance['order'], 'ASC' ); ?>>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>_asc"><?php esc_html_e( 'ASC (1, 2, 3; a, b, c)', 'infopreneur' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'layout' ); ?>"><?php _e( 'Layout:', 'infopreneur' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'layout' ); ?>" name="<?php echo $this->get_field_name( 'layout' ); ?>">
				<option value="grid-2-col" <?php selected( $instance['layout'], 'grid-2-col' ); ?>><?php esc_html_e( '2 Column Grid', 'infopreneur' ); ?></option>
				<option value="grid-3-col" <?php selected( $instance['layout'], 'grid-3-col' ); ?>><?php esc_html_e( '3 Column Grid', 'infopreneur' ); ?></option>
				<option value="list" <?php selected( $instance['layout'], 'list' ); ?>><?php esc_html_e( 'List', 'infopreneur' ); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'number_posts' ); ?>"><?php _e( 'Number of Posts:', 'infopreneur' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'number_posts' ); ?>" name="<?php echo $this->get_field_name( 'number_posts' ); ?>" type="number" value="<?php echo esc_attr( $instance['number_posts'] ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'full_posts' ); ?>"><?php _e( 'Number of Full Posts:', 'infopreneur' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'full_posts' ); ?>" name="<?php echo $this->get_field_name( 'full_posts' ); ?>" type="number" value="<?php echo esc_attr( $instance['full_posts'] ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'post_content' ); ?>"><?php _e( 'Post Content:', 'infopreneur' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'post_content' ); ?>" name="<?php echo $this->get_field_name( 'post_content' ); ?>">
				<option value="full" <?php selected( $instance['post_content'], 'full' ); ?>><?php esc_html_e( 'Full Text / Read More Tag', 'infopreneur' ); ?></option>
				<option value="excerpts" <?php selected( $instance['post_content'], 'excerpts' ); ?>><?php esc_html_e( 'Excerpts', 'infopreneur' ); ?></option>
				<option value="none" <?php selected( $instance['post_content'], 'none' ); ?>><?php esc_html_e( 'None', 'infopreneur' ); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'thumb_align' ); ?>"><?php _e( 'Thumbnail Alignment:', 'infopreneur' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'thumb_align' ); ?>" name="<?php echo $this->get_field_name( 'thumb_align' ); ?>">
				<option value="aligncenter" <?php selected( $instance['thumb_align'], 'aligncenter' ); ?>><?php esc_html_e( 'Centered', 'infopreneur' ); ?></option>
				<option value="alignleft" <?php selected( $instance['thumb_align'], 'alignleft' ); ?>><?php esc_html_e( 'Left Aligned', 'infopreneur' ); ?></option>
				<option value="aliginright" <?php selected( $instance['thumb_align'], 'aliginright' ); ?>><?php esc_html_e( 'Right Aligned', 'infopreneur' ); ?></option>
				<option value="disabled" <?php selected( $instance['thumb_align'], 'disabled' ); ?>><?php esc_html_e( 'Disabled', 'infopreneur' ); ?></option>
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

		$instance                 = array();
		$instance['title']        = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['cat']          = ( ! empty( $new_instance['cat'] ) ) ? intval( $new_instance['cat'] ) : - 1;
		$instance['order']        = ( ! empty( $new_instance['order'] ) && $new_instance['order'] == 'ASC' ) ? 'ASC' : 'DESC';
		$instance['number_posts'] = ( ! empty( $new_instance['number_posts'] ) ) ? intval( $new_instance['number_posts'] ) : 6;
		$instance['full_posts']   = ( ! empty( $new_instance['full_posts'] ) ) ? absint( $new_instance['full_posts'] ) : 0;
		$instance['thumb_align']  = ( ! empty( $new_instance['thumb_align'] ) ) ? sanitize_html_class( $new_instance['thumb_align'] ) : 'aligncenter';

		// Sanitize orderby.
		$sanitized_orderby   = ! empty( $new_instance['orderby'] ) ? wp_strip_all_tags( $new_instance['orderby'] ) : 'date';
		$instance['orderby'] = in_array( $sanitized_orderby, $this->allowed_orderby() ) ? $sanitized_orderby : 'date';

		// Sanitize layout.
		$sanitized_layout   = ! empty( $new_instance['layout'] ) ? wp_strip_all_tags( $new_instance['layout'] ) : 'list';
		$instance['layout'] = in_array( $sanitized_layout, $this->allowed_layouts() ) ? $sanitized_layout : 'list';

		// Sanitize post content.
		$sanitized_content        = ! empty( $new_instance['post_content'] ) ? wp_strip_all_tags( $new_instance['post_content'] ) : 'excerpts';
		$allowed_content          = array( 'full', 'excerpts', 'none' );
		$instance['post_content'] = in_array( $sanitized_content, $allowed_content ) ? $sanitized_content : 'excerpts';

		return $instance;

	}

	/**
	 * Allowed Layouts
	 *
	 * Returns an array of the allowed feed layouts.
	 *
	 * @access public
	 * @since  1.0
	 * @return array
	 */
	public function allowed_layouts() {
		return apply_filters( 'infopreneur/widget/post-feed/allowed-layouts', array(
			'grid-3-col',
			'grid-2-col',
			'list'
		) );
	}

	/**
	 * Allowed Orderby Values
	 *
	 * Returns an array of the allowed orderby values.
	 *
	 * @access public
	 * @since  1.0
	 * @return array
	 */
	public function allowed_orderby() {
		return apply_filters( 'infopreneur/widget/post-feed/allowed-orderby', array(
			'none',
			'ID',
			'author',
			'title',
			'name',
			'type',
			'date',
			'modified',
			'parent',
			'rand',
			'comment_count',
			'menu_order'
		) );
	}

}

add_action( 'widgets_init', function () {
	register_widget( 'Infopreneur_Post_Feed_Widget' );
} );