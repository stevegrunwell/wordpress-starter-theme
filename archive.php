<?php
/**
 * Post archive template.
 *
 * @package %Theme_Name%
 * @author %Author%
 */

get_header(); ?>

<div id="content">

  <h1 class="post-title"><?php
    if ( is_day() ) {
      printf( __( 'Daily Archives: %s', '%Text_Domain%' ), get_the_date() );
    } elseif ( is_month() ) {
      printf( __( 'Monthly Archives: %s', '%Text_Domain%' ), get_the_date( 'F Y' ) );
    } elseif ( is_year() ) {
      printf( __( 'Yearly Archives: %s', '%Text_Domain%' ), get_the_date( 'Y' ) );
    } else {
      _e( 'Blog Archives', '%Text_Domain%' );
    }
  ?></h1>

  <?php while ( have_posts() ) : the_post(); ?>

    <?php get_template_part( 'content', 'archive' ); ?>

  <?php endwhile; ?>

  <?php echo themename_post_nav_links(); ?>

  <?php get_sidebar( 'archive' ); ?>

</div><!-- #content -->

<?php get_footer(); ?>