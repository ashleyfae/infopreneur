<?php
/**
 * Theme Functions
 *
 * Sets up WordPress features and pulls in other files.
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

if ( ! function_exists( 'infopreneur_setup' ) ) :
	/**
	 * Setup
	 *
	 * Sets up theme definitions and registers support
	 * for WordPress features.
	 *
	 * @since 1.0
	 * @return void
	 */
	function infopreneur_setup() {

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 */
		load_theme_textdomain( 'infopreneur', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// Register navigation menu.
		register_nav_menus( array(
			'primary' => esc_html__( 'Top Menu', 'infopreneur' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'infopreneur/custom-background-args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

	}
endif;

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @todo Check
 *
 * @global int $content_width
 *
 * @since 1.0
 * @return void
 */
function infopreneur_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'infopreneur/content-width', 642 );
}

add_action( 'after_setup_theme', 'infopreneur_content_width', 0 );

/**
 * Register widget areas.
 *
 * @link  https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 *
 * @since 1.0
 * @return void
 */
function infopreneur_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'infopreneur' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Sidebar on the right-hand side.', 'infopreneur' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}

add_action( 'widgets_init', 'infopreneur_widgets_init' );

/**
 * Enqueue scripts and styles.
 *
 * @uses  wp_get_theme()
 *
 * @since 1.0
 * @return void
 */
function infopreneur_scripts() {
	$infopreneur    = wp_get_theme();
	$version = $infopreneur->get( 'Version' );

	wp_enqueue_style( 'infopreneur-google-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i', array(), $version );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), '4.6.1' );
	wp_enqueue_style( 'infopreneur', get_stylesheet_uri(), array(), $version );
	wp_add_inline_style( 'infopreneur', infopreneur_get_custom_css() );

	wp_enqueue_script( 'infopreneur', get_template_directory_uri() . '/assets/js/scripts.js', array( 'jquery' ), $version, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'infopreneur_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Include our template functions.
 */
require_once get_template_directory() . '/inc/template-tags.php';

/**
 * Actions that are hooked into template files to help build the layout.
 */
require_once get_template_directory() . '/inc/layout.php';

/**
 * Include our extra functions.
 */
require_once get_template_directory() . '/inc/extras.php';

/**
 * Include the Customizer settings.
 */
require_once get_template_directory() . '/inc/class-infopreneur-customizer.php';