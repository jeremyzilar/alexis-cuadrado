<?php

add_action( 'add_meta_boxes', 'supchina_article_builder_add' );

function supchina_article_builder_add() {
  add_meta_box( 'supchina_article_builder', 'Article Composer', 'supchina_article_builder', 'post', 'normal', 'core' );
}

function supchina_article_builder( $post ) {
	$values = get_post_custom( $post->ID );
  $primary_category = isset( $values['primary_category'] ) ? esc_attr( $values['primary_category'][0] ) : '';
  
  $deck = isset( $values['deck'] ) ? esc_attr( $values['deck'][0] ) : '';
  $source_url = isset( $values['source_url'] ) ? esc_attr( $values['source_url'][0] ) : '';
	$url = isset( $values['related_url'] ) ? esc_attr( $values['related_url'][0] ) : '';
  $post_display = isset( $values['post_display'] ) ? esc_attr( $values['post_display'][0] ) : '';
	$link_out = isset( $values['link_out'] ) ? esc_attr( $values['link_out'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
?>

<?php 

  function sup_categories(){
    global $post;
    $sup_categories = get_the_category( $post->ID );
    return $sup_categories;
  }

  add_action( 'admin_head', 'get_article_excerpt' );
  function get_article_excerpt() {
    global $post;
    return $post->post_excerpt;
  }

?>



<div id="composer_box">
  
  <p class="composer_block">
    <label for="article_builder_source">Kicker / Featured Category</label><br />
    <select name="primary_category" id="primary_category" class="">
      <?php 
        $sup_categories = sup_categories();
        
        // Blank option
        echo '<option'. selected( $primary_category, '' ) . ' value=""></option>';
        foreach ($sup_categories as $sup_category) {
          // print_r($sup_category);
          $cat_slug = $sup_category->category_nicename;
          $cat_name = $sup_category->cat_name;
          $cat_ID = $sup_category->cat_ID;
          
          // Passes the category ID as the value so it can be used elsewhere
          echo '<option'. selected( $primary_category, $cat_ID ) . ' value="' . $cat_ID . '">' . $cat_name . '</option>';
        }

      ?>
    </select>
  </p>

  <p class="composer_block">
    <?php $decktext = (empty($deck)) ? get_article_excerpt() : $deck ; ?>
    <label for="Deck">Deck</label><br />
    <textarea type="text" name="deck" id="deck"><?php echo $decktext ?></textarea>
    <a href="#" title="Refresh Deck" class="helper" id="refresh_deck"><small>Refresh</small></a>
  </p>

	<p class="hidden composer_block">
		<label for="related_url">Related URL</label><br />
		<input type="text" name="related_url" id="related_url" value="<?php echo $url; ?>" />
	</p>

  <p class="composer_block">
    <label for="source_url">Source URL</label><br />
    <input type="text" name="source_url" id="source_url" value="<?php echo $source_url; ?>" />
    <input type="checkbox" name="link_out" id="link_out" <?php checked( $link_out, 'on' ); ?> />
    <label for="link_out">Link Out</label>
  </p>

  <!-- post_display -->
  <p class="composer_block">
    <label>Post Display: </label>
    <label for="post_display_default">
      <input type="radio" name="post_display" id="post_display_default" value="" <?php echo ($post_display == '')? 'checked="checked"':''; ?>/>
      Default
    </label>

    <label for="post_display_inline">
      <input type="radio" name="post_display" id="post_display_inline" value="inline" <?php echo ($post_display == 'inline')? 'checked="checked"':''; ?>/>
      Inline
    </label>
    
    <label for="post_display_featured">
      <input type="radio" name="post_display" id="post_display_featured" value="featured" <?php echo ($post_display == 'featured')? 'checked="checked"':''; ?>/>
      Featured
    </label>

  </p>
  
  <p class="composer_block">
    
  </p>

</div><!-- #article_builder_box -->
<?php	}


add_action( 'save_post', 'supchina_article_builder_save' );

function supchina_article_builder_save( $post_id ) {
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
	
	// Probably a good idea to make sure your data is set
	if( isset( $_POST['primary_category'] ) )
    update_post_meta( $post_id, 'primary_category', wp_kses( $_POST['primary_category'], $allowed ) );
	
  if( isset( $_POST['deck'] ) )
    update_post_meta( $post_id, 'deck', wp_kses( $_POST['deck'], $allowed ) );

	if( isset( $_POST['related_url'] ) )
		update_post_meta( $post_id, 'related_url', wp_kses( $_POST['related_url'], $allowed ) );

  if( isset( $_POST['source_url'] ) )
    update_post_meta( $post_id, 'source_url', wp_kses( $_POST['source_url'], $allowed ) );

  //accepted values whitelist
  $displays = array('', 'inline', 'featured');

  // Post Display Options
  if(isset( $_POST['post_display'] ) && in_array($_POST['post_display'], $displays)) {
    update_post_meta( $post_id, 'post_display',  $_POST['post_display'] );
  }
		
	// This is purely my personal preference for saving checkboxes
	$link_out_chk = ( isset( $_POST['link_out'] ) && $_POST['link_out'] ) ? 'on' : 'off';
	update_post_meta( $post_id, 'link_out', $link_out_chk );

}