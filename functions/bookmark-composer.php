<?php

add_action( 'add_meta_boxes', 'supchina_bookmark_composer_add' );

function supchina_bookmark_composer_add() {
  add_meta_box( 'supchina_bookmark_composer', 'Bookmark Composer', 'supchina_bookmark_composer', 'bookmark', 'normal', 'high' );
}

function supchina_bookmark_composer( $post ) {
	$values = get_post_custom( $post->ID );
  
  $bookmark_url = isset( $values['bookmark_url'] ) ? esc_attr( $values['bookmark_url'][0] ) : '';
	$bookmark_desc = isset( $values['bookmark_desc'] ) ? esc_attr( $values['bookmark_desc'][0] ) : '';

	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
?>


<div id="composer_box">

	<p class="composer_block">
		<label for="bookmark_url">URL</label><br />
		<input type="text" name="bookmark_url" id="bookmark_url" value="<?php echo $bookmark_url; ?>" />
	</p>

  <p class="composer_block">
    <label for="bookmark_desc">Description</label><br />
    <textarea id="bookmark_desc" name="bookmark_desc"><?php echo $bookmark_desc; ?></textarea>
  </p>


</div><!-- #bookmark_composer_box -->
<?php	}


add_action( 'save_post', 'supchina_bookmark_composer_save' );

function supchina_bookmark_composer_save( $post_id ) {
	// Bail if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	
	// if our nonce isn't there, or we can't verify it, bail
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
		
	if( isset( $_POST['bookmark_url'] ) )
		update_post_meta( $post_id, 'bookmark_url', wp_kses( $_POST['bookmark_url'], $allowed ) );

  if( isset( $_POST['bookmark_desc'] ) )
    update_post_meta( $post_id, 'bookmark_desc', wp_kses( $_POST['bookmark_desc'], $allowed ) );

	update_post_meta( $post_id, 'my_meta_box_check', $chk );

}