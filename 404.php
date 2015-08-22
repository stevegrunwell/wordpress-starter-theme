<?php
/**
 * 404 Page Not Found.
 *
 * @package %Theme_Name%
 * @author %Author%
 */

get_header(); ?>

<div id="content">

	<h1 class="post-title"><?php _e( 'Page Not Found', '%Text_Domain%' ) ?></h1>
	<p><?php _e( 'We apologize but the page you\'re looking for could not be found.', '%Text_Domain%' ); ?></p>
	<?php get_search_form(); ?>

</div><!-- #content -->

<?php get_footer();
