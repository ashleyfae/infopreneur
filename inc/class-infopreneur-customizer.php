<?php

/**
 * Theme Customizer Settings
 *
 * Adds all our custom panels, sections, settings, and controls
 * to the WordPress Customizer.
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */
class Infopreneur_Customizer {

	/**
	 * The single instance of Infopreneur_Customizer
	 *
	 * @var Infopreneur_Customizer
	 * @access private
	 * @since  1.0.0
	 */
	private static $_instance = null;

	/**
	 * Theme Version
	 *
	 * @var string
	 * @access public
	 * @since  1.0.0
	 */
	public $version;

	/**
	 * Constructor
	 *
	 * Initializes the class and sets its properties.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function __construct() {
		if ( is_child_theme() ) {
			$child_theme = wp_get_theme();
			$theme       = wp_get_theme( $child_theme->get( 'Template' ) );
		} else {
			$theme = wp_get_theme();
		}

		$this->version = $theme->get( 'Version' );

		// Register our Customizer settings.
		add_action( 'customize_register', array( $this, 'register_customize_sections' ) );

		// Add our custom JavaScript controls.
		add_action( 'customize_preview_init', array( $this, 'enqueue_template_scripts' ), 99 );
	}

	/**
	 * Main Infopreneur_Customizer Instance
	 *
	 * Ensures only one instance of Infopreneur_Customizer is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @return Infopreneur_Customizer instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Default Values
	 *
	 * The default values of each Customizer setting.
	 *
	 * @param string $key
	 *
	 * @hooks  :
	 *       + infopreneur/settings/defaults
	 *
	 * @access public
	 * @since  1.0.0
	 * @return array|string Either array of all values, or a single value
	 */
	public static function defaults( $key = '' ) {
		$defaults = array(
			'layout_style'              => 'full',
			'post_layout'               => 'list',
			'number_full_posts'         => 0,
			'summary_type'              => 'excerpts',
			'excerpt_length'            => 30,
			'meta_config_blog'          => '[category]',
			'meta_position_blog'        => 'below',
			'sidebar_left_blog'         => false,
			'sidebar_right_blog'        => false,
			'suppress_archive_headings' => false,
			'meta_config_single'        => '[date] &bull; [category] &bull; [comments]',
			'meta_position_single'      => 'above',
			'hide_featured_image'       => false,
			'sidebar_left_single'       => false,
			'sidebar_right_single'      => true,
			'sidebar_left_page'         => false,
			'sidebar_right_page'        => true,
			'footer_text'               => sprintf( __( 'Copyright &copy; %s.', 'infopreneur' ), date( 'Y' ) . ' ' . '<a href="' . home_url( '/' ) . '">' . get_bloginfo( 'name' ) . '</a>' )
		);

		$defaults = apply_filters( 'infopreneur/settings/defaults', $defaults );

		// If a key is entered, but it doesn't exist - return nothing.
		if ( ! empty( $key ) && ! array_key_exists( $key, $defaults ) ) {
			return '';
		}

		// If a key is entered, return a specific value.
		if ( ! empty( $key ) && array_key_exists( $key, $defaults ) ) {
			return $defaults[ $key ];
		}

		// Otherwise, return the entire array.
		return $defaults;
	}

	/**
	 * Adds all panels and sections to the Customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function register_customize_sections( $wp_customize ) {

		/*
		 * Panels
		 */
		$wp_customize->add_section( 'layout', array(
			'title'    => __( 'Layout', 'infopreneur' ),
			'priority' => 100
		) );

		/*
		 * Sections
		 */

		// Blog Archive
		$wp_customize->add_section( 'global_layout', array(
			'title' => __( 'Global', 'infopreneur' ),
			'panel' => 'layout',
		) );

		// Blog Archive
		$wp_customize->add_section( 'blog_archive', array(
			'title' => __( 'Blog Archive', 'infopreneur' ),
			'panel' => 'layout',
		) );

