<?php
/**
 * Customizations to the WordPress administration area
 *
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
 * @link http://wiki.moxiecode.com/index.php/TinyMCE:Control_reference
 */
function themename_change_mce_buttons( $init ) {
  $block_formats = array(
    'Paragraph=p',
    'Address=address',
    'Pre=pre',
    'Heading 2=h2',
    'Heading 3=h3',
    'Heading 4=h4',
    'Heading 5=h5',
    'Heading 6=h6'
  );
  $init['block_formats'] = implode( ';', $block_formats );
  $init['theme_advanced_disable'] = 'forecolor';

  return $init;
}
add_filter( 'tiny_mce_before_init', 'themename_change_mce_buttons' );