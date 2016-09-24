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

		add_action( 'customize_register', array( $this, 'register_customize_sections' ) );
		add_action( 'customize_register', array( $this, 'refresh' ) );
		add_action( 'customize_preview_init', array( $this, 'live_preview' ) );
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
			'primary_color'              => '#ff7a5a',
			'layout_style'               => 'full',
			'post_layout'                => 'list',
			'number_full_posts'          => 1,
			'summary_type'               => 'excerpts',
			'thumbnail_align'            => 'aligncenter',
			'excerpt_length'             => 30,
			'meta_config_blog'           => '[category]',
			'meta_position_blog'         => 'below',
			'show_featured_blog'         => true,
			'sidebar_left_blog'          => false,
			'sidebar_right_blog'         => true,
			'suppress_archive_headings'  => false,
			'meta_config_single'         => '[date] &ndash; [category] &ndash; [comments]',
			'meta_position_single'       => 'below',
			'hide_featured_image'        => false,
			'show_featured_single'       => true,
			'sidebar_left_single'        => false,
			'sidebar_right_single'       => true,
			'show_featured_page'         => true,
			'sidebar_left_page'          => false,
			'sidebar_right_page'         => true,
			'featured_bg_color'          => '#00aaa0',
			'featured_bg_image'          => get_template_directory_uri() . '/assets/images/featured-bg.jpg',
			'featured_bg_position'       => 'center-top',
			'featured_overlay'           => 0.5,
			'featured_alignment'         => 'featured-centered',
			'featured_text_color'        => '#ffffff',
			'featured_heading'           => __( 'Run your blog like a boss', 'infopreneur' ),
			'featured_desc'              => __( 'Join my tribe of over 1,000 infopreneurs and self-starters to take your blog to the next level.', 'infopreneur' ),
			'featured_url'               => home_url( '/' ),
			'featured_button'            => __( 'Get Started', 'infopreneur' ),
			'featured_button_bg_color'   => '#ff7a5a',
			'featured_button_text_color' => '#ffffff',
			'footer_text'                => sprintf( __( 'Copyright &copy; %s.', 'infopreneur' ), date( 'Y' ) . ' ' . '<a href="' . home_url( '/' ) . '">' . get_bloginfo( 'name' ) . '</a>' )
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
		$wp_customize->add_panel( 'layout', array(
			'title'    => __( 'Layout', 'infopreneur' ),
			'priority' => 101
		) );

		/*
		 * Sections
		 */

		// Featured Area
		$wp_customize->add_section( 'featured', array(
			'title'    => __( 'Featured Area', 'infopreneur' ),
			'priority' => 102
		) );

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

		// Social Media
		$wp_customize->add_section( 'social', array(
			'title'       => __( 'Social Media', 'infopreneur' ),
			'description' => __( 'Social icons will appear to the right of your top navigation menu.', 'infopreneur' )
		) );

		// Footer
		$wp_customize->add_section( 'footer', array(
			'title' => __( 'Footer', 'infopreneur' ),
		) );

		/*
		 * Populate each section with the settings/controls.
		 */

		$this->colors_section( $wp_customize );
		$this->featured_section( $wp_customize );
		$this->global_layout_section( $wp_customize );
		$this->blog_archive_section( $wp_customize );
		$this->single_post_section( $wp_customize );
		$this->single_page_section( $wp_customize );
		$this->social_media_section( $wp_customize );
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
	 * Selective Refresh
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	public function refresh( $wp_customize ) {

		// Abort if selective refresh is not available.
		if ( ! isset( $wp_customize->selective_refresh ) ) {
			return;
		}

		/* Social Sites */
		foreach ( infopreneur_get_social_sites() as $id => $options ) {
			$wp_customize->selective_refresh->add_partial( $id, array(
				'selector'            => '#header-social',
				'settings'            => $id,
				'container_inclusive' => true,
				'render_callback'     => function () {
					infopreneur_header_social();
				}
			) );
		}

		// Meta - Blog
		$wp_customize->selective_refresh->add_partial( 'meta_config_blog', array(
			'selector'            => 'body:not(.single) .entry-meta',
			'settings'            => 'meta_config_blog',
			'container_inclusive' => true,
			'render_callback'     => function () {
				infopreneur_entry_meta( 'meta_config_blog' );
			}
		) );

		// Meta - Single
		$wp_customize->selective_refresh->add_partial( 'meta_config_single', array(
			'selector'            => '.single .entry-meta',
			'settings'            => 'meta_config_single',
			'container_inclusive' => true,
			'render_callback'     => function () {
				infopreneur_entry_meta( 'meta_config_single' );
			}
		) );

	}

	/**
	 * Enqueue scripts for the Customizer preview.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function live_preview() {

		// Use minified libraries if SCRIPT_DEBUG is turned off
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		wp_enqueue_script(
			'infopreneur-customizer',
			get_template_directory_uri() . '/assets/js/customizer' . $suffix . '.js',
			array( 'jquery', 'customize-preview' ),
			$this->version,
			true
		);

	}

	/**
	 * Section: Colors
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0.0
	 * @return void
	 */
	private function colors_section( $wp_customize ) {

		/* Primary Colour */
		$wp_customize->add_setting( 'primary_color', array(
			'default'           => self::defaults( 'primary_color' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'primary_color', array(
			'label'       => esc_html__( 'Primary Color', 'infopreneur' ),
			'description' => __( 'Link colors, button backgrounds, etc.', 'infopreneur' ),
			'section'     => 'colors',
			'settings'    => 'primary_color',
		) ) );

	}

	/**
	 * Section: Featured
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0.0
	 * @return void
	 */
	private function featured_section( $wp_customize ) {

		/* Background Colour */
		$wp_customize->add_setting( 'featured_bg_color', array(
			'default'           => self::defaults( 'featured_bg_color' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh' // needs to be refresh because we use it in :before
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'featured_bg_color', array(
			'label'    => esc_html__( 'Background Color', 'infopreneur' ),
			'section'  => 'featured',
			'settings' => 'featured_bg_color',
		) ) );

		/* Background Image */
		$wp_customize->add_setting( 'featured_bg_image', array(
			'default'           => self::defaults( 'featured_bg_image' ),
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'featured_bg_image', array(
			'label'    => esc_html__( 'Background Image', 'infopreneur' ),
			'section'  => 'featured',
			'settings' => 'featured_bg_image',
		) ) );

		/* Background Image Position */
		$wp_customize->add_setting( 'featured_bg_position', array(
			'default'           => self::defaults( 'featured_bg_position' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'featured_bg_position', array(
			'label'    => esc_html__( 'BG Image Position', 'infopreneur' ),
			'type'     => 'select',
			'choices'  => array(
				'center-top'    => esc_html__( 'Center Top', 'infopreneur' ),
				'center'        => esc_html__( 'Center Center', 'infopreneur' ),
				'center-bottom' => esc_html__( 'Center Bottom', 'infopreneur' ),
				'left-top'      => esc_html__( 'Left Top', 'infopreneur' ),
				'left-center'   => esc_html__( 'Left Center', 'infopreneur' ),
				'left-bottom'   => esc_html__( 'Left Bottom', 'infopreneur' ),
				'right-top'     => esc_html__( 'Right Top', 'infopreneur' ),
				'right-center'  => esc_html__( 'Right Center', 'infopreneur' ),
				'right-bottom'  => esc_html__( 'Right Bottom', 'infopreneur' ),
			),
			'section'  => 'featured',
			'settings' => 'featured_bg_position',
		) ) );

		/* Background Image */
		$wp_customize->add_setting( 'featured_overlay', array(
			'default'           => self::defaults( 'featured_overlay' ),
			'sanitize_callback' => array( $this, 'sanitize_featured_overlay' ),
			'transport'         => 'refresh' // because we can't target :before in JavaScript
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'featured_overlay', array(
			'label'       => esc_html__( 'Overlay Visibility', 'infopreneur' ),
			'description' => __( 'Adds the "background color" as an overlay on top of the background image. Enter a number between 0 and 1, where 0 is completely transparent (no overlay) and 1 is completely opaque.', 'infopreneur' ),
			'type'        => 'number',
			'section'     => 'featured',
			'settings'    => 'featured_overlay',
		) ) );

		/* Alignment */
		$wp_customize->add_setting( 'featured_alignment', array(
			'default'           => self::defaults( 'featured_alignment' ),
			'sanitize_callback' => 'sanitize_html_class',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'featured_alignment', array(
			'label'    => esc_html__( 'Text Alignment', 'infopreneur' ),
			'type'     => 'select',
			'choices'  => array(
				'featured-centered' => esc_html__( 'Centered', 'infopreneur' ),
				'featured-left'     => esc_html__( 'Left Align', 'infopreneur' ),
				'featured-right'    => esc_html__( 'Right Align', 'infopreneur' )
			),
			'section'  => 'featured',
			'settings' => 'featured_alignment',
		) ) );

		/* Text Colour */
		$wp_customize->add_setting( 'featured_text_color', array(
			'default'           => self::defaults( 'featured_text_color' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'featured_text_color', array(
			'label'    => esc_html__( 'Text Color', 'infopreneur' ),
			'section'  => 'featured',
			'settings' => 'featured_text_color',
		) ) );

		/* Heading */
		$wp_customize->add_setting( 'featured_heading', array(
			'default'           => self::defaults( 'featured_heading' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'featured_heading', array(
			'label'    => esc_html__( 'Heading', 'infopreneur' ),
			'section'  => 'featured',
			'settings' => 'featured_heading',
		) ) );

		/* Desc */
		$wp_customize->add_setting( 'featured_desc', array(
			'default'           => self::defaults( 'featured_desc' ),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'featured_desc', array(
			'label'    => esc_html__( 'Description', 'infopreneur' ),
			'section'  => 'featured',
			'type'     => 'textarea',
			'settings' => 'featured_desc',
		) ) );

		/* Button BG Colour */
		$wp_customize->add_setting( 'featured_button_bg_color', array(
			'default'           => self::defaults( 'featured_button_bg_color' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'featured_button_bg_color', array(
			'label'    => esc_html__( 'Button BG Color', 'infopreneur' ),
			'section'  => 'featured',
			'settings' => 'featured_button_bg_color',
		) ) );

		/* Button Text Colour */
		$wp_customize->add_setting( 'featured_button_text_color', array(
			'default'           => self::defaults( 'featured_button_text_color' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'featured_button_text_color', array(
			'label'    => esc_html__( 'Button Text Color', 'infopreneur' ),
			'section'  => 'featured',
			'settings' => 'featured_button_text_color',
		) ) );

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
			'section'  => 'global_layout',
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
			'sanitize_callback' => array( $this, 'sanitize_post_layout' ),
			'transport'         => 'postMessage'
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
		) ) );

		/* Number of Full Posts */
		$wp_customize->add_setting( 'number_full_posts', array(
			'default'           => self::defaults( 'number_full_posts' ),
			'sanitize_callback' => 'absint'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'number_full_posts', array(
			'label'    => esc_html__( 'Number of Full Posts', 'infopreneur' ),
			'type'     => 'number',
			'section'  => 'blog_archive',
			'settings' => 'number_full_posts',
		) ) );

		/* Excerpts vs Full Posts */
		$wp_customize->add_setting( 'summary_type', array(
			'default'           => self::defaults( 'summary_type' ),
			'sanitize_callback' => array( $this, 'sanitize_summary_type' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'summary_type', array(
			'label'    => esc_html__( 'Post Content', 'infopreneur' ),
			'type'     => 'radio',
			'choices'  => array(
				'full'     => esc_html__( 'Full Text / Read More Tag', 'infopreneur' ),
				'excerpts' => esc_html__( 'Automatic Excerpts', 'infopreneur' ),
				'none'     => esc_html__( 'None', 'infopreneur' )
			),
			'section'  => 'blog_archive',
			'settings' => 'summary_type',
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
		) ) );

		/* Thumbnail Alignment */
		$wp_customize->add_setting( 'thumbnail_align', array(
			'default'           => self::defaults( 'thumbnail_align' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'thumbnail_align', array(
			'label'    => esc_html__( 'Thumbnail Alignment', 'infopreneur' ),
			'type'     => 'select',
			'choices'  => array(
				'aligncenter' => __( 'Centered', 'infopreneur' ),
				'alignleft'   => __( 'Left Aligned', 'infopreneur' ),
				'alignright'  => __( 'Right Aligned', 'infopreneur' )
			),
			'section'  => 'blog_archive',
			'settings' => 'thumbnail_align',
		) ) );

		/* Meta Config */
		$wp_customize->add_setting( 'meta_config_blog', array(
			'default'           => self::defaults( 'meta_config_blog' ),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => $wp_customize->selective_refresh ? 'postMessage' : 'refresh'
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
		) ) );

		/* Show / hide stuff */

		/* Featured Area */
		$wp_customize->add_setting( 'show_featured_blog', array(
			'default'           => self::defaults( 'show_featured_blog' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'show_featured_blog', array(
			'label'    => esc_html__( 'Show featured area', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'blog_archive',
			'settings' => 'show_featured_blog',
		) ) );

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
		) ) );

		/* Suppress Archive Headings */
		$wp_customize->add_setting( 'suppress_archive_headings', array(
			'default'           => self::defaults( 'suppress_archive_headings' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'suppress_archive_headings', array(
			'label'    => esc_html__( 'Suppress archive headings (i.e. "Category: Blogging")', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'blog_archive',
			'settings' => 'suppress_archive_headings',
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
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => $wp_customize->selective_refresh ? 'postMessage' : 'refresh'
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

		/* Featured Area */
		$wp_customize->add_setting( 'show_featured_single', array(
			'default'           => self::defaults( 'show_featured_single' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'show_featured_single', array(
			'label'    => esc_html__( 'Show featured area', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'blog_archive',
			'settings' => 'show_featured_single',
			'priority' => 110
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

		/* Featured Area */
		$wp_customize->add_setting( 'show_featured_page', array(
			'default'           => self::defaults( 'show_featured_page' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'show_featured_page', array(
			'label'    => esc_html__( 'Show featured area', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'blog_archive',
			'settings' => 'show_featured_page',
			'priority' => 110
		) ) );

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
	 * Section: Social Media
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0.0
	 * @return void
	 */
	private function social_media_section( $wp_customize ) {

		foreach ( infopreneur_get_social_sites() as $id => $site ) {
			$wp_customize->add_setting( $id, array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => $wp_customize->selective_refresh ? 'postMessage' : 'refresh',
			) );
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $id, array(
					'label'    => sprintf( __( '%s Profile URL', 'infopreneur' ), esc_html( $site['name'] ) ),
					'type'     => 'text',
					'section'  => 'social',
					'settings' => $id,
				)
			) );
		}

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

	/**
	 * Sanitize: Post Layout
	 *
	 * @param string $input
	 *
	 * @access public
	 * @since  1.0.0
	 * @return string
	 */
	public function sanitize_post_layout( $input ) {
		$allowed = array( 'grid-2-col', 'grid-3-col', 'list' );

		if ( in_array( $input, $allowed ) ) {
			return wp_strip_all_tags( $input );
		}

		return 'list';
	}

	/**
	 * Sanitize: Summary Type
	 *
	 * @param string $input
	 *
	 * @access public
	 * @since  1.0.0
	 * @return string
	 */
	public function sanitize_summary_type( $input ) {
		$allowed = array( 'full', 'excerpts', 'none' );

		if ( in_array( $input, $allowed ) ) {
			return wp_strip_all_tags( $input );
		}

		return 'excerpts';
	}

	/**
	 * Sanitize: Featured Overlay
	 *
	 * Must be a number between 0 and 1.
	 *
	 * @param $input
	 *
	 * @access public
	 * @since  1.0.0
	 * @return float|int
	 */
	public function sanitize_featured_overlay( $input ) {
		if ( ! is_numeric( $input ) ) {
			$input = 0;
		}

		if ( $input < 0 ) {
			$sanitized_input = 0;
		} elseif ( $input > 1 ) {
			$sanitized_input = 1;
		} else {
			$sanitized_input = (float) $input;
		}

		return $sanitized_input;
	}

}