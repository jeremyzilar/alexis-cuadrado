<?php

add_action( 'add_meta_boxes', 'supchina_card_builder_add' );

function supchina_card_builder_add() {
  add_meta_box( 'supchina_card_builder', 'Card Builder', 'supchina_card_builder', 'post', 'normal', 'core' );
}

function supchina_card_builder( $post ) {
	$values = get_post_custom( $post->ID );
  $card_type = isset( $values['card_type'] ) ? esc_attr( $values['card_type'][0] ) : '';
  $card_headline = isset( $values['card_headline'] ) ? esc_attr( $values['card_headline'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
?>


<?php 
  add_action( 'admin_head', 'get_card_heading' );
  function get_card_heading() {
    global $post;
    return $post->post_title;
  }

  // Reads the PHP Comment at the top of the Card File
  // If the file has 'Card: VALUE'
  // It returns the VALUE
  function get_card_info($file){
    $template_data = get_file_data( $file , array( 'Card' => 'Card' ) );
    if (!empty($template_data['Card'])) {
      return $template_data['Card'];
    }
  }

  function get_custom_cards(){
    //path to directory to scan
    $directory = ROOT . '/cards/';
    //get all files with a .php extension.
    $files = glob($directory . "*.php");
    $cards = array();
    foreach($files as $file){
      $name = get_card_info($file);
      $filename = basename($file, '.php');
      $cardarray = array($filename => $name);
      array_push($cards, $cardarray);
    }
    return $cards;
  }

?>



<div id="card_builder_box" class="composer_box">

  <p class="composer_block">
    <label for="card_type">Card Type</label><br />
    <select name="card_type" id="card_type" class="">
      <?php 
        $custom_cards = get_custom_cards();
        echo '<option'. selected( $card_type, '' ) . ' value="">---</option>';
        foreach ( $custom_cards as $custom_card ) {
          foreach ($custom_card as $filename => $name) {
            echo '<option'. selected( $card_type, $filename ) . ' value="' . $filename . '">' . $name . '</option>';
          }
        }
      ?>
    </select>
  </p>

  <p class="composer_block">
    <?php $head = (empty($card_headline)) ? get_card_heading() : $card_headline ; ?>
		<label for="card_builder_source">Card Headline</label><br />
		<input type="text" name="card_headline" id="card_headline" value="<?php echo $head ?>" />
    <a href="#" title="Refresh Headline" class="helper" id="refresh_headline"><small>Refresh</small></a>
	</p>

</div><!-- #card_builder_box -->
<?php	}

add_action( 'save_post', 'supchina_card_builder_save' );

function supchina_card_builder_save( $post_id ) {
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
	if( isset( $_POST['card_type'] ) )
    update_post_meta( $post_id, 'card_type', wp_kses( $_POST['card_type'], $allowed ) );

  if( isset( $_POST['card_headline'] ) )
		update_post_meta( $post_id, 'card_headline', wp_kses( $_POST['card_headline'], $allowed ) );
}