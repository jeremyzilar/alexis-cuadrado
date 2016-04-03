<?php
  $args = array (
    'post_type'     => array('work'),
    'posts_per_page' => 2
  );
  $query = new WP_Query( $args );
  if ( $query->have_posts() ) {
    while ( $query->have_posts() ) {
      $query->the_post();
      get_template_part('content', '' );
    }
  }
?>