<?php
/**
 * Default template
 * @package %Theme_Name%
 * @author %Author%
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

  <?php get_template_part( 'content', 'index' ); ?>

<?php endwhile; ?>

<?php echo themename_post_nav_links(); ?>

<?php get_sidebar( 'index' ); ?>

<?php get_footer(); ?>