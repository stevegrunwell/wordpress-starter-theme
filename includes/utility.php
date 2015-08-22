<?php
/**
 * Functions meant to extend core WordPress functionality
 *
 * @package %Theme_Name%
 * @author %Author%
 */

if ( ! function_exists( 'is_login_page' ) ) {
	/**
	 * Check to see if the current page is the login/register page.
	 *
	 * Use this in conjunction with is_admin() to separate the front-end from the back-end of your
	 * WordPress site/theme.
	 *
	 * @return bool True if the current page is a login page, false otherwise.
	 */
	function is_login_page() {
		return in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) );
	}
}
