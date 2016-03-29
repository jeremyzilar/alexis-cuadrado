<?php get_header(); ?>

  <?php include(INC . 'album_list.php'); ?> 
  
  <?php include(INC . 'stream-nav.php'); ?> 

  <?php stream_loop(); ?>
  
<?php get_footer(); ?>