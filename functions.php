<?php
/**
 * Theme functions.
 *
 * @package %Theme_Name%
 * @author %Author%
 */

require_once dirname( __FILE__ ) . '/includes/admin.php';
require_once dirname( __FILE__ ) . '/includes/utility.php';

/** Enable additional theme features */
add_post_type_support( 'page', 'excerpt' );
add_theme_support( 'post-thumbnails' );

/**
 * Custom "Read More" links
 *
 * @global $post
 * @param str $more won't be used
 * @return str
 *
 * @uses esc_attr()
 * @uses get_permalink()
 * @uses get_the_title()
 */
function themename_excerpt_more( $more ) {
	global $post;
	return sprintf( '<a href="%s" title="%s" class="read-more">%s</a>',
		get_permalink( $post->ID ),
		esc_attr( sprintf( __( 'Continue reading "%s"', '%Text_Domain%' ), get_the_title( $post->ID ) ) ),
		__( 'Continue reading&hellip;', '%Text_Domain%' )
	);
}
add_filter( 'excerpt_more', 'themename_excerpt_more' );

/**
 * Register dynamic sidebars
 *
 * @uses register_sidebar()
 */
function themename_register_dynamic_sidebars() {
	$sidebars = array(
		array(
			'id' => 'primary-sidebar',
			'name' => __( 'Primary sidebar', '%Text_Domain%' ),
		)
	);

	foreach ( $sidebars as $sidebar ) {
		register_sidebar( $sidebar );
	}
}
//add_action( 'widgets_init', 'themename_register_dynamic_sidebars' );

/**
 * Register the site favicon, if it exists
 *
 * @uses get_template_directory_uri()
 */
function themename_register_favicon() {
	printf( '<link href="%s/favicon.ico" rel="shortcut icon" />' . PHP_EOL, get_template_directory_uri() );
}
//add_action( 'wp_head', 'themename_register_favicon' );

/**
 * Register site navigation menus
 *
 * @uses register_nav_menus()
 */
function themename_register_nav_menus() {
	register_nav_menus(
		array(
			'primary-nav' => __( 'Primary Navigation', '%Text_Domain%' )
		)
	);
}
add_action( 'init', 'themename_register_nav_menus' );

/**
 * Register and enqueue theme styles and scripts
 *
 * @return void
 *
 * @uses get_stylesheet_directory_uri()
 * @uses wp_enqueue_script()
 * @uses wp_enqueue_style()
 * @uses wp_register_script()
 * @uses wp_register_style()
 */
function themename_register_styles_scripts() {
	/** Stylesheets */
	wp_register_style( 'styles', get_stylesheet_directory_uri() . '/assets/css/styles.css', null, null, 'all' );

	/** Scripts */
	wp_register_script( 'scripts', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array( 'jquery' ), null, true );
	wp_register_script( 'modernizr', get_stylesheet_directory_uri() . '/js/modernizr.min.js', null, null, false );

	if ( ! is_admin() && ! is_login_page() ) {
		wp_enqueue_style( 'styles' );

		//wp_enqueue_script( 'modernizr' );
		wp_enqueue_script( 'scripts' );
	}

	// Editor stylesheets
	add_editor_style( 'assets/css/editor.css' );
}
add_action( 'init', 'themename_register_styles_scripts' );


/**
 * Generates and outputs the theme's #site-logo
 * The front page will be a <h1> tag while interior pages will be links to the homepage
 *
 * @return void
 *
 * @uses get_bloginfo()
 * @uses is_front_page()
 * @uses site_url()
 */
function themename_site_logo() {
	if ( is_front_page() ) {
		$logo = sprintf( '<h1 id="site-logo">%s</h1>', get_bloginfo( 'name' ) );
	} else{
		$logo = sprintf( '<a href="%s" id="site-logo">%s</a>', site_url( '/' ), get_bloginfo( 'name' ) );
	}
	print $logo;
}

/**
 * Create a nicely formatted <title> element for the page
 * Based on twentytwelve_wp_title()
 *
 * @global $page
 * @global $paged
 * @param str $title The default title text
 * @param str $sep Optional separator
 * @return str
 *
 * @uses get_bloginfo()
 * @uses is_feed()
 * @uses is_front_page()
 * @uses is_home()
 */
function themename_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( ! is_feed() ) {
		$title .= get_bloginfo( 'name' );

		// Add the site description on blog/front page
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title = sprintf( '%s %s %s', $title, $sep, $site_description );
		}

		if ( $paged >= 2 || $page >= 2 ) {
			$title = sprintf( '%s %s %s', $title, $sep, sprintf( __( 'Page %s', '%Text_Domain%' ), max( $paged, $page ) ) );
		}
	}
	return $title;
}
add_filter( 'wp_title', 'themename_wp_title', 10, 2 );
