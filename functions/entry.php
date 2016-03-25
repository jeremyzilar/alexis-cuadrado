<?php
// Entry — All elements that make up entry

// Kicker / Primary Category
function ac_kicker(){
  global $post;
  $cat_id = get_post_meta( get_the_ID(), 'primary_category', true );
  $kicker = get_the_category_by_ID( $cat_id );
  if (!empty($cat_id) && !empty($kicker)) {
    // $kicker = get_the_category_by_ID( $cat_id );
    $the_permalink = get_category_link( $cat_id );;
    echo <<< EOF
    <h6 class="kicker"><a href="$the_permalink" title="See all from $kicker">$kicker</a></h6>
EOF;
  } else {
    return;
  }
}

function get_ac_kicker($id){
  $cat_id = get_post_meta( $id, 'primary_category', true );
  if (empty($cat_id)) {
    return;
  }
  $kicker = get_the_category_by_ID( $cat_id );
  $the_permalink = get_category_link( $cat_id );;
  return $kicker;
}

function get_ac_kicker_url($id){
  global $post;
  $cat_id = get_post_meta( $id, 'primary_category', true );
  if (empty($cat_id)) {
    return;
  }
  $kicker = get_the_category_by_ID( $cat_id );
  $the_permalink = get_category_link( $cat_id );;
  return $the_permalink;
}

function get_meta_keywords(){
  $terms = array();
  $tags = wp_get_post_tags(get_the_ID());
  foreach ($tags as $keyword) {
    $name = $keyword->name;
    array_push($terms, $name);
  }
  $categories = get_the_category( get_the_ID() );
  foreach ($categories as $keyword) {
    $name = $keyword->name;
    array_push($terms, $name);
  }

  $keywords = '';
  if (is_home() || is_archive()) {
    return $keywords = 'China, China News, Politics, Economy, Government, Business, Culture, Technology, Venture, Environment, Art';
  } else {
    return $keywords = implode(", ",$terms);
  }
}

function get_meta_description(){
  if (is_home() || is_archive()) {
    return $desc = 'China News, Media and Commentary.';
  } else {
    return $desc = get_the_excerpt();
  }
}

// Card Headlines
function ac_card_headline($source_url){
  $card_headline = get_post_meta( get_the_ID(), 'card_headline', true );
  if (empty($card_headline)) {
    $card_headline = get_the_title();
  }
  echo <<< EOF
  <h5><a href="$source_url" title="$card_headline">$card_headline</a></h5>
EOF;
}

// Update Card Headlines logic when headline changes
add_action( 'save_post', 'update_ac_card_headline' );
function update_ac_card_headline() {
  $headline = get_the_title();
  $card_headline = get_post_meta( get_the_ID(), 'card_headline', true );
  $update_headline = $_REQUEST['post_title'];
  $update_card_headline = $_REQUEST['card_headline'];
  // print_r($update_headline . ' | '. $update_card_headline . ' | ' .$card_headline. ' | ' . $headline);
  if (($headline == $card_headline) && ($update_headline !== $card_headline)) {
    update_post_meta( get_the_ID(), 'card_headline', sanitize_text_field( $update_headline ) );
  }

}

function ac_sharetools($id){
  $link = ac_permalink($id);
  $fb_share = 'http://www.facebook.com/sharer.php?s=100&p[url]=' . $link;
  $twtr = esc_html(get_the_title($id));
  echo <<< EOF
  <p class="sup-share-tools">
    <a class="btn-share btn-share-facebook" href="$fb_share" title=""><i class="fa fa-facebook"></i></a>
    <a class="btn-share btn-share-twitter" href="http://twitter.com/share?text=$twtr&url=$link&via=supchinanews" title="Share on Twitter"><i class="fa fa-twitter"></i></a>
  </p>
EOF;
}

// Deck
function ac_deck(){
  global $post;
  $deck = get_post_meta( get_the_ID(), 'deck', true );
  if (!empty($deck)) {
    echo <<< EOF
    <div class="deck">$deck</div>
    <div class="divider"></div>
EOF;
  } else {
    return;
  }
}

// DATE
function ac_entry_date( $echo = true ) {
  $date = '<p class="date"><i class="fa fa-clock-o"></i> <a href="'.get_permalink().'" title="'.the_title_attribute( 'echo=0' ).'" rel="bookmark"><time class="dt-published published entry-date rel_time" datetime="'.get_the_date('c').'"><span>'.get_the_time('F j, Y g:i a').'</span></time></a></p>';
  echo $date;
}

function ac_editlink($id){
  $edit = '';
  $status = '';
  if ( is_user_logged_in() ) {
    $status = (get_post_status($id) == 'draft') ? 'draft' : '';
    $editlink = get_edit_post_link($id);
    $edit = '<p class="edit"><a class="'.$status.'" href="'.$editlink.'" title="Edit" target="_blank"><i class="fa fa-pencil"></i></a></p>';
  }
  echo $edit;
}

