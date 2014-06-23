<?php
/**
 * Search results template
 *
 * @package %Theme_Name%
 * @author %Author%
 */

get_header(); ?>

<div id="content">

  <h1 class="post-title"><?php printf( __( 'Search results for "%s"', '%Text_Domain%' ), get_search_query() ); ?></h1>

  <?php if ( have_posts() ) : ?>

    <?php get_search_form(); ?>

    <?php while ( have_posts() ) : the_post(); ?>

      <?php get_template_part( 'content', 'index' ); ?>

    <?php endwhile; ?>

    <?php echo themename_post_nav_links(); ?>

  <?php else : ?>

    <p><?php printf( __( 'Our apologies but there\'s nothing that matches your search for "%s"', '%Text_Domain%' ), get_search_query() ); ?></p>
    <?php get_search_form(); ?>

  <?php endif; ?>

</div><!-- #content -->

<?php get_footer(); ?>