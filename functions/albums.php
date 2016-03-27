<?php 

add_action( 'add_meta_boxes', 'ac_album_builder_add' );

function ac_album_builder_add() {
  add_meta_box( 'ac_album_builder', 'Album Details', 'ac_album_builder', 'album', 'normal', 'core' );
}

function ac_album_builder( $posta ) {
  $values = get_post_custom( $post->ID );
  $album_label = isset( $values['album_label'] ) ? esc_attr( $values['album_label'][0] ) : '';
  $album_cost = isset( $values['album_cost'] ) ? esc_attr( $values['album_cost'][0] ) : '';
  $album_buy_url = isset( $values['album_buy_url'] ) ? esc_attr( $values['album_buy_url'][0] ) : '';
  $album_release_date = isset( $values['album_release_date'] ) ? esc_attr( $values['album_release_date'][0] ) : '';
  $album_notes = isset( $values['album_notes'] ) ? esc_attr( $values['album_notes'][0] ) : '';
  $primary_color = isset( $values['primary_color'] ) ? esc_attr( $values['primary_color'][0] ) : '';
  $album_colors = isset( $values['album_colors'] ) ? esc_attr( $values['album_colors'][0] ) : '';

  wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );


  $thumb = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
?>

<div id="composer_box">
  
  <div class="composer_block">
    <!-- album_date -->
    <div class="group">
      <label for="album_release_date"><span class="dashicons dashicons-calendar-alt"></span>Release Date</label><br />
      <input type="text" name="album_release_date" id="album_release_date" value="<?php echo $album_release_date; ?>" />
      <small><?php echo date('Y\-m\-d'); ?></small>
    </div>
    
    <!-- album_label -->
    <div class="group">
      <label for="album_label">Label</label><br />
      <input type="text" name="album_label" id="album_label" value="<?php echo $album_label; ?>" />
      <small>http://bjurecords.com/</small>
    </div>
  </div>

  <div class="composer_block">
    <!-- album_date -->
    <div class="group">
      <label for="album_cost">Cost</label><br />
      <input type="text" name="album_cost" id="album_cost" value="<?php echo $album_cost; ?>" />      
    </div>
    <!-- album_ticket_url -->
    <div class="group">
      <label for="album_buy_url">Purchase URL</label><br />
      <input type="text" name="album_buy_url" id="album_buy_url" value="<?php echo $album_buy_url; ?>" />
    </div>
  </div>

  <!-- album_notes -->
  <div class="composer_block">
    <label for="album_notes">Album Notes</label><br />
    <textarea type="text" name="album_notes" id="album_notes"><?php echo $album_notes ?></textarea>
  </div>

  <!-- color_palette -->
  <div class="composer_block">
    <label for="album_colors">Album Colors</label><br />
    <a class="get_colors" href="#">Get Album Colors</a>
    <input type="text" name="primary_color" id="primary_color" value="<?php echo $primary_color; ?>" />
    <input type="hidden" name="album_colors" id="album_colors" value="<?php echo $album_colors; ?>" />
    <div class="color_palette"></div>
    <div class="color_preview">
      <?php 
        if ( function_exists('has_post_thumbnail') && has_post_thumbnail($post->ID) ) {
          $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'w300' );
          if (!$thumbnail[0]) {
            return false;
          } else {
            echo '<img src="'.$thumbnail[0].'">';
          }
        }
      ?>
      <div>
        <h3>Alexis Cuadrado</h3>
      </div>
    </div>
  </div>

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

  if( isset( $_POST['album_label'] ) )
    update_post_meta( $post_id, 'album_label', wp_kses( $_POST['album_label'], $allowed ) );

  if( isset( $_POST['album_buy_url'] ) )
    update_post_meta( $post_id, 'album_buy_url', wp_kses( $_POST['album_buy_url'], $allowed ) );

  if( isset( $_POST['album_notes'] ) )
    update_post_meta( $post_id, 'album_notes', wp_kses( $_POST['album_notes'], $allowed ) );

  if( isset( $_POST['primary_color'] ) )
    update_post_meta( $post_id, 'primary_color', wp_kses( $_POST['primary_color'], $allowed ) );

  if( isset( $_POST['album_colors'] ) )
    update_post_meta( $post_id, 'album_colors', wp_kses( $_POST['album_colors'], $allowed ) );

  
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
    'capability_type'    => 'page',
    'supports'           => array('title','editor','thumbnail','excerpt','custom-fields'),
    'taxonomies'         => array(),
    'slug'               => 'album',
    'hierarchical'       => false,
    'menu_icon'          => 'dashicons-album'
  ));

}