function card_footer($id){
  echo <<< EOF
    <div class="entry-footer">
EOF;
  ac_editlink($id);
  ac_sharetools($id);
echo <<< EOF
    </div>
EOF;
}

// Get Display Option
function get_post_display(){
  $post_display = get_post_meta( get_the_ID(), 'post_display', true );
  return $post_display;
}

function ac_featured_media($size, $source) {
  global $post;
  if ( has_post_thumbnail() ) {
    $thumb = get_the_post_thumbnail( $post->ID, $size);
    $thumb = preg_replace( '/(width|height)="\d*"\s/', "", $thumb ); // Removes height & width
    $thumb = str_replace( 'class="', 'class="img-responsive ', $thumb );
    if (is_single()) {
      echo '<div class="media '.$size.'">' . $thumb . '</div>';
    } else {
      echo '<div class="media '.$size.'"><a href="' . $source . '">' . $thumb . '</a></div>';
    }
    
  }
}

function ac_article_media($size) {
  global $post;
  if (class_exists('MultiPostThumbnails')) {
    $thumb = MultiPostThumbnails::get_the_post_thumbnail(
      get_post_type(),
      'article-image',
      NULL,
      $size
    );
    $thumb = preg_replace( '/(width|height)="\d*"\s/', "", $thumb ); // Removes height & width
    $thumb = str_replace( 'class="', 'class="img-responsive ', $thumb );
    $caption = get_post(get_post_thumbnail_id())->post_excerpt;

    if (is_single()) {
      echo '<div class="media '.$size.'">' . $thumb . '<span class="caption">'.$caption.'</span></div>';
    } else {
      echo '<div class="media '.$size.'"><a href="' . $source . '">' . $thumb . '</a><span class="caption">'.$caption.'</span></div>';
    }
  }
}

function get_ac_featured_media($size) {
  global $post;
  if ( has_post_thumbnail() ) {
    $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $size );
    return $thumbnail[0];
  }
}

function validate_gravatar($email) {
  // Craft a potential url and test its headers
  $hash = md5(strtolower(trim($email)));
  $uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
  $headers = @get_headers($uri);
  if (!preg_match("|200|", $headers[0])) {
    $has_valid_avatar = FALSE;
  } else {
    $has_valid_avatar = TRUE;
  }
  return $has_valid_avatar;
}

function ac_byline(){
  $author = get_the_author();
  $author_id = get_the_author_meta( 'id' );
  $author_user = get_the_author_meta( 'user_login' );
  $author_email = get_the_author_meta( 'user_email' );
  $author_link = get_author_posts_url(get_the_author_meta( 'ID' ));
  if (validate_gravatar($author_email) == TRUE) {
    $author_img = get_avatar( get_the_author_meta( 'ID' ));
  } else {
    $author_img_url = the_author_image_url();
    $author_img = '';
    if (!empty($author_img_url)) {
      $author_img = '<img src="'.$author_img_url.'" alt="'.$author.'">';
    }
  }
  echo  <<< EOF
    <div class="byline">
      $author_img
       By <a href="$author_link" title="$author">$author</a>
    </div>
EOF;
}

function ac_publication($id){
  $publications = '';
  $terms = get_the_term_list( $id, 'publication', '', ', ', '' );
  if (!empty($terms)) {
    echo $publications = '<p class="source_url">via <a href="'.ac_permalink($id).'" title="Go to '.strip_tags($terms).'">' . strip_tags($terms) . '</a></p>';
  }
}

function get_ac_publication($id){
  $publications = '';
  $terms = get_the_term_list( $id, 'publication', '', ', ', '' );
  if (!empty($terms)) {
    $publications = '<a href="'.ac_permalink($id).'" title="Go to '.strip_tags($terms).'">' . strip_tags($terms) . '</a>';
  } else {
    $publications = '<a href="'.ac_permalink($id).'" title="Go to SupChina">SupChina</a>';
  }
  return $publications;
}

function ac_permalink($id){
  $link_out = get_post_meta( $id, 'link_out', true );
  if (!empty($link_out)) {
    if ($link_out == 'off') {
      $permalink = get_permalink();
    } else {
      $permalink = get_post_meta( $id, 'source_url', true );
      // print_r($permalink);
      if (empty($permalink)) {
        $permalink = get_post_meta( $id, 'bookmark_url', true );
        // print_r($permalink);
      }
    }
  } else {
    $permalink = get_post_meta( $id, 'bookmark_url', true );
    if (empty($permalink)) {
      $permalink = get_permalink();
    }
  }
  return $permalink;
}



function quote_code( $atts ) {
  $a = shortcode_atts( array(
    'q' => '',
    'c' => '',
  ), $atts );
  $quote = '';
  $cite = '';
  if (!empty($a['c'])) {
    $cite = '<cite><span>—</span> ' . $a['c'] . '</cite>';
  }
  $quote = '<blockquote class="quote"><span>“</span>' . $a['q'] . '” ' . $cite . '</blockquote>';

  return $quote;
}
add_shortcode( 'quote', 'quote_code' );