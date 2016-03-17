<?php
/**
 * functions and definitions
 *
 */




// load the kohette framework (handy functions!)
require_once('kohette-framework/kohette-framework.php');


// create the basic config of our theme
$theme_config = array(
		'prefix' => '_amymag_',
        'textdomain' => 'literatum',
);


// create a kohette framework object
$theme = new kohette_framework($theme_config);




// load the theme features ----------------------------------------------------------------

$plugins = array();

foreach (glob(dirname(__FILE__) . "/theme-features/*", GLOB_ONLYDIR) as $filename) {

    $plugins[] = array(
		'name' => basename($filename),
		'source' => $filename . '/' . basename($filename) . '.php',
	);

};

$theme->load_plugins($plugins);
$theme->theme_activation_hook(); // load the default options when theme is activated

// ----------------------------------------------------------------------------------------
















// define a basic/default layout with

if ( ! isset( $content_width ) ) $content_width = 960;







if ( ! function_exists( 'KTT_theme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function KTT_theme_setup() {


	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'literatum', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );


	// posts formats
	add_theme_support( 'post-formats', array( 'link') );



	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
		'caption',
	) );
}
endif; // amymag_setup
add_action( 'after_setup_theme', 'KTT_theme_setup' );







/**
 * Enqueue scripts and styles.
 */
function KTT_theme_scripts() {


	wp_enqueue_style( 'literatum-style', get_template_directory_uri() . '/css/style.css' );
	wp_enqueue_style( 'literatum-style-reset', get_template_directory_uri() . '/css/style-reset.css' );
	wp_enqueue_style( 'literatum-style-typography', get_template_directory_uri() . '/css/style-typography.css' );
	wp_enqueue_style( 'literatum-style-elements', get_template_directory_uri() . '/css/style-elements.css' );
	wp_enqueue_style( 'literatum-style-forms', get_template_directory_uri() . '/css/style-forms.css' );
	wp_enqueue_style( 'literatum-style-aligments', get_template_directory_uri() . '/css/style-aligments.css' );
	wp_enqueue_style( 'literatum-style-links', get_template_directory_uri() . '/css/style-links.css' );
	wp_enqueue_style( 'literatum-style-clearings', get_template_directory_uri() . '/css/style-clearings.css' );
	wp_enqueue_style( 'literatum-style-header', get_template_directory_uri() . '/css/style-header.css' );
	wp_enqueue_style( 'literatum-style-menus', get_template_directory_uri() . '/css/style-menus.css' );
	wp_enqueue_style( 'literatum-style-cards', get_template_directory_uri() . '/css/style-cards.css' );
	wp_enqueue_style( 'literatum-style-articles', get_template_directory_uri() . '/css/style-articles.css' );
	wp_enqueue_style( 'literatum-style-comments', get_template_directory_uri() . '/css/style-comments.css' );
	wp_enqueue_style( 'literatum-style-pushmenu', get_template_directory_uri() . '/css/style-pushmenu.css' );
	wp_enqueue_style( 'literatum-style-author', get_template_directory_uri() . '/css/style-author.css' );
	wp_enqueue_style( 'literatum-style-loops', get_template_directory_uri() . '/css/style-loops.css' );

	wp_enqueue_style( 'literatum-flexboxgrid', get_template_directory_uri() . '/css/flexboxgrid.css' );
	wp_enqueue_style( 'literatum-icons', get_template_directory_uri() . '/css/icons.css' );
	wp_enqueue_style( 'literatum-animate', get_template_directory_uri() . '/css/animate.css' );
	wp_enqueue_style( 'literatum-nprogress', get_template_directory_uri() . '/css/nprogress.css' );
	// wp_enqueue_style( 'literatum-fluidbox', '//cdnjs.cloudflare.com/ajax/libs/fluidbox/2.0.3/css/fluidbox.min.css' );
	// wp_enqueue_style( 'literatum-jgallery', get_template_directory_uri() . '/css/justifiedGallery.min.css' );



	wp_enqueue_script('jquery');
//	wp_enqueue_script( 'fluidbox', '//cdnjs.cloudflare.com/ajax/libs/fluidbox/2.0.3/js/jquery.fluidbox.min.js', array('jquery', 'debounce'), '5', true );
//	wp_enqueue_script( 'jgallery', get_template_directory_uri() . '/js/jquery.justifiedGallery.min.js', array('jquery'), '5', true );
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/js/scripts.js', array(), '5', true );
	if(is_home()) wp_enqueue_script( 'infinite-scroll', get_template_directory_uri() . '/js/jquery.infinitescroll.min.js', array(), '20130115', true );



	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		if ( function_exists('KTT_get_comments_system') ) {
			if (KTT_get_comments_system() == 'wordpress') wp_enqueue_script( 'comment-reply' );
		} else {
			wp_enqueue_script( 'comment-reply' );
		}

	}


}
add_action( 'wp_enqueue_scripts', 'KTT_theme_scripts' );

add_theme_support("aesop-component-styles", array("parallax", "image", "quote", "gallery", "content", "video", "audio", "collection", "chapter", "document", "character", "map", "timeline" ) );
