<?php
/**
 * Customizations to the WordPress administration area.
 *
 * @package %Theme_Name%
 * @author %Author%
 */

/**
 * Add the style select menu to the TinyMCE editor.
 *
 * @param array $buttons Buttons for this row of the TinyMCE toolbar.
 * @return array The filtered $buttons array.
 */
function themename_add_style_select_to_tinymce( $buttons ) {
	array_unshift( $buttons, 'styleselect' );

	return $buttons;
}
add_filter( 'mce_buttons_2', 'themename_add_style_select_to_tinymce' );

/**
 * Customize the TinyMCE WYSIWYG editor settings.
 *
 * @param array $init Default settings to be overridden.
 * @return array The modified $init array.
 *
 * @link http://codex.wordpress.org/TinyMCE_Custom_Styles
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
		'Heading 6=h6',
	);
	$init['block_formats'] = implode( ';', $block_formats );

	$style_formats = array(
		array(
			'title'    => __( 'Blockquote citation', '%Text_Domain%' ),
			'selector' => 'blockquote p',
			'classes'  => 'cite',
			'wrapper'  => false,
		),
	);
	$init['style_formats'] = wp_json_encode( $style_formats );

	return $init;
}
add_filter( 'tiny_mce_before_init', 'themename_change_mce_buttons' );

/**
 * Remove the "Text Color" TinyMCE button.
 *
 * @param array $buttons Buttons for this row of the TinyMCE toolbar.
 * @return array The filtered $buttons array.
 */
function themename_remove_forecolor_button( $buttons ) {
	if ( $key = array_search( 'forecolor', $buttons ) ) {
		unset( $buttons[ $key ] );
	}
	return $buttons;
}
add_filter( 'mce_buttons_2', 'themename_remove_forecolor_button' );
