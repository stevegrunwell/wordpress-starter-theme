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
 * Custom "Read More" links.
 *
 * @global $post
 *
 * @param string $more Won't be used.
 * @return string A "continue reading" link to the post.
 */
function themename_excerpt_more( $more ) {
	global $post;

	return sprintf(
		'<a href="%s" title="%s" class="read-more">%s</a>',
		esc_url( get_permalink( $post->ID ) ),
		esc_attr( sprintf( __( 'Continue reading "%s"', '%Text_Domain%' ), get_the_title( $post->ID ) ) ),
		esc_html__( 'Continue reading&hellip;', '%Text_Domain%' )
	);
}
add_filter( 'excerpt_more', 'themename_excerpt_more' );

/**
 * Register dynamic sidebars.
 */
function themename_register_dynamic_sidebars() {
	$sidebars = array(
		array(
			'id'   => 'primary-sidebar',
			'name' => __( 'Primary sidebar', '%Text_Domain%' ),
		),
	);

	foreach ( $sidebars as $sidebar ) {
		register_sidebar( $sidebar );
	}
}
add_action( 'widgets_init', 'themename_register_dynamic_sidebars' );

/**
 * Register site navigation menus
 *
 * @uses register_nav_menus()
 */
function themename_register_nav_menus() {
	register_nav_menus(
		array(
			'primary-nav' => __( 'Primary Navigation', '%Text_Domain%' ),
		),
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

	// Editor stylesheets.
	add_editor_style( 'assets/css/editor.css' );
}
add_action( 'init', 'themename_register_styles_scripts' );


/**
 * Generates and outputs the theme's #site-logo.
 *
 * The front page will be a <h1> tag while interior pages will be links to the homepage.
 */
function themename_site_logo() {
	if ( is_front_page() ) {
		printf( '<h1 id="site-logo">%s</h1>', esc_html( get_bloginfo( 'name' ) ) );

	} else {
		printf(
			'<a href="%s" id="site-logo">%s</a>',
			esc_attr( site_url( '/' ) ),
			esc_html( get_bloginfo( 'name' ) )
		);
	}
}