		// Single Post
		$wp_customize->add_section( 'single_post', array(
			'title' => __( 'Single Post', 'infopreneur' ),
			'panel' => 'layout',
		) );

		// Single Page
		$wp_customize->add_section( 'single_page', array(
			'title' => __( 'Single Page', 'infopreneur' ),
			'panel' => 'layout',
		) );

		// Footer
		$wp_customize->add_section( 'footer', array(
			'title' => __( 'Theme Footer', 'infopreneur' ),
		) );

		/*
		 * Populate each section with the settings/controls.
		 */

		$this->global_layout_section( $wp_customize );
		$this->blog_archive_section( $wp_customize );
		$this->single_post_section( $wp_customize );
		$this->single_page_section( $wp_customize );
		$this->footer_section( $wp_customize );

		/*
		 * Change existing settings.
		 */
		$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_image' )->transport      = 'postMessage';
		$wp_customize->get_setting( 'header_image_data' )->transport = 'postMessage';

	}

	/**
	 * Enqueue scripts for the Customizer preview.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function enqueue_template_scripts() {
		// @todo add minify
		wp_register_script( 'infopreneur-customizer', get_template_directory_uri() . '/inc/customizer/customizer.js', array(
			'jquery',
			'customize-preview'
		), $this->version, true );
	}

	/**
	 * Section: Global Layout
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0.0
	 * @return void
	 */
	private function global_layout_section( $wp_customize ) {

		/* Post Layout */
		$wp_customize->add_setting( 'layout_style', array(
			'default'           => self::defaults( 'layout_style' ),
			'sanitize_callback' => array( $this, 'sanitize_layout_style' ),
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'layout_style', array(
			'label'    => esc_html__( 'Container Style', 'infopreneur' ),
			'type'     => 'radio',
			'choices'  => array(
				'boxed' => esc_html__( 'Boxed', 'infopreneur' ),
				'full'  => esc_html__( 'Full Width', 'infopreneur' )
			),
			'section'  => 'layout',
			'settings' => 'layout_style',
			'priority' => 10
		) ) );

	}

	/**
	 * Section: Blog Archive
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0.0
	 * @return void
	 */
	private function blog_archive_section( $wp_customize ) {

		/* Post Layout */
		$wp_customize->add_setting( 'post_layout', array(
			'default'           => self::defaults( 'post_layout' ),
			'sanitize_callback' => array( $this, 'sanitize_post_layout' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'post_layout', array(
			'label'    => esc_html__( 'Post Archive Layout', 'infopreneur' ),
			'type'     => 'radio',
			'choices'  => array(
				'grid-2-col' => esc_html__( '2 Column Grid', 'infopreneur' ),
				'grid-3-col' => esc_html__( '3 Column Grid', 'infopreneur' ),
				'list'       => esc_html__( 'List', 'infopreneur' )
			),
			'section'  => 'blog_archive',
			'settings' => 'post_layout',
			'priority' => 10
		) ) );

		/* Number of Full Posts */
		$wp_customize->add_setting( 'number_full_posts', array(
			'default'           => self::defaults( 'number_full_posts' ),
			'sanitize_callback' => 'absint'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'number_full_posts', array(
			'label'       => esc_html__( 'Number of Full Posts', 'infopreneur' ),
			'description' => esc_html__( 'This setting is ignored if you\'ve chosen "Full Posts" above.', 'infopreneur' ),
			'type'        => 'number',
			'section'     => 'blog_archive',
			'settings'    => 'number_full_posts',
			'priority'    => 20
		) ) );

		/* Excerpts vs Full Posts */
		$wp_customize->add_setting( 'summary_type', array(
			'default'           => self::defaults( 'summary_type' ),
			'sanitize_callback' => array( $this, 'sanitize_summary_type' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'summary_type', array(
			'label'    => esc_html__( 'Post Archive Layout', 'infopreneur' ),
			'type'     => 'radio',
			'choices'  => array(
				'full'     => esc_html__( 'Full Text / Read More Tag', 'infopreneur' ),
				'excerpts' => esc_html__( 'Automatic Excerpts', 'infopreneur' ),
				'none'     => esc_html__( 'None', 'infopreneur' )
			),
			'section'  => 'blog_archive',
			'settings' => 'summary_type',
			'priority' => 30
		) ) );

		/* Excerpt Length */
		$wp_customize->add_setting( 'excerpt_length', array(
			'default'           => self::defaults( 'excerpt_length' ),
			'sanitize_callback' => 'absint'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'excerpt_length', array(
			'label'       => esc_html__( 'Excerpt Length', 'infopreneur' ),
			'description' => esc_html__( 'Only applies if you\'ve chosen "Automatic Excerpts" above.', 'infopreneur' ),
			'type'        => 'number',
			'section'     => 'blog_archive',
			'settings'    => 'excerpt_length',
			'priority'    => 40
		) ) );

		/* Meta Config */
		$wp_customize->add_setting( 'meta_config_blog', array(
			'default'           => self::defaults( 'meta_config_blog' ),
			'sanitize_callback' => 'wp_kses_post'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'meta_config_blog', array(
			'label'       => esc_html__( 'Entry Meta', 'infopreneur' ),
			'description' => sprintf(
				__( 'Configure the template for meta information. Use the following placeholders: <br><br>%s - Post Date <br>%s - Post Author <br>%s - Category <br>%s - Number of Comments', 'infopreneur' ),
				'<code>[date]</code>',
				'<code>[author]</code>',
				'<code>[category]</code>',
				'<code>[comments]</code>'
			),
			'type'        => 'textarea',
			'section'     => 'blog_archive',
			'settings'    => 'meta_config_blog',
			'priority'    => 50
		) ) );

		/* Meta Position */
		$wp_customize->add_setting( 'meta_position_blog', array(
			'default'           => self::defaults( 'meta_position_blog' ),
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'meta_position_blog', array(
			'label'    => esc_html__( 'Entry Meta Position', 'infopreneur' ),
			'type'     => 'radio',
			'choices'  => array(
				'above' => esc_html__( 'Above title', 'infopreneur' ),
				'below' => esc_html__( 'Below title', 'infopreneur' )
			),
			'section'  => 'blog_archive',
			'settings' => 'meta_position_blog',
			'priority' => 60
		) ) );

		/* Show / hide stuff */

		// @todo maybe featured area

		/* Left Sidebar */
		$wp_customize->add_setting( 'sidebar_left_blog', array(
			'default'           => self::defaults( 'sidebar_left_blog' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_left_blog', array(
			'label'    => esc_html__( 'Show left sidebar', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'blog_archive',
			'settings' => 'sidebar_left_blog',
			'priority' => 110
		) ) );

		/* Right Sidebar */
		$wp_customize->add_setting( 'sidebar_right_blog', array(
			'default'           => self::defaults( 'sidebar_right_blog' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_right_blog', array(
			'label'    => esc_html__( 'Show right sidebar', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'blog_archive',
			'settings' => 'sidebar_right_blog',
			'priority' => 120
		) ) );

		/* Suppress Archive Headings */
		$wp_customize->add_setting( 'suppress_archive_headings', array(
			'default'           => self::defaults( 'suppress_archive_headings' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'suppress_archive_headings', array(
			'label'    => esc_html__( 'Suppress archive headings (i.e. "Category: Books")', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'blog_archive',
			'settings' => 'suppress_archive_headings',
			'priority' => 130
		) ) );

	}

	/**
	 * Section: Single Post
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0.0
	 * @return void
	 */
	private function single_post_section( $wp_customize ) {

		/* Meta Config */
		$wp_customize->add_setting( 'meta_config_single', array(
			'default'           => self::defaults( 'meta_config_single' ),
			'sanitize_callback' => 'wp_kses_post'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'meta_config_single', array(
			'label'       => esc_html__( 'Entry Meta', 'infopreneur' ),
			'description' => sprintf(
				__( 'Configure the template for meta information. Use the following placeholders: <br><br>%s - Post Date <br>%s - Post Author <br>%s - Category <br>%s - Number of Comments', 'infopreneur' ),
				'<code>[date]</code>',
				'<code>[author]</code>',
				'<code>[category]</code>',
				'<code>[comments]</code>'
			),
			'type'        => 'textarea',
			'section'     => 'single_post',
			'settings'    => 'meta_config_single',
			'priority'    => 50
		) ) );

		/* Meta Position */
		$wp_customize->add_setting( 'meta_position_single', array(
			'default'           => self::defaults( 'meta_position_single' ),
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'meta_position_single', array(
			'label'    => esc_html__( 'Entry Meta Position', 'infopreneur' ),
			'type'     => 'radio',
			'choices'  => array(
				'above' => esc_html__( 'Above title', 'infopreneur' ),
				'below' => esc_html__( 'Below title', 'infopreneur' )
			),
			'section'  => 'single_post',
			'settings' => 'meta_position_single',
			'priority' => 60
		) ) );

		/* Hide Featured Image */
		$wp_customize->add_setting( 'hide_featured_image', array(
			'default'           => self::defaults( 'hide_featured_image' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'hide_featured_image', array(
			'label'    => esc_html__( 'Hide featured image', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'single_post',
			'settings' => 'hide_featured_image',
			'priority' => 100
		) ) );

		/* Left Sidebar */
		$wp_customize->add_setting( 'sidebar_left_single', array(
			'default'           => self::defaults( 'sidebar_left_single' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_left_single', array(
			'label'    => esc_html__( 'Show left sidebar', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'single_post',
			'settings' => 'sidebar_left_single',
			'priority' => 120
		) ) );

		/* Right Sidebar */
		$wp_customize->add_setting( 'sidebar_right_single', array(
			'default'           => self::defaults( 'sidebar_right_single' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_right_single', array(
			'label'    => esc_html__( 'Show right sidebar', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'single_post',
			'settings' => 'sidebar_right_single',
			'priority' => 130
		) ) );

	}

	/**
	 * Section: Single Page
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0.0
	 * @return void
	 */
	private function single_page_section( $wp_customize ) {

		/* Left Sidebar */
		$wp_customize->add_setting( 'sidebar_left_page', array(
			'default'           => self::defaults( 'sidebar_left_page' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_left_page', array(
			'label'    => esc_html__( 'Show left sidebar', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'single_page',
			'settings' => 'sidebar_left_page',
			'priority' => 120
		) ) );

		/* Right Sidebar */
		$wp_customize->add_setting( 'sidebar_right_page', array(
			'default'           => self::defaults( 'sidebar_right_page' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_right_page', array(
			'label'    => esc_html__( 'Show right sidebar', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'single_page',
			'settings' => 'sidebar_right_page',
			'priority' => 130
		) ) );

	}

	/**
	 * Section: Footer
	 *
	 * Controls the copyright text and theme link.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0.0
	 * @return void
	 */
	private function footer_section( $wp_customize ) {

		/*
		 * Copyright Text
		 */
		$wp_customize->add_setting( 'copyright_message', array(
			'default'           => self::defaults( 'footer_text' ),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'copyright_message', array(
				'label'       => __( 'Copyright Text', 'infopreneur' ),
				'description' => sprintf(
					__( 'Customize the copyright message. You can use %s as a placeholder for the current year.', 'infopreneur' ),
					'<code>[current-year]</code>'
				),
				'type'        => 'textarea',
				'section'     => 'footer',
				'settings'    => 'copyright_message',
			)
		) );

	}

}

new Infopreneur_Customizer();