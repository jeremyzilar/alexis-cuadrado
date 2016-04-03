<?php 

add_action( 'add_meta_boxes', 'ac_project_builder_add' );

function ac_project_builder_add() {
  add_meta_box( 'ac_project_builder', 'Project Details', 'ac_project_builder', 'work', 'normal', 'core' );
}

function ac_project_builder( $posta ) {
  $values = get_post_custom( $post->ID );

  $album_label = isset( $values['album_label'] ) ? esc_attr( $values['album_label'][0] ) : '';
  $album_cost = isset( $values['album_cost'] ) ? esc_attr( $values['album_cost'][0] ) : '';
  $album_buy_url = isset( $values['album_buy_url'] ) ? esc_attr( $values['album_buy_url'][0] ) : '';
  
  $project_release_date = isset( $values['project_release_date'] ) ? esc_attr( $values['project_release_date'][0] ) : '';
  $project_notes = isset( $values['project_notes'] ) ? esc_attr( $values['project_notes'][0] ) : '';
  $primary_color = isset( $values['primary_color'] ) ? esc_attr( $values['primary_color'][0] ) : '';
  $project_colors = isset( $values['project_colors'] ) ? esc_attr( $values['project_colors'][0] ) : '';
  wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );

  // get the featured thumb
  $thumb = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
?>

<div id="composer_box">
  
  <div class="composer_block">
    
    <!-- project_release_date -->
    <div class="group">
      <label for="project_release_date"><span class="dashicons dashicons-calendar-alt"></span>Release Date</label><br />
      <input type="text" name="project_release_date" id="project_release_date" value="<?php echo $project_release_date; ?>" />
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
    <!-- album_cost -->
    <div class="group">
      <label for="album_cost">Album Cost</label><br />
      <input type="text" name="album_cost" id="album_cost" value="<?php echo $album_cost; ?>" />      
    </div>
    <!-- album_ticket_url -->
    <div class="group">
      <label for="album_buy_url">Purchase URL</label><br />
      <input type="text" name="album_buy_url" id="album_buy_url" value="<?php echo $album_buy_url; ?>" />
    </div>
  </div>

  <!-- project_notes -->
  <div class="composer_block">
    <label for="project_notes">Project Notes</label><br />
    <textarea type="text" name="project_notes" id="project_notes"><?php echo $project_notes ?></textarea>
    <small>Who played on the album/project</small>
  </div>

  <!-- color_palette -->
  <div class="composer_block">
    <label for="project_colors">Project Colors</label><br />
    <a class="get_colors" href="#">Get Colors</a>
    <input type="text" name="primary_color" id="primary_color" value="<?php echo $primary_color; ?>" />
    <input type="hidden" name="project_colors" id="project_colors" value="<?php echo $project_colors; ?>" />
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


add_action( 'save_post', 'ac_project_builder_save' );

function ac_project_builder_save( $post_id ) {
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

  if( isset( $_POST['album_label'] ) )
    update_post_meta( $post_id, 'album_label', wp_kses( $_POST['album_label'], $allowed ) );

  if( isset( $_POST['album_buy_url'] ) )
    update_post_meta( $post_id, 'album_buy_url', wp_kses( $_POST['album_buy_url'], $allowed ) );

  if( isset( $_POST['project_release_date'] ) )
    update_post_meta( $post_id, 'project_release_date', wp_kses( $_POST['project_release_date'], $allowed ) );
  
  if( isset( $_POST['project_notes'] ) )
    update_post_meta( $post_id, 'project_notes', wp_kses( $_POST['project_notes'], $allowed ) );

  if( isset( $_POST['primary_color'] ) )
    update_post_meta( $post_id, 'primary_color', wp_kses( $_POST['primary_color'], $allowed ) );

  if( isset( $_POST['project_colors'] ) )
    update_post_meta( $post_id, 'project_colors', wp_kses( $_POST['project_colors'], $allowed ) );
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