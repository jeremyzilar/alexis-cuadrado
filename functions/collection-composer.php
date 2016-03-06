<?php

add_action( 'add_meta_boxes', 'supchina_collection_composer_add' );

function supchina_collection_composer_add() {
  add_meta_box( 'supchina_collection_composer', 'collection Composer', 'supchina_collection_composer', 'collection', 'normal', 'high' );
}

function supchina_collection_composer( $post ) {
	$values = get_post_custom( $post->ID );
  
  $collection_index = isset( $values['collection_index'] ) ? esc_attr( $values['collection_index'][0] ) : '';

	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
?>


<div id="composer_box">

  <div id="content_blocks">
    <ul id="topic-list" class="connected_list">
    <?php
      $args = array (
        'posts_per_page' => 10,
        'post_type'     => array('bookmark','post'),
        'post_status'   => 'publish, draft',
        'post__not_in' => explode(',', $collection_index)
      );
      $query = new WP_Query( $args );
      if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
          $query->the_post();
          get_template_part('content', 'collection-item' );
        }
      }
    ?>
    </ul>
    

    <ul id="collection-list" class="connected_list">
    <?php
      $args = array (
        'post__in' => explode(',', $collection_index),
        'post_status'   => 'publish, draft',
        'orderby' => 'post__in',
        'post_type'     => array('bookmark','post'),
        'posts_per_page' => 5
      );
      $query = new WP_Query( $args );
      if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
          $query->the_post();
          get_template_part('content', 'collection-item' );
        }
      }
    ?>
    </ul>
    
    <div class="clear"></div>
    <input type="text" name="collection_index" id="collection_index" value="<?php echo $collection_index; ?>" />
  </div>


</div><!-- #collection_composer_box -->
<?php	}


add_action( 'save_post', 'supchina_collection_composer_save' );

function supchina_collection_composer_save( $post_id ) {
	// Bail if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	
	// if our nonce isn't there, or we can't verify it, bail
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
	
  if( isset( $_POST['collection_index'] ) )
    update_post_meta( $post_id, 'collection_index', wp_kses( $_POST['collection_index'], $allowed ) );

	update_post_meta( $post_id, 'my_meta_box_check', $chk );

}