<?php 

add_action( 'add_meta_boxes', 'ac_album_builder_add' );

function ac_album_builder_add() {
  add_meta_box( 'ac_album_builder', 'Album Details', 'ac_album_builder', 'album', 'normal', 'core' );
}
// Albums
// - Album Name
// - Album Cover Image
// - Album Summary
// - Album Long Description
// - Liner Notes (Who plays what on the album)
// - Release Date
// - Record Label
// - iTunes URL
// - Album Buy URL
// - Album Price

function ac_album_builder( $post ) {
  $values = get_post_custom( $post->ID );
  
  $album_cost = isset( $values['album_cost'] ) ? esc_attr( $values['album_cost'][0] ) : '';
  
  $album_release_date = isset( $values['album_release_date'] ) ? esc_attr( $values['album_release_date'][0] ) : '';

  wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
?>

<div id="composer_box">
  
  <!-- album_date -->
  <p class="composer_block">
    <label for="album_release_date"><span class="dashicons dashicons-calendar-alt"></span> Album Release Date</label><br />
    <input type="text" name="album_release_date" id="album_release_date" value="<?php echo $album_release_date; ?>" />
  </p>

  <!-- album_ticket_url -->
  <p class="composer_block">
    <label for="album_cost">Cost</label><br />
    <input type="text" name="album_cost" id="album_cost" value="<?php echo $album_cost; ?>" />
  </p>

</div><!-- #album_builder_box -->
<?php }


add_action( 'save_post', 'ac_album_builder_save' );

function ac_album_builder_save( $post_id ) {
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

  if( isset( $_POST['album_cost'] ) )
    update_post_meta( $post_id, 'album_cost', wp_kses( $_POST['album_cost'], $allowed ) );

  if( isset( $_POST['album_release_date'] ) )
    update_post_meta( $post_id, 'album_release_date', wp_kses( $_POST['album_release_date'], $allowed ) );
}




add_action('init', 'register_albums');
function register_albums() {
  register_post_type('album', array(
    'label'              => 'Albums',
    'labels'             => array(
      'name'               => _x('Albums', 'post type general name'),
      'singular_name'      => _x('Album', 'post type singular name'),
      'add_new'            => _x('Add New', 'ac_album'),
      'add_new_item'       => __('Add New Album'),
      'edit_item'          => __('Edit Album'),
      'new_item'           => __('New Album'),
      'view_item'          => __('View Album'),
      'search_items'       => __('Search Album'),
      'not_found'          => __('No albums found'),
      'not_found_in_trash' => __('No albums found in Trash'),
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
    'capability_type'    => 'post',
    'supports'           => array('title','editor','thumbnail','excerpt','custom-fields'),
    'taxonomies'         => array(),
    'slug'               => 'album',
    'hierarchical'       => false,
    'menu_icon'          => 'dashicons-album',
  ));

}

