<?php 

add_action( 'add_meta_boxes', 'ac_work_builder_add' );

function ac_work_builder_add() {
  add_meta_box( 'ac_work_builder', 'Work Details', 'ac_work_builder', 'work', 'normal', 'core' );
}

function ac_work_builder( $post ) {
  $values = get_post_custom( $post->ID );
  // $press_album = isset( $values['press_album'] ) ? esc_attr( $values['press_album'][0] ) : '';

  wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
?>

<div id="composer_box">
  <!-- press_source -->
  <div class="composer_block">
    <label for="press_source">Source</label><br />
    <input type="text" name="press_source" id="press_source" value="" />
    <small>Nate Chinen, The New York Times (Fall Pop Music Preview)</small>
  </div>
</div><!-- #press_builder_box -->

<?php }


add_action( 'save_post', 'ac_work_builder_save' );

function ac_work_builder_save( $post_id ) {
  // Bail if we're doing an auto save
  if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
  
  // if our nonce isn't there, or we can't verify it, bail
  if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
  
  // now we can actually save the data
  $allowed = array( 
    'a' => array( // on allow a tags
      'href' => array() // and those anchords can only have href attribute
    )
  );

  if( isset( $_POST['press_album'] ) )
    update_post_meta( $post_id, 'press_album', wp_kses( $_POST['press_album'], $allowed ) );

}

add_action('init', 'register_work');
function register_work() {
  register_post_type('work', array(
    'label'              => 'Work',
    'labels'             => array(
      'name'               => _x('Work', 'post type general name'),
      'singular_name'      => _x('Work', 'post type singular name'),
      'add_new'            => _x('Add New', 'ac_work'),
      'add_new_item'       => __('Add New Work'),
      'edit_item'          => __('Edit Work'),
      'new_item'           => __('New Work'),
      'view_item'          => __('View Work'),
      'search_items'       => __('Search Work'),
      'not_found'          => __('No work found'),
      'not_found_in_trash' => __('No work found in Trash'),
      'parent_item_colon'  => ''
    ),
    'public'             => true,
    'has_archive'        => true,
    'publicly_queryable' => true,
    'publicly_queryable' => true,
    'album_ui'            => true,
    'menu_position'      => 20,
    'query_var'          => true,
    'rewrite'            => true,
    'capability_type'    => 'page',
    'supports'           => array('title','editor','thumbnail','excerpt','custom-fields'),
    'taxonomies'         => array(),
    'slug'               => 'work',
    'hierarchical'       => false,
    'menu_icon'          => 'dashicons-exerpt-view',
  ));
}