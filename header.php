<?php
/**
 * Theme header.
 *
 * @package %Theme_Name%
 * @author %Author%
 */

?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<header role="banner">
		<?php themename_site_logo(); ?>

		<nav id="primary-nav" role="navigation">
			<a href="#content" class="skip-link screen-reader-text"><?php esc_html_e( 'Skip to main content', '%Text_Domain%' ); ?></a>
			<?php
				$args = array(
					'container'      => false,
					'theme_location' => 'primary-nav',
				);
				wp_nav_menu( $args );
			?>
		</nav><!-- #primary-nav -->
	</header>
