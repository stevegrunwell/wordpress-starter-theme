<?php
/**
 * Theme functions
 * @package %Theme_Name%
 * @author %Author%
 */

require_once dirname( __FILE__ ) . '/functions/admin.php';
require_once dirname( __FILE__ ) . '/functions/utility.php';
if ( ! defined( 'USE_LOCAL_ACF_CONFIGURATION' ) || ! USE_LOCAL_ACF_CONFIGURATION ) {
  require_once dirname( __FILE__ ) . '/functions/advanced-custom-fields.php';
}

/**
 * Shortcut for `echo themename_get_custom_field( ... )`, accepts the same arguments
 * @param str $key The custom field key
 * @param int $id The post ID
 * @param mixed $default What to return if there's no custom field value
 * @return void
 * @uses themename_get_custom_field()
 */
function themename_custom_field( $key, $id=false, $default='' ) {
  echo themename_get_custom_field( $key, $id, $default );
}

/**
 * Custom "Read More" links
 * @global $post
 * @param str $more won't be used
 * @return str
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
 * Get a custom field stored in the Advanced Custom Fields plugin
 * By running it through this function, we ensure that we don't die if the plugin is uninstalled/disabled (and thus the
 * function is undefined)
 * @global $post
 * @param str $key The key to look for
 * @param int $id The post ID
 * @param mixed $default What to return if there's nothing
 * @return mixed (dependent upon $echo)
 * @uses get_field()
 */
function themename_get_custom_field( $key, $id=false, $default='' ) {
  global $post;
  $key = trim( filter_var( $key, FILTER_SANITIZE_STRING ) );
  $result = '';

  if ( function_exists( 'get_field' ) ) {
    $result = ( isset( $post->ID ) && ! $id ? get_field( $key ) : get_field( $key, $id ) );

    if ( $result == '' ) {
      $result = $default;
    }
  } else { // get_field() is undefined, most likely due to the plugin being inactive
    $result = $default;
  }
  return $result;
}

/**
 * Get specified $fields from the repeater with slug $key
 * @global $post
 * @param str $key The custom field slug of the repeater
 * @param int $id The post ID (will use global $post if not specified)
 * @param array $fields The sub-fields to retrieve
 * @return array
 * @uses themename_get_custom_field()
 * @uses has_sub_field()
 * @uses get_sub_field()
 */
function themename_get_repeater_content( $key, $id=null, $fields=array() ) {
  global $post;
  if ( ! $id ) $id = $post->ID;
  $values = array();

  if ( themename_get_custom_field( $key, $id, false ) && function_exists( 'has_sub_field' ) && function_exists( 'get_sub_field' ) ) {

    while ( has_sub_field( $key, $id ) ) {
      $value = array();
      foreach ( $fields as $field ){
        $value[$field] = get_sub_field( $field );
      }
      if( ! empty( $value ) ) {
        $values[] = $value;
      }
    }
  }
  return $values;
}

/**
 * Add Google Analytics tracking to the site
 * Depends on a 'google_analytics_id' field being created on a theme options page
 * @uses themename_get_custom_field()
 */
function themename_google_analytics() {
  if ( $id = themename_get_custom_field( 'google_analytics_id', 'options', false ) ) {
    printf( "\n<!-- Google Analytics -->\n"
    . "<script type=\"text/javascript\">\n"
    . "  var _gaq = _gaq || [];\n"
    . "  _gaq.push(['_setAccount', '%s']);\n"
    . "  _gaq.push(['_trackPageview']);\n"
    . "  (function() {\n"
    . "    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;\n"
    . "    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';\n"
    . "    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);\n"
    . "  })();\n"
    . "</script>\n", $id );
  }
}
//add_filter( 'wp_head', 'themename_google_analytics' );

/**
 * Create previous/next post links
 * @return str
 * @uses get_previous_posts_link()
 * @uses get_next_posts_link()
 */
function themename_post_nav_links() {
  $nav = '';
  if ( $next = get_next_posts_link( __( '&laquo; Older Posts', '%Text_Domain%' ) ) ) {
    $nav .= sprintf( '<li class="next">%s</li>', $next );
  }
  if ( $prev = get_previous_posts_link( __( 'Newer Posts &raquo;', '%Text_Domain%' ) ) ) {
    $nav .= sprintf( '<li class="prev">%s</li>', $prev );
  }
  return ( $nav ? sprintf( '<ul class="post-nav-links">%s</ul>', $nav ) : '' );
}

/**
 * Register site navigation menus
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
 * @global $wp_styles
 * @return void
 */
function themename_register_styles_scripts() {
  global $wp_styles;

  /** Stylesheets */
  wp_register_style( 'styles', get_stylesheet_directory_uri() . '/css/generated/styles.css', null, null, 'all' );
  wp_register_style( 'ie8', get_stylesheet_directory_uri() . '/css/generated/ie8.css', array( 'styles' ), null, 'all' );
  $wp_styles->add_data( 'ie8', 'conditional', 'lte IE 8' );

  /** Scripts */
  wp_register_script( 'scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array( 'jquery' ), null, true );
  wp_register_script( 'modernizr', get_stylesheet_directory_uri() . '/js/modernizr.min.js', null, null, false );

  if ( ! is_admin() && ! is_login_page() ) {
    wp_enqueue_style( 'styles' );

    //wp_enqueue_script( 'modernizr' );
    wp_enqueue_script( 'scripts' );
  }
}
add_action( 'init', 'themename_register_styles_scripts' );


/**
 * Generates and outputs the theme's #site-logo
 * The front page will be a <h1> tag while interior pages will be links to the homepage
 * @return void
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
 * @global $page
 * @global $paged
 * @param str $title The default title text
 * @param str $sep Optional separator
 * @return str
 * @uses get_bloginfo()
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