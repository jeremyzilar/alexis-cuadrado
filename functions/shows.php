<?php 

add_action( 'add_meta_boxes', 'ac_show_builder_add' );

function ac_show_builder_add() {
  add_meta_box( 'ac_show_builder', 'Show Details', 'ac_show_builder', 'show', 'normal', 'core' );
}

function ac_show_builder( $post ) {
  $values = get_post_custom( $post->ID );
  $show_venue = isset( $values['show_venue'] ) ? esc_attr( $values['show_venue'][0] ) : '';
  $show_venue_address = isset( $values['show_venue_address'] ) ? esc_attr( $values['show_venue_address'][0] ) : '';
  $show_venue_url = isset( $values['show_venue_url'] ) ? esc_attr( $values['show_venue_url'][0] ) : '';
  $show_cost = isset( $values['show_cost'] ) ? esc_attr( $values['show_cost'][0] ) : '';
  $show_ticket_url = isset( $values['show_ticket_url'] ) ? esc_attr( $values['show_ticket_url'][0] ) : '';
  $show_date = isset( $values['show_date'] ) ? esc_attr( $values['show_date'][0] ) : '';
  $show_time = isset( $values['show_time'] ) ? esc_attr( $values['show_time'][0] ) : '';
  $show_related_id = isset( $values['show_related_id'] ) ? esc_attr( $values['show_related_id'][0] ) : '';
  $show_related_url = isset( $values['show_related_url'] ) ? esc_attr( $values['show_related_url'][0] ) : '';
  wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
?>

<?php 

  function ac_categories(){
    global $post;
    $ac_categories = get_the_category( $post->ID );
    return $ac_categories;
  }

  add_action( 'admin_head', 'get_show_excerpt' );
  function get_show_excerpt() {
    global $post;
    return $post->post_excerpt;
  }

?>



<div id="composer_box">
  
  <!-- show_date -->
  <p class="composer_block">
    <label for="show_date">Show Date</label><br />
    <input type="text" name="show_date" id="show_date" value="<?php echo $show_date; ?>" />
  </p>

  <!-- show_time -->
  <p class="composer_block">
    <label for="show_time">Time</label><br />
    <input type="text" name="show_time" id="show_time" value="<?php echo $show_time; ?>" />
  </p>

  <!-- show_venue -->
  <p class="composer_block">
    <label for="show_venue">Venue</label><br />
    <input type="text" name="show_venue" id="show_venue" value="<?php echo $show_venue; ?>" />
  </p>

  <!-- show_venue_address -->
  <p class="composer_block">
    <label for="show_venue_address">Venue Address</label><br />
    <textarea type="text" name="show_venue_address" id="show_venue_address"><?php echo $show_venue_address ?></textarea>
  </p>

  <!-- show_venue_url -->
  <p class="composer_block">
    <label for="show_venue_url">Venue URL</label><br />
    <input type="text" name="show_venue_url" id="show_venue_url" value="<?php echo $show_venue_url; ?>" />
  </p>

  <!-- show_cost -->
  <p class="composer_block">
    <label for="show_cost">Cost</label><br />
    <input type="text" name="show_cost" id="show_cost" value="<?php echo $show_cost; ?>" />
  </p>

  <!-- show_ticket_url -->
  <p class="composer_block">
    <label for="show_ticket_url">Cost</label><br />
    <input type="text" name="show_ticket_url" id="show_ticket_url" value="<?php echo $show_ticket_url; ?>" />
  </p>

</div><!-- #show_builder_box -->
<?php }


add_action( 'save_post', 'ac_show_builder_save' );

function ac_show_builder_save( $post_id ) {
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
  
  if( isset( $_POST['show_venue'] ) )
    update_post_meta( $post_id, 'show_venue', wp_kses( $_POST['show_venue'], $allowed ) );

  if( isset( $_POST['show_venue_address'] ) )
    update_post_meta( $post_id, 'show_venue_address', wp_kses( $_POST['show_venue_address'], $allowed ) );

  if( isset( $_POST['show_venue_url'] ) )
    update_post_meta( $post_id, 'show_venue_url', wp_kses( $_POST['show_venue_url'], $allowed ) );

  if( isset( $_POST['show_cost'] ) )
    update_post_meta( $post_id, 'show_cost', wp_kses( $_POST['show_cost'], $allowed ) );

  if( isset( $_POST['show_ticket_url'] ) )
    update_post_meta( $post_id, 'show_ticket_url', wp_kses( $_POST['show_ticket_url'], $allowed ) );

  if( isset( $_POST['show_date'] ) )
    update_post_meta( $post_id, 'show_date', wp_kses( $_POST['show_date'], $allowed ) );

  if( isset( $_POST['show_time'] ) )
    update_post_meta( $post_id, 'show_time', wp_kses( $_POST['show_time'], $allowed ) );

  if( isset( $_POST['show_related_id'] ) )
    update_post_meta( $post_id, 'show_related_id', wp_kses( $_POST['show_related_id'], $allowed ) );

  if( isset( $_POST['show_related_url'] ) )
    update_post_meta( $post_id, 'show_related_url', wp_kses( $_POST['show_related_url'], $allowed ) );
}




// Shows:
// - Show Name
// - Show desc
// - Show image
// - Venue
// - Venue Address
// - Venue URL
// - Map link
// - Date
// - Time
// - Cost
// - Ticket URL
// - Related Blog post

add_action('init', 'register_shows');
function register_shows() {
  register_post_type('show', array(
    'label'              => 'Shows',
    'labels'             => array(
      'name'               => _x('Shows', 'post type general name'),
      'singular_name'      => _x('Show', 'post type singular name'),
      'add_new'            => _x('Add New', 'ac_show'),
      'add_new_item'       => __('Add New Show'),
      'edit_item'          => __('Edit Show'),
      'new_item'           => __('New Show'),
      'view_item'          => __('View Show'),
      'search_items'       => __('Search Shows'),
      'not_found'          => __('No shows found'),
      'not_found_in_trash' => __('No shows found in Trash'),
      'parent_item_colon'  => ''
    ),
    'public'             => true,
    'has_archive'        => true,
    'publicly_queryable' => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'menu_position'      => 20,
    'query_var'          => true,
    'rewrite'            => true,
    'capability_type'    => 'post',
    'supports'           => array('title','editor','thumbnail','excerpt','custom-fields'),
    'taxonomies'         => array(),
    'slug'               => 'show',
    'hierarchical'       => false,
    'menu_icon'          => 'dashicons-tickets-alt',
  ));

}
