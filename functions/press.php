<?php 

add_action( 'add_meta_boxes', 'ac_press_builder_add' );

function ac_press_builder_add() {
  add_meta_box( 'ac_press_builder', 'Press Details', 'ac_press_builder', 'press', 'normal', 'core' );
}

// Blurb


function ac_press_builder( $post ) {
  $values = get_post_custom( $post->ID );
  $press_work = isset( $values['press_work'] ) ? esc_attr( $values['press_work'][0] ) : '';
  $press_blurb = isset( $values['press_blurb'] ) ? esc_attr( $values['press_blurb'][0] ) : '';
  $press_source = isset( $values['press_source'] ) ? esc_attr( $values['press_source'][0] ) : '';
  $press_source_url = isset( $values['press_source_url'] ) ? esc_attr( $values['press_source_url'][0] ) : '';

  wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );

  $args = array (
    'posts_per_page' => -1,
    'post_type'     => array('work'),
    'post_status'   => 'publish, draft'
  );
  $query = new WP_Query( $args );
  $works = $query->get_posts();
?>


<div id="composer_box">
  <!-- press_work -->
  <div class="composer_block">
    <label for="press_work">Project / Work</label><br />
    <select name="press_work" id="press_work" class="">
      <?php 
        // Blank option
        echo '<option'. selected( $press_work, '' ) . ' value=""></option>';
        foreach ($works as $work) {
          // print_r($album);
          $work_name = $work->post_title;
          $work_ID = $work->ID;
          
          // Passes the category ID as the value so it can be used elsewhere
          echo '<option'. selected( $press_work, $work_ID ) . ' value="' . $work_ID . '">' . $work_name . '</option>';
        }
      ?>
    </select>
  </div>

  <!-- press_blurb -->
  <div class="composer_block">
    <label for="press_blurb">Blurb</label><br />
    <textarea type="text" name="press_blurb" id="press_blurb"><?php echo $press_blurb ?></textarea>
  </div>

  <!-- press_source -->
  <div class="composer_block">
    <label for="press_source">Source</label><br />
    <input type="text" name="press_source" id="press_source" value="<?php echo $press_source; ?>" />
    <small>Nate Chinen, The New York Times (Fall Pop Music Preview)</small>
  </div>

  <!-- press_source_url -->
  <div class="composer_block">
    <label for="press_source_url">Source URL</label><br />
    <input type="text" name="press_source_url" id="press_source_url" value="<?php echo $press_source_url; ?>" />
    <small>http://nytimes.com/article-url</small>
  </div>

</div><!-- #press_builder_box -->
<?php }


add_action( 'save_post', 'ac_press_builder_save' );

function ac_press_builder_save( $post_id ) {
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

  if( isset( $_POST['press_work'] ) )
    update_post_meta( $post_id, 'press_work', wp_kses( $_POST['press_work'], $allowed ) );

  if( isset( $_POST['press_blurb'] ) )
    update_post_meta( $post_id, 'press_blurb', wp_kses( $_POST['press_blurb'], $allowed ) );

  if( isset( $_POST['press_source'] ) )
    update_post_meta( $post_id, 'press_source', wp_kses( $_POST['press_source'], $allowed ) );

  if( isset( $_POST['press_source_url'] ) )
    update_post_meta( $post_id, 'press_source_url', wp_kses( $_POST['press_source_url'], $allowed ) );

}




add_action('init', 'register_press');
function register_press() {
  register_post_type('press', array(
    'label'              => 'Press',
    'labels'             => array(
      'name'               => _x('Press', 'post type general name'),
      'singular_name'      => _x('Press Clip', 'post type singular name'),
      'add_new'            => _x('Add New', 'ac_press'),
      'add_new_item'       => __('Add New Press Clip'),
      'edit_item'          => __('Edit Press Clip'),
      'new_item'           => __('New Press Clip'),
      'view_item'          => __('View Press Clip'),
      'search_items'       => __('Search Press Clips'),
      'not_found'          => __('No press clips found'),
      'not_found_in_trash' => __('No press clips found in Trash'),
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
    'supports'           => array('thumbnail'),
    'taxonomies'         => array(),
    'slug'               => 'press',
    'hierarchical'       => false,
    'menu_icon'          => 'dashicons-id',
  ));

}


function ST4_columns_head($defaults) {
  $defaults['press_blurb']  = 'Blurb';
  $defaults['press_source']  = 'Source';
  $defaults['press_work']  = 'Album';
  // print_r($defaults);

  /* ADD ANOTHER COLUMN (OPTIONAL) */
  // $defaults['second_column'] = 'Second Column';

  /* REMOVE DEFAULT CATEGORY COLUMN (OPTIONAL) */
  unset($defaults['title']);
  unset($defaults['date']);

  /* TO GET DEFAULTS COLUMN NAMES: */
  // print_r($defaults);

  return $defaults;
}
 
// GENERAL PURPOSE
function ST4_columns_content($column_name, $post_ID) {
  if ($column_name == 'press_blurb') {
    echo wpautop(get_post_meta( get_the_ID(), 'press_blurb', true ));
  }
  if ($column_name == 'press_source') {
    echo get_post_meta( get_the_ID(), 'press_source', true );
  }
  if ($column_name == 'press_work') {
    $album_id = get_post_meta( get_the_ID(), 'press_work', true );
    $album = get_post( $album_id ); 
    echo $album_name = $album->post_title;
  }
}
add_filter('manage_press_posts_columns', 'ST4_columns_head', 10);
add_action('manage_press_posts_custom_column', 'ST4_columns_content', 10, 2);
