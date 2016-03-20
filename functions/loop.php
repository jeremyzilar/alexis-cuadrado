<?php

function stream_loop(){
	if ( is_user_logged_in()) {
		global $wp_query;
		$args = array_merge( $wp_query->query, array( 'post_status' => array('publish', 'draft') ) );
		query_posts( $args );
	}

	if (have_posts()) {
		while (have_posts()) {
			the_post(); ?>
      <?php
        // Date Bar
        $the_date = the_date('', '', '', FALSE);
        if (!empty($the_date)) {
          echo '<div class="date-bar">' . $the_date . '</div>';
        }

        // Cards
				$card_type = get_post_meta( get_the_ID(), 'card_type', true );
				if (!empty($card_type)) {
					get_template_part('cards/'. $card_type);
				} else {
					get_template_part('cards/refer');
				}

			?>
		<?php
		}
	}
}

function loop(){
	if (have_posts()) {
		while (have_posts()) {
			the_post();
      $post_type = get_post_type( $post );
      if ($post_type == 'album') {
        get_template_part('content', $post_type );
      } else {
        get_template_part('content', '' );
      }
      
		}
	}
}


function collection_loop(){
  if (have_posts()) {
    while (have_posts()) {
      the_post(); ?>
      <?php

        function collection_card($i){
          $args = array (
            'p' => $i,
            'post_type' => array('bookmark','post')
          );
          $query = new WP_Query( $args );

          if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
              $query->the_post();

              get_template_part('content', 'collection-card' );
            }
          }
        }

        $collection_index = get_post_meta( get_the_ID(), 'collection_index', true );
        $collection_index = explode(',',$collection_index);
        foreach ($collection_index as $item) {
          collection_card($item);
        }
        // get_template_part('content', 'collection' );

      ?>
    <?php
    }
  }
}



function collection_feed_loop($num){
	$collection_data = array();
 
  $args = array(
    'post_type'      => 'collection',
    'posts_per_page' => $num
  );
  $query = new WP_Query( $args );
  if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
  	$collection_index = explode(',',get_post_meta( get_the_ID(), 'collection_index', true ));
  	$collection = get_post();

  	$items = array();
  	foreach ($collection_index as $id) {
  		$item = get_post( $id );
  		array_push($items, $item);
  	}
  	$collection->items = $items;

  	array_push($collection_data, $collection);

  endwhile;
  wp_reset_postdata();
  endif;

  return $collection_data;
}