<?php
/**
 * Customizations to the WordPress administration area
 * @package %Theme_Name%
 * @author %Author%
 */

/**
 * Hide admin menus we don't need
 *
 * @global $menu
 * @return void
 */
function themename_remove_admin_menus() {
  global $menu;
  $restricted = array( __( 'Posts' ), __( 'Comments' ) );
  end( $menu );
  while ( prev( $menu ) ) {
    $value = explode( ' ', $menu[ key( $menu ) ][0] );
    if ( in_array( $value['0'] != null ? $value[0] : '', $restricted ) ) {
      unset( $menu[ key( $menu ) ] );
    }
  }
  return;
}
//add_action( 'admin_menu', 'themename_remove_admin_menus' );

/**
 * Customize the TinyMCE WYSIWYG editor
 *
 * @param array $init Default settings to be overridden
 * @return array The modified $init
 *
 * @link http://wpengineer.com/1963/customize-wordpress-wysiwyg-editor/
 */
function themename_change_mce_buttons( $init ) {
  // @see http://wiki.moxiecode.com/index.php/TinyMCE:Control_reference
  $init['theme_advanced_blockformats'] = 'p,h2,h3,h4,h5,h6,pre'; // no more h1
  $init['theme_advanced_disable'] = 'forecolor';
  return $init;
}
add_filter( 'tiny_mce_before_init', 'themename_change_mce_buttons' );