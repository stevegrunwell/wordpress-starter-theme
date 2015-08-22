<?php
/**
 * Default implementation of the WordPress loop.
 *
 * @package %Theme_Name%
 * @author %Author%
 */

if ( is_singular() ) : ?>

  <article id="post-<?php the_ID(); ?>" <?php post_class( 'primary' ); ?> role="main">
    <h1 class="post-title"><?php the_title(); ?></h1>
    <?php the_content(); ?>
  </article><!-- #post-<?php the_ID(); ?> -->

<?php else : ?>

  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <h2 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
    <?php the_excerpt(); ?>
  </article><!-- #post-<?php the_ID(); ?> -->

<?php endif;
