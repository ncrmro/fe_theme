<?php
/**
 * components functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Floral_Events_Theme
 */

if ( ! function_exists( 'fe_theme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the aftercomponentsetup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function fe_theme_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on components, use a find and replace
	 * to change 'fe_theme' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'fe_theme', get_template_directory() . '/languages' );

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

	add_image_size('fe_theme-featured-image', 2560, 9999);
	add_image_size( 'fe_theme-hero', 2560, 900, true );
	add_image_size( 'fe_theme-thumbnail-avatar', 100, 100, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Top', 'fe_theme' ),
	) );

	/**
	 * Add support for core custom logo.
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 200,
		'width'       => 200,
		'flex-width'  => true,
		'flex-height' => true,
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

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'fe_theme_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'fe_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function fe_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'fe_theme_content_width', 1920 );
}
add_action( 'after_setup_theme', 'fe_theme_content_width', 0 );

/**
 * Return early if Custom Logos are not available.
 *
 * @todo Remove after WP 4.7
 */
function fe_theme_the_custom_logo() {
	if ( ! function_exists( 'the_custom_logo' ) ) {
		return;
	} else {
		the_custom_logo();
	}
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function fe_theme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'fe_theme' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'fe_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function fe_theme_scripts() {
//	/*wp_enqueue_style( 'fe_theme-style', get_stylesheet_uri() );*

	wp_enqueue_script( 'fe_theme-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script('scheduling-form', get_template_directory_uri() . '/assets/js/schedule-form.js', array(), '20151215', true);


	wp_enqueue_script( 'fe_theme-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'fe_theme_scripts' );

function wpfa_add_slicknav()
{
	/** Styles handles by css*/
	//wp_enqueue_style( 'SlickNav-CSS-main', get_template_directory_uri() . '/slicknav/slicknav.css', array(), '1.0.1', 'screen' );
	/** Enqueue the SlickNav JavaScript with jQuery dependency */
	wp_enqueue_script('SlickNav-JS-main', get_template_directory_uri() . '/slicknav/jquery.slicknav.min.js', array('jquery'), '1.0.1', true);
	/** Enqueue SlickNav initialization script with jQuery and SlickNav JavaScript main dependencies */
	wp_enqueue_script(
		'SlickNav-init', get_template_directory_uri() . '/slicknav/wpfa-slicknav-init.js', array(
		'jquery',
		'SlickNav-JS-main'
	), '1.0', true
	);
	/** Enqueue SlickNav mobile layout only styles with SlickNav CSS main dependency */
	wp_enqueue_style('SlickNav-layout', get_template_directory_uri() . '/slicknav/wpfa-slicknav.css', array('SlickNav-CSS-main'), '1.0', 'screen');
}

add_action('wp_enqueue_scripts', 'wpfa_add_slicknav');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
