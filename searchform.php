<?php
/**
 * Search form.
 *
 * @package %Theme_Name%
 * @author %Author%
 */

// Since we can have multiple search forms per page we should generate a unique element ID
$search_input_id = sprintf( 'search-input-%s', uniqid() );

?>

<form method="get" action="<?php echo home_url( '/' ); ?>" class="search" role="search">
  <label for="<?php echo $search_input_id; ?>" class="screen-reader-text"><?php _e( 'Search for:', '%Text_Domain%' ); ?></label>
  <input type="text" name="s" id="<?php echo $search_input_id; ?>" value="<?php the_search_query(); ?>" />
  <button type="submit" value="<?php echo esc_attr( __( 'Search', '%Text_Domain%' ) ); ?>"><?php _e( 'Search', '%Text_Domain%' ); ?></button>
</form><!-- form.search -->
