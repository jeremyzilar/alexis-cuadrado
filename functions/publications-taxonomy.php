<?php
// Publication names are stored in a custom taxonomy 'publication'
register_taxonomy(
  'publication',
  'post',
  array(
    'labels'        => array(
        'name'          => 'Publications',
        'add_new_item'  => 'Add New Publication',
        'new_item_name' => "New Publication"
    ),
    'show_ui'       => true,
    'show_tagcloud' => false,
    'hierarchical'  => false
  )
);


// Add term page
function publisher_site_url() { ?>
  <div class="form-field">
    <label for="term_meta[custom_term_meta]"><?php _e( 'Site URL' ); ?></label>
    <input type="text" name="term_meta[custom_term_meta]" id="term_meta[custom_term_meta]" value="">
    <p class="description"><?php _e( 'Enter a value for this field','pippin' ); ?></p>
  </div>
<?php
}
add_action( 'publication_add_form_fields', 'publisher_site_url', 10, 2 );


// Edit term page
function publisher_edit_site_url($term) {
 
  // put the term ID into a variable
  $t_id = $term->term_id;
 
  // retrieve the existing value(s) for this meta field. This returns an array
  $term_meta = get_option( "taxonomy_$t_id" ); ?>
  <tr class="form-field">
  <th scope="row" valign="top"><label for="term_meta[custom_term_meta]"><?php _e( 'Site URL' ); ?></label></th>
    <td>
      <input type="text" name="term_meta[custom_term_meta]" id="term_meta[custom_term_meta]" value="<?php echo esc_attr( $term_meta['custom_term_meta'] ) ? esc_attr( $term_meta['custom_term_meta'] ) : ''; ?>">
      <p class="description"><?php _e( 'e.g. http://nytimes.com' ); ?></p>
    </td>
  </tr>
<?php
}
add_action( 'publication_edit_form_fields', 'publisher_edit_site_url', 10, 2 );


// Save extra taxonomy fields callback function.
function publisher_save_site_url( $term_id ) {
  if ( isset( $_POST['term_meta'] ) ) {
    $t_id = $term_id;
    $term_meta = get_option( "taxonomy_$t_id" );
    $cat_keys = array_keys( $_POST['term_meta'] );
    foreach ( $cat_keys as $key ) {
      if ( isset ( $_POST['term_meta'][$key] ) ) {
        $term_meta[$key] = $_POST['term_meta'][$key];
      }
    }
    // Save the option array.
    update_option( "taxonomy_$t_id", $term_meta );
  }
}  
add_action( 'edited_publication', 'publisher_save_site_url', 10, 2 );  
add_action( 'create_publication', 'publisher_save_site_url', 10, 2 );