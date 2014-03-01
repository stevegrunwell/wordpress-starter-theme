<?php
/**
 * Functionality related to Advanced Custom Fields
 *
 * @package %Theme_Name%
 * @author %Author%
 */

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