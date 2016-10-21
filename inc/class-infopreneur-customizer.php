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
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customizer_controls_js' ) );
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
			'primary_color'                           => '#ff7a5a',
			'secondary_color'                         => '#00aaa0',
			'top_bar_bg'                              => '#ffffff',
			'top_bar_color'                           => '#333333',
			'top_bar_hover_color'                     => '#ff7a5a',
			'footer_color'                            => '#96dad6',
			'footer_hover_color'                      => '#ffffff',
			'lead_box_bg'                             => '#00aaa0',
			'sticky_menu'                             => false,
			'layout_style'                            => 'full',
			'post_layout'                             => 'list',
			'number_full_posts'                       => 1,
			'summary_type'                            => 'excerpts',
			'thumbnail_align'                         => 'aligncenter',
			'excerpt_length'                          => 30,
			'meta_config_blog'                        => '[category]',
			'meta_position_blog'                      => 'below',
			'show_featured_blog'                      => true,
			'sidebar_left_blog'                       => false,
			'sidebar_right_blog'                      => true,
			'suppress_archive_headings'               => false,
			'meta_config_single'                      => '[date] &ndash; [category] &ndash; [comments]',
			'meta_position_single'                    => 'below',
			'hide_featured_image'                     => false,
			'show_featured_single'                    => true,
			'sidebar_left_single'                     => false,
			'sidebar_right_single'                    => true,
			'show_featured_page'                      => true,
			'sidebar_left_page'                       => false,
			'sidebar_right_page'                      => true,
			'edd_page_title'                          => esc_html__( 'Shop', 'infopreneur' ),
			'edd_page_desc'                           => '',
			'show_featured_edd_archive'               => true,
			'sidebar_left_edd_archive'                => false,
			'sidebar_right_edd_archive'               => false,
			'show_featured_edd_single'                => true,
			'sidebar_left_edd_single'                 => false,
			'sidebar_right_edd_single'                => true,
			'show_featured_wc_archive'                => true,
			'sidebar_left_wc_archive'                 => false,
			'sidebar_right_wc_archive'                => false,
			'show_featured_wc_single'                 => true,
			'sidebar_left_wc_single'                  => false,
			'sidebar_right_wc_single'                 => false,
			'portfolio_page_title'                    => esc_html__( 'Portfolio', 'infopreneur' ),
			'portfolio_page_desc'                     => '',
			'portfolio_display_types'                 => false,
			'portfolio_display_tags'                  => false,
			'portfolio_display_content'               => false,
			'portfolio_include_type'                  => '',
			'portfolio_include_tag'                   => '',
			'portfolio_columns'                       => 2,
			'portfolio_showposts'                     => - 1,
			'portfolio_order'                         => 'asc',
			'portfolio_orderby'                       => 'date',
			'show_featured_jetpack_portfolio_archive' => true,
			'sidebar_left_jetpack_portfolio_archive'  => false,
			'sidebar_right_jetpack_portfolio_archive' => false,
			'featured_bg_color'                       => '#00aaa0',
			'featured_bg_image'                       => get_template_directory_uri() . '/assets/images/featured-bg.jpg',
			'featured_bg_position'                    => 'center-top',
			'featured_overlay'                        => 0.5,
			'featured_alignment'                      => 'featured-centered',
			'featured_text_color'                     => '#ffffff',
			'featured_heading'                        => __( 'Run your blog like a boss', 'infopreneur' ),
			'featured_desc'                           => __( 'Join my tribe of over 1,000 infopreneurs and self-starters to take your blog to the next level.', 'infopreneur' ),
			'featured_url'                            => home_url( '/' ),
			'featured_button'                         => __( 'Get Started', 'infopreneur' ),
			'featured_button_bg_color'                => '#ff7a5a',
			'featured_button_text_color'              => '#ffffff',
			'show_featured_home'                      => true,
			'show_below_header_widget_area'           => true,
			'home_widget_1_cols'                      => 1,
			'home_widget_2_cols'                      => 3,
			'home_widget_3_cols'                      => 1,
			'search_icon'                             => true,
			'footer_text'                             => sprintf( __( 'Copyright &copy; %s.', 'infopreneur' ), date( 'Y' ) . ' ' . '<a href="' . home_url( '/' ) . '">' . get_bloginfo( 'name' ) . '</a>' )
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

		// Menu Settings
		$wp_customize->add_section( 'info_menu_settings', array(
			'title'    => __( 'Menu Settings', 'infopreneur' ),
			'panel'    => 'nav_menus',
			'priority' => 1
		) );

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

		// EDD Archive
		$wp_customize->add_section( 'edd_archive', array(
			'title'       => __( 'EDD Archive', 'infopreneur' ),
			'description' => __( 'Easy Digital Downloads product archive.', 'infopreneur' ),
			'panel'       => 'layout',
		) );

		// EDD Single
		$wp_customize->add_section( 'edd_single', array(
			'title'       => __( 'EDD Single', 'infopreneur' ),
			'description' => __( 'Easy Digital Downloads single product page.', 'infopreneur' ),
			'panel'       => 'layout',
		) );

		// WC Archive
		$wp_customize->add_section( 'wc_archive', array(
			'title'       => __( 'Shop Archive', 'infopreneur' ),
			'description' => __( 'WooCommerce shop archive page.', 'infopreneur' ),
			'panel'       => 'layout',
		) );

		// WC Single
		$wp_customize->add_section( 'wc_single', array(
			'title'       => __( 'Shop Single', 'infopreneur' ),
			'description' => __( 'WooCommerce single product page.', 'infopreneur' ),
			'panel'       => 'layout',
		) );

		// Portfolio Archive
		$wp_customize->add_section( 'portfolio_archive', array(
			'title'       => __( 'Portfolio', 'infopreneur' ),
			'description' => __( 'Portfolio archive.', 'infopreneur' ),
			'panel'       => 'layout'
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
		$this->menu_section( $wp_customize );
		$this->featured_section( $wp_customize );
		$this->global_layout_section( $wp_customize );
		$this->blog_archive_section( $wp_customize );
		$this->single_post_section( $wp_customize );
		$this->single_page_section( $wp_customize );
		$this->edd_archive_section( $wp_customize );
		$this->edd_single_section( $wp_customize );
		$this->wc_archive_section( $wp_customize );
		$this->wc_single_section( $wp_customize );
		$this->portfolio_archive_section( $wp_customize );
		$this->static_front_page_section( $wp_customize );
		$this->social_media_section( $wp_customize );
		$this->footer_section( $wp_customize );

		/*
		 * Change existing settings.
		 */
		$wp_customize->get_section( 'static_front_page' )->description = __( 'Infopreneur supports a static front page. To use the custom homepage template, select "a static page" below, then edit that page and change the template to "Homepage".', 'infopreneur' );

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

		$portfolio = array(
			'portfolio_display_types',
			'portfolio_display_tags',
			'portfolio_display_content',
			'portfolio_include_type',
			'portfolio_include_tag',
			'portfolio_columns',
			'portfolio_showposts',
			'portfolio_order',
			'portfolio_orderby'
		);

		foreach ( $portfolio as $portfolio_option ) {
			$wp_customize->selective_refresh->add_partial( $portfolio_option, array(
				'selector'        => '#jetpack-portfolio-grid',
				'settings'        => $portfolio_option,
				'render_callback' => function () {
					infopreneur_jetpack_portfolio();
				}
			) );
		}

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
	 * Customizer Controls JavaScript
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function customizer_controls_js() {

		// Use minified libraries if SCRIPT_DEBUG is turned off
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		wp_enqueue_script(
			'infopreneur-customizer-controls',
			get_template_directory_uri() . '/assets/js/customizer-controls' . $suffix . '.js',
			array( 'jquery' ),
			$this->version,
			true
		);

		$download_url = false;

		if ( function_exists( 'edd_get_random_download' ) ) {
			$downloads = edd_get_random_download();

			if ( count( $downloads ) && array_key_exists( 0, $downloads ) && is_numeric( $downloads[0] ) ) {
				$download_url = get_permalink( $downloads[0] );
			}
		}

		wp_localize_script( 'infopreneur-customizer-controls', 'Info_Customizer', array( 'download_url' => $download_url ) );

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

		/* Secondary Colour */
		$wp_customize->add_setting( 'secondary_color', array(
			'default'           => self::defaults( 'secondary_color' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'secondary_color', array(
			'label'       => esc_html__( 'Secondary Color', 'infopreneur' ),
			'description' => __( 'Accents, footer background.', 'infopreneur' ),
			'section'     => 'colors',
			'settings'    => 'secondary_color',
		) ) );

		/* Top Bar BG */
		$wp_customize->add_setting( 'top_bar_bg', array(
			'default'           => self::defaults( 'top_bar_bg' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'top_bar_bg', array(
			'label'       => esc_html__( 'Top Bar BG', 'infopreneur' ),
			'description' => __( 'Background behind the top navigation and social links.', 'infopreneur' ),
			'section'     => 'colors',
			'settings'    => 'top_bar_bg',
		) ) );

		/* Top Bar Text Colour */
		$wp_customize->add_setting( 'top_bar_color', array(
			'default'           => self::defaults( 'top_bar_color' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'top_bar_color', array(
			'label'       => esc_html__( 'Top Bar Link Color', 'infopreneur' ),
			'description' => __( 'Top navigation link color.', 'infopreneur' ),
			'section'     => 'colors',
			'settings'    => 'top_bar_color',
		) ) );

		/* Top Bar Text Colour - Hover */
		$wp_customize->add_setting( 'top_bar_hover_color', array(
			'default'           => self::defaults( 'top_bar_hover_color' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'top_bar_hover_color', array(
			'label'       => esc_html__( 'Top Bar Link Color (Hover)', 'infopreneur' ),
			'description' => __( 'Top navigation color when hovering over a link.', 'infopreneur' ),
			'section'     => 'colors',
			'settings'    => 'top_bar_hover_color',
		) ) );

		/* Footer Text Colour */
		$wp_customize->add_setting( 'footer_color', array(
			'default'           => self::defaults( 'footer_color' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_color', array(
			'label'       => esc_html__( 'Footer Text Color', 'infopreneur' ),
			'section'     => 'colors',
			'settings'    => 'footer_color',
		) ) );

		/* Footer Text Colour - Hover */
		$wp_customize->add_setting( 'footer_hover_color', array(
			'default'           => self::defaults( 'footer_hover_color' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_hover_color', array(
			'label'       => esc_html__( 'Footer Link Color (Hover)', 'infopreneur' ),
			'section'     => 'colors',
			'settings'    => 'footer_hover_color',
		) ) );

		/* Lead Box BG */
		$wp_customize->add_setting( 'lead_box_bg', array(
			'default'           => self::defaults( 'lead_box_bg' ),
			'sanitize_callback' => 'sanitize_hex_color'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'lead_box_bg', array(
			'label'       => esc_html__( 'Lead Box BG', 'infopreneur' ),
			'description' => __( 'Background color on the Lead Box page template.', 'infopreneur' ),
			'section'     => 'colors',
			'settings'    => 'lead_box_bg',
		) ) );

	}

	/**
	 * Section: Menus
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0.0
	 * @return void
	 */
	private function menu_section( $wp_customize ) {

		$wp_customize->add_setting( 'sticky_menu', array(
			'default'           => self::defaults( 'sticky_menu' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sticky_menu', array(
			'label'    => esc_html__( 'Stick menu to top of page', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'info_menu_settings',
			'settings' => 'sticky_menu'
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

		/* Button URL */
		$wp_customize->add_setting( 'featured_url', array(
			'default'           => self::defaults( 'featured_url' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'featured_url', array(
			'label'    => esc_html__( 'Button URL', 'infopreneur' ),
			'section'  => 'featured',
			'settings' => 'featured_url',
		) ) );

		/* Button Text */
		$wp_customize->add_setting( 'featured_button', array(
			'default'           => self::defaults( 'featured_button' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'featured_button', array(
			'label'    => esc_html__( 'Button Text', 'infopreneur' ),
			'section'  => 'featured',
			'settings' => 'featured_button',
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
		) ) );

		/* Featured Area */
		$wp_customize->add_setting( 'show_featured_single', array(
			'default'           => self::defaults( 'show_featured_single' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'show_featured_single', array(
			'label'    => esc_html__( 'Show featured area', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'single_post',
			'settings' => 'show_featured_single',
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
			'section'  => 'single_page',
			'settings' => 'show_featured_page',
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
		) ) );

	}

	/**
	 * Section: EDD Archive
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0.0
	 * @return void
	 */
	private function edd_archive_section( $wp_customize ) {

		if ( ! class_exists( 'Easy_Digital_Downloads' ) ) {
			return;
		}

		/* Shop Page Title */
		$wp_customize->add_setting( 'edd_page_title', array(
			'default'           => self::defaults( 'edd_page_title' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'edd_page_title', array(
			'label'    => esc_html__( 'Page Title', 'infopreneur' ),
			'section'  => 'edd_archive',
			'settings' => 'edd_page_title',
		) ) );

		/* Shop Page Desc */
		$wp_customize->add_setting( 'edd_page_desc', array(
			'default'           => self::defaults( 'edd_page_desc' ),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'edd_page_desc', array(
			'label'    => esc_html__( 'Page Description', 'infopreneur' ),
			'type'     => 'textarea',
			'section'  => 'edd_archive',
			'settings' => 'edd_page_desc',
		) ) );

		/* Featured Area */
		$wp_customize->add_setting( 'show_featured_edd_archive', array(
			'default'           => self::defaults( 'show_featured_edd_archive' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'show_featured_edd_archive', array(
			'label'    => esc_html__( 'Show featured area', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'edd_archive',
			'settings' => 'show_featured_edd_archive',
		) ) );

		/* Left Sidebar */
		$wp_customize->add_setting( 'sidebar_left_edd_archive', array(
			'default'           => self::defaults( 'sidebar_left_edd_archive' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_left_edd_archive', array(
			'label'    => esc_html__( 'Show left sidebar', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'edd_archive',
			'settings' => 'sidebar_left_edd_archive',
		) ) );

		/* Right Sidebar */
		$wp_customize->add_setting( 'sidebar_right_edd_archive', array(
			'default'           => self::defaults( 'sidebar_right_edd_archive' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_right_edd_archive', array(
			'label'    => esc_html__( 'Show right sidebar', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'edd_archive',
			'settings' => 'sidebar_right_edd_archive',
		) ) );

	}

	/**
	 * Section: EDD Single Page
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0.0
	 * @return void
	 */
	private function edd_single_section( $wp_customize ) {

		if ( ! class_exists( 'Easy_Digital_Downloads' ) ) {
			return;
		}

		/* Featured Area */
		$wp_customize->add_setting( 'show_featured_edd_single', array(
			'default'           => self::defaults( 'show_featured_edd_single' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'show_featured_edd_single', array(
			'label'    => esc_html__( 'Show featured area', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'edd_single',
			'settings' => 'show_featured_edd_single',
		) ) );

		/* Left Sidebar */
		$wp_customize->add_setting( 'sidebar_left_edd_single', array(
			'default'           => self::defaults( 'sidebar_left_edd_single' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_left_edd_single', array(
			'label'    => esc_html__( 'Show left sidebar', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'edd_single',
			'settings' => 'sidebar_left_edd_single',
		) ) );

		/* Right Sidebar */
		$wp_customize->add_setting( 'sidebar_right_edd_single', array(
			'default'           => self::defaults( 'sidebar_right_edd_single' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_right_edd_single', array(
			'label'    => esc_html__( 'Show right sidebar', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'edd_single',
			'settings' => 'sidebar_right_edd_single',
		) ) );

	}

	/**
	 * Section: WooCommerce Archive
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0.0
	 * @return void
	 */
	private function wc_archive_section( $wp_customize ) {

		if ( ! infopreneur_has_wc() ) {
			return;
		}

		/* Featured Area */
		$wp_customize->add_setting( 'show_featured_wc_archive', array(
			'default'           => self::defaults( 'show_featured_wc_archive' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'show_featured_wc_archive', array(
			'label'    => esc_html__( 'Show featured area', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'wc_archive',
			'settings' => 'show_featured_wc_archive',
		) ) );

		/* Left Sidebar */
		$wp_customize->add_setting( 'sidebar_left_wc_archive', array(
			'default'           => self::defaults( 'sidebar_left_wc_archive' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_left_wc_archive', array(
			'label'    => esc_html__( 'Show left sidebar', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'wc_archive',
			'settings' => 'sidebar_left_wc_archive',
		) ) );

		/* Right Sidebar */
		$wp_customize->add_setting( 'sidebar_right_wc_archive', array(
			'default'           => self::defaults( 'sidebar_right_wc_archive' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_right_wc_archive', array(
			'label'    => esc_html__( 'Show right sidebar', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'wc_archive',
			'settings' => 'sidebar_right_wc_archive',
		) ) );

	}

	/**
	 * Section: WooCommerce Single Page
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0.0
	 * @return void
	 */
	private function wc_single_section( $wp_customize ) {

		if ( ! infopreneur_has_wc() ) {
			return;
		}

		/* Featured Area */
		$wp_customize->add_setting( 'show_featured_wc_single', array(
			'default'           => self::defaults( 'show_featured_wc_single' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'show_featured_wc_single', array(
			'label'    => esc_html__( 'Show featured area', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'wc_single',
			'settings' => 'show_featured_wc_single',
		) ) );

		/* Left Sidebar */
		$wp_customize->add_setting( 'sidebar_left_wc_single', array(
			'default'           => self::defaults( 'sidebar_left_wc_single' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_left_wc_single', array(
			'label'    => esc_html__( 'Show left sidebar', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'wc_single',
			'settings' => 'sidebar_left_wc_single',
		) ) );

		/* Right Sidebar */
		$wp_customize->add_setting( 'sidebar_right_wc_single', array(
			'default'           => self::defaults( 'sidebar_right_wc_single' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_right_wc_single', array(
			'label'    => esc_html__( 'Show right sidebar', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'wc_single',
			'settings' => 'sidebar_right_wc_single',
		) ) );

	}

	/**
	 * Section: Portfolio Archive
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0.0
	 * @return void
	 */
	private function portfolio_archive_section( $wp_customize ) {

		if ( ! class_exists( 'Jetpack' ) ) {
			return;
		}

		if ( ! Jetpack::is_module_active( 'custom-content-types' ) ) {
			return;
		}

		/* Page Title */
		$wp_customize->add_setting( 'portfolio_page_title', array(
			'default'           => self::defaults( 'portfolio_page_title' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'portfolio_page_title', array(
			'label'    => esc_html__( 'Page Title', 'infopreneur' ),
			'section'  => 'portfolio_archive',
			'settings' => 'portfolio_page_title',
		) ) );

		/* Page Desc */
		$wp_customize->add_setting( 'portfolio_page_desc', array(
			'default'           => self::defaults( 'portfolio_page_desc' ),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'portfolio_page_desc', array(
			'label'    => esc_html__( 'Page Description', 'infopreneur' ),
			'type'     => 'textarea',
			'section'  => 'portfolio_archive',
			'settings' => 'portfolio_page_desc',
		) ) );

		/* Display Types */
		$wp_customize->add_setting( 'portfolio_display_types', array(
			'default'           => self::defaults( 'portfolio_display_types' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			'transport'         => $wp_customize->selective_refresh ? 'postMessage' : 'refresh'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'portfolio_display_types', array(
			'label'    => esc_html__( 'Display project types', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'portfolio_archive',
			'settings' => 'portfolio_display_types',
		) ) );

		/* Display Tags */
		$wp_customize->add_setting( 'portfolio_display_tags', array(
			'default'           => self::defaults( 'portfolio_display_tags' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			'transport'         => $wp_customize->selective_refresh ? 'postMessage' : 'refresh'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'portfolio_display_tags', array(
			'label'    => esc_html__( 'Display project tags', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'portfolio_archive',
			'settings' => 'portfolio_display_tags',
		) ) );

		/* Display Content */
		$wp_customize->add_setting( 'portfolio_display_content', array(
			'default'           => self::defaults( 'portfolio_display_content' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			'transport'         => $wp_customize->selective_refresh ? 'postMessage' : 'refresh'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'portfolio_display_content', array(
			'label'    => esc_html__( 'Display project content', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'portfolio_archive',
			'settings' => 'portfolio_display_content',
		) ) );

		/* Include Type */
		$wp_customize->add_setting( 'portfolio_include_type', array(
			'default'           => self::defaults( 'portfolio_include_type' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => $wp_customize->selective_refresh ? 'postMessage' : 'refresh'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'portfolio_include_type', array(
			'label'       => esc_html__( 'Project Type(s)', 'infopreneur' ),
			'description' => __( 'Leave blank to include all project types, or enter a comma-separated list of Project Type slugs to only display those.', 'infopreneur' ),
			'section'     => 'portfolio_archive',
			'settings'    => 'portfolio_include_type',
		) ) );

		/* Include Tags */
		$wp_customize->add_setting( 'portfolio_include_tag', array(
			'default'           => self::defaults( 'portfolio_include_tag' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => $wp_customize->selective_refresh ? 'postMessage' : 'refresh'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'portfolio_include_tag', array(
			'label'       => esc_html__( 'Project Tag(s)', 'infopreneur' ),
			'description' => __( 'Leave blank to include all project tags, or enter a comma-separated list of Project Tag slugs to only display those.', 'infopreneur' ),
			'section'     => 'portfolio_archive',
			'settings'    => 'portfolio_include_tag',
		) ) );

		/* Columns */
		$wp_customize->add_setting( 'portfolio_columns', array(
			'default'           => self::defaults( 'portfolio_columns' ),
			'sanitize_callback' => 'absint',
			'transport'         => $wp_customize->selective_refresh ? 'postMessage' : 'refresh'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'portfolio_columns', array(
			'label'    => esc_html__( 'Columns', 'infopreneur' ),
			'type'     => 'select',
			'choices'  => array(
				1 => esc_html__( '1 Column', 'infopreneur' ),
				2 => esc_html__( '2 Columns', 'infopreneur' ),
				3 => esc_html__( '3 Columns', 'infopreneur' ),
				4 => esc_html__( '4 Columns', 'infopreneur' ),
				5 => esc_html__( '5 Columns', 'infopreneur' ),
				6 => esc_html__( '6 Columns', 'infopreneur' )
			),
			'section'  => 'portfolio_archive',
			'settings' => 'portfolio_columns',
		) ) );

		/* Columns */
		$wp_customize->add_setting( 'portfolio_showposts', array(
			'default'           => self::defaults( 'portfolio_showposts' ),
			'sanitize_callback' => 'intval',
			'transport'         => $wp_customize->selective_refresh ? 'postMessage' : 'refresh'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'portfolio_showposts', array(
			'label'       => esc_html__( 'Number of Projects', 'infopreneur' ),
			'description' => sprintf( __( 'Enter %s to display all projects.', 'infopreneur' ), '<code>-1</code>' ),
			'type'        => 'number',
			'section'     => 'portfolio_archive',
			'settings'    => 'portfolio_showposts',
		) ) );

		/* Order */
		$wp_customize->add_setting( 'portfolio_order', array(
			'default'           => self::defaults( 'portfolio_order' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => $wp_customize->selective_refresh ? 'postMessage' : 'refresh'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'portfolio_order', array(
			'label'    => esc_html__( 'Order', 'infopreneur' ),
			'type'     => 'select',
			'choices'  => array(
				'asc'  => esc_html__( 'Ascending', 'infopreneur' ),
				'desc' => esc_html__( 'Descending', 'infopreneur' )
			),
			'section'  => 'portfolio_archive',
			'settings' => 'portfolio_order',
		) ) );

		/* Orderby */
		$wp_customize->add_setting( 'portfolio_orderby', array(
			'default'           => self::defaults( 'portfolio_orderby' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => $wp_customize->selective_refresh ? 'postMessage' : 'refresh'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'portfolio_orderby', array(
			'label'    => esc_html__( 'Orderby', 'infopreneur' ),
			'type'     => 'select',
			'choices'  => array(
				'author' => esc_html__( 'Author Name', 'infopreneur' ),
				'date'   => esc_html__( 'Date', 'infopreneur' ),
				'title'  => esc_html__( 'Project Title', 'infopreneur' ),
				'rand'   => esc_html__( 'Random', 'infopreneur' )
			),
			'section'  => 'portfolio_archive',
			'settings' => 'portfolio_orderby',
		) ) );

		/* Featured Area */
		$wp_customize->add_setting( 'show_featured_jetpack_portfolio_archive', array(
			'default'           => self::defaults( 'show_featured_jetpack_portfolio_archive' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'show_featured_jetpack_portfolio_archive', array(
			'label'    => esc_html__( 'Show featured area', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'portfolio_archive',
			'settings' => 'show_featured_jetpack_portfolio_archive',
		) ) );

		/* Left Sidebar */
		$wp_customize->add_setting( 'sidebar_left_jetpack_portfolio_archive', array(
			'default'           => self::defaults( 'sidebar_left_jetpack_portfolio_archive' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_left_jetpack_portfolio_archive', array(
			'label'    => esc_html__( 'Show left sidebar', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'portfolio_archive',
			'settings' => 'sidebar_left_jetpack_portfolio_archive',
		) ) );

		/* Right Sidebar */
		$wp_customize->add_setting( 'sidebar_right_jetpack_portfolio_archive', array(
			'default'           => self::defaults( 'sidebar_right_jetpack_portfolio_archive' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_right_jetpack_portfolio_archive', array(
			'label'    => esc_html__( 'Show right sidebar', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'portfolio_archive',
			'settings' => 'sidebar_right_jetpack_portfolio_archive',
		) ) );

	}

	/**
	 * Section: Static Front Page
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0.0
	 * @return void
	 */
	private function static_front_page_section( $wp_customize ) {

		/* Featured Area */
		$wp_customize->add_setting( 'show_featured_home', array(
			'default'           => self::defaults( 'show_featured_home' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'show_featured_home', array(
			'label'    => esc_html__( 'Show featured area', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'static_front_page',
			'settings' => 'show_featured_home',
		) ) );

		/* Below Header Area */
		$wp_customize->add_setting( 'show_below_header_widget_area', array(
			'default'           => self::defaults( 'show_below_header_widget_area' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' )
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'show_below_header_widget_area', array(
			'label'    => esc_html__( 'Show below header widget area', 'infopreneur' ),
			'type'     => 'checkbox',
			'section'  => 'static_front_page',
			'settings' => 'show_below_header_widget_area',
		) ) );

		/* Home - 1 - Cols */
		$wp_customize->add_setting( 'home_widget_1_cols', array(
			'default'           => self::defaults( 'home_widget_1_cols' ),
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'home_widget_1_cols', array(
			'label'       => esc_html__( 'Widget Area #1', 'infopreneur' ),
			'description' => __( 'Choose the number of columns for homepage widget area #1.', 'infopreneur' ),
			'type'        => 'select',
			'choices'     => array(
				1 => __( '1 Column (span full width)', 'infopreneur' ),
				2 => __( '2 Columns', 'infopreneur' ),
				3 => __( '3 Columns', 'infopreneur' ),
				4 => __( '4 Columns', 'infopreneur' )
			),
			'section'     => 'static_front_page',
			'settings'    => 'home_widget_1_cols',
		) ) );

		/* Home - 2 - Cols */
		$wp_customize->add_setting( 'home_widget_2_cols', array(
			'default'           => self::defaults( 'home_widget_2_cols' ),
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'home_widget_2_cols', array(
			'label'       => esc_html__( 'Widget Area #2', 'infopreneur' ),
			'description' => __( 'Choose the number of columns for homepage widget area #2.', 'infopreneur' ),
			'type'        => 'select',
			'choices'     => array(
				1 => __( '1 Column (span full width)', 'infopreneur' ),
				2 => __( '2 Columns', 'infopreneur' ),
				3 => __( '3 Columns', 'infopreneur' ),
				4 => __( '4 Columns', 'infopreneur' )
			),
			'section'     => 'static_front_page',
			'settings'    => 'home_widget_2_cols',
		) ) );

		/* Home - 3 - Cols */
		$wp_customize->add_setting( 'home_widget_3_cols', array(
			'default'           => self::defaults( 'home_widget_3_cols' ),
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'home_widget_3_cols', array(
			'label'       => esc_html__( 'Widget Area #3', 'infopreneur' ),
			'description' => __( 'Choose the number of columns for homepage widget area #3.', 'infopreneur' ),
			'type'        => 'select',
			'choices'     => array(
				1 => __( '1 Column (span full width)', 'infopreneur' ),
				2 => __( '2 Columns', 'infopreneur' ),
				3 => __( '3 Columns', 'infopreneur' ),
				4 => __( '4 Columns', 'infopreneur' )
			),
			'section'     => 'static_front_page',
			'settings'    => 'home_widget_3_cols',
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

		/* Search Icon */
		$wp_customize->add_setting( 'search_icon', array(
			'default'           => self::defaults( 'search_icon' ),
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'search_icon', array(
				'label'    => __( 'Show search icon in header', 'infopreneur' ),
				'type'     => 'checkbox',
				'section'  => 'social',
				'settings' => 'search_icon',
			)
		) );

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
	 * Sanitize: Checkbox
	 *
	 * @param string $input
	 *
	 * @access public
	 * @since  1.0.0
	 * @return string
	 */
	public function sanitize_checkbox( $input ) {
		return $input ? true : false;
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