<?php 

// add_action('init', 'register_mypost_type');
function register_mypost_type() {
  // bookmarks are stored in a custom post type 'bookmark'
  register_post_type('bookmark', array(
    'label'              => 'Bookmarks',
    'labels'             => array(
      'name'               => _x('Bookmarks', 'post type general name'),
      'singular_name'      => _x('Bookmark', 'post type singular name'),
      'add_new'            => _x('Add New', 'sg_bookmark'),
      'add_new_item'       => __('Add New Bookmark'),
      'edit_item'          => __('Edit Bookmark'),
      'new_item'           => __('New Bookmark'),
      'view_item'          => __('View Bookmark'),
      'search_items'       => __('Search Bookmarks'),
      'not_found'          => __('No bookmarks found'),
      'not_found_in_trash' => __('No bookmarks found in Trash'),
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
    'supports'           => array('title','thumbnail','custom-fields'),
    'taxonomies'         => array('category', 'publication'),
    'slug'               => 'bookmark',
    'rewrite' => array('slug' => 'wire'),
    'hierarchical'       => false,
  ));

}



function file_get_contents_curl($url) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17');
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_AUTOREFERER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, 'text/plain;charset=UTF-8');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_COOKIEJAR, "curl_login_cookie.txt");
  curl_setopt($ch, CURLOPT_COOKIEFILE, "curl_login_cookie.txt");
  curl_setopt($ch, CURLOPT_URL, $url);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}


function worthreadingJs(){
  $bookmarkjs = "javascript:(function(){var desc = '&desc=' + encodeURI(document.getSelection()); if (!desc.length) {desc = ''} var url = '" . get_bloginfo('wpurl') . "/add-bookmark/?url=' + encodeURIComponent(location.href) + desc; window.open(url,'bookmark','left=20,top=20,width=550,height=500,toolbar=0,location=0,resizable=1'); })();";
  return $bookmarkjs;
}


function worthreadingForm(){

  if(isset($_GET['url'])){
  
    $source_url = preg_replace('/\?.*/', '', $_GET['url']) . '?=supchina';
    $bookmark_data = file_get_contents_curl($source_url);

  } else {
  
    $source_url = '';
    $bookmark_data = file_get_contents_curl($source_url);
  
  }

  //parsing begins here:
  $doc = new DOMDocument();
  @$doc->loadHTML($bookmark_data);

  //get and display what you need:
  $nodes = $doc->getElementsByTagName('title');
  $titletag = $nodes->item(0)->nodeValue;

  $metas = $doc->getElementsByTagName('meta');
  
  for ($i = 0; $i < $metas->length; $i++) {
    $meta = $metas->item($i);

    // bookmark_headline
    if($meta->getAttribute('property') == 'og:title'){
      $bookmark_headline = utf8_decode($meta->getAttribute('content'));
    }

    if (empty($bookmark_headline)) {
      $bookmark_headline = utf8_decode($titletag);
    }

    // bookmark_desc
    if(empty($_GET['desc'])){
      if($meta->getAttribute('property') == 'og:description'){
        $bookmark_desc = utf8_decode($meta->getAttribute('content'));
      }
      if(($meta->getAttribute('name') == 'description') && empty($bookmark_desc)){
        $bookmark_desc = utf8_decode($meta->getAttribute('content'));
      }
    } else {
      $bookmark_desc = utf8_decode($_GET['desc']);
    }



    // Keywords
    if($meta->getAttribute('name') == 'keywords'){
      $bookmark_keywords = $meta->getAttribute('content');
    }


    // Site Name
    if($meta->getAttribute('name') == 'cre'){ // for NYTimes.com only
      $nyt_cre = utf8_decode($meta->getAttribute('content'));
    }
    if($meta->getAttribute('property') == 'og:site_name'){
      $bookmark_site_name = utf8_decode($meta->getAttribute('content'));
    }
    if (!empty($nyt_cre)) {
      $bookmark_site_name = $nyt_cre;
    }

    // Image
    if($meta->getAttribute('property') == 'og:image'){
      $bookmark_img = $meta->getAttribute('content');
    }
    if (empty($bookmark_img)) {
      $bookmark_image = '';
    } else {
      $bookmark_image = '<img src="' . $bookmark_img . '" alt="' . $bookmark_headline . '" class="thumb">';
    }
  }

  ?>


  <form id="new_post" name="new_post" method="post" action="" enctype="multipart/form-data">
    <div class="bookmark-title form-group">
      <label for="bookmark_title">Headline:</label>
      <input class="form-control" type="text" id="bookmark_title" tabindex="1" name="title" value="<?php if (strlen($bookmark_headline) > 0 ) { echo $bookmark_headline; } ?>" /> 

      <p><i class="fa fa-link"></i> <?php echo $source_url; ?></p>
      <input class="form-control" type="hidden" id="source_url" tabindex="2" name="source_url" value="<?php echo $source_url; ?>" />
      <input class="form-control" type="hidden" id="link_out" tabindex="2" name="link_out" value="on" />
    </div>
    

    <div class="bookmark-desc form-group">
      <label for="bookmark_desc">Summary</label>
      <textarea class="form-control" type="text" id="bookmark_desc" tabindex="3" name="bookmark_desc" /><?php echo $bookmark_desc; ?></textarea>
    </div>

    <div class="bookmark-category form-group">
      <label for="bookmark_category">Category</label>
      <select name="bookmark_category" class="form-control">
        <?php
          $categories = get_categories( );
          foreach ($categories as $cat) {
            $cat_name = $cat->name;
            $cat_slug = $cat->slug;
            $cat_id = $cat->term_id;
            echo '<option value="'.$cat_id.'">'.$cat_name.'</option>';
          }
        ?>
      </select>
    </div>

    <div class="bookmark-img form-group">
      <label for="bookmark_image">Image</label>
      <?php echo $bookmark_image; ?>
      <input class="form-control" type="text" id="bookmark_image" tabindex="6" name="bookmark_image" value="<?php echo $bookmark_img; ?>" />
      
    </div>

    <div class="bookmark-pub form-group">
      <label for="bookmark_publications">Publication</label>
      <input class="form-control" type="text" id="bookmark_publications" tabindex="4" name="bookmark_publications" value="<?php if (strlen($bookmark_site_name) > 0 ) { echo $bookmark_site_name; } ?>" />
      <small>e.g. The New York Times</small>
    </div>

    <div class="bookmark-keywords form-group">
      <label for="bookmark-keywords">Keywords / Tags</label>
      <input class="form-control" type="text" id="keywords" tabindex="2" name="keywords" value="<?php //echo $bookmark_keywords; ?>" />
    </div>

    <script>window.onload=function(){ document.getElementById('link_desc').focus(); }</script>
    
    <div id="bookmark-footer">
      <input type="submit" value="Draft" tabindex="40" id="draft" class="btn btn-default" name="submit" /> 
      <input type="submit" value="Publish" tabindex="40" id="submit" class="btn btn-primary" name="submit" /> 
    </div>
    
    <input type="hidden" name="action" value="new_post" />
    <?php wp_nonce_field( 'new_post' ); ?>

  </form>

<?php 
}



function worthreadingHeader(){
  if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) &&  $_POST['action'] == "new_post") {

    if (!is_user_logged_in()) {
      wp_redirect( get_bloginfo( 'url' ) . '/' );
      exit;
    }

    if( !current_user_can('publish_posts')) {
      wp_redirect( get_bloginfo( 'url' ) . '/' );
      exit;
    }

    // check that the two compulsory fields are filled
    if ( strlen($_POST['title']) > 0 && strpos($_POST['source_url'], 'http') !== FALSE ) {
      if ($_POST['submit'] == 'Draft') {
        $post_status = 'draft';
      }
      if ($_POST['submit'] == 'Publish'){
        $post_status = 'publish';
      }
      // print_r($_POST['keywords']);
      // die;
      // create the custom post entry
      $new_post = array(
        'post_title'  =>  $_POST['title'],
        'post_excerpt'=>  $_POST['bookmark_desc'],
        'tax_input'   =>  array( 'publication' => explode(",", $_POST['bookmark_publications']), 'post_tag' => explode(",", $_POST['keywords']) ),
        'post_status' =>  $post_status,
        'post_type'   =>  'post',
        'post_category' => array($_POST['bookmark_category'])
      );
      $post_id = wp_insert_post($new_post, true);
      // wp_set_object_terms();
      // add in the bookmark image
      $imgfile = $_POST['bookmark_image'];
      require_once(ABSPATH . 'wp-admin' . '/includes/image.php');
      require_once(ABSPATH . 'wp-admin' . '/includes/file.php');
      require_once(ABSPATH . 'wp-admin' . '/includes/media.php');
      $file = media_sideload_image( $imgfile, $post_id, $_POST['title'] );
      $attachments = get_posts(array('numberposts' => '1', 'post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC'));
      if(sizeof($attachments) > 0){
        // set image as the post thumbnail
        set_post_thumbnail($post_id, $attachments[0]->ID);
      } 

      // add the bookmark's meta data
      add_post_meta($post_id, 'post_display', 'inline',  true);
      add_post_meta($post_id, 'primary_category',  $_POST['bookmark_category'],  true);
      add_post_meta($post_id, 'source_url',  $_POST['source_url'],  true);
      add_post_meta($post_id, 'link_out',  $_POST['link_out'],  true);
      
      // add_post_meta($post_id, 'bookmark_desc', $_POST['bookmark_desc'], true);

      // give positive user feedback
      if ($post_status == 'draft') {
        $status = 'Draft Saved!';
      } else {
        $status = 'Published!';
      }
      echo <<< EOF
      <div class="msg">
        <p>$status</p>
        <button onClick="window.close();" class="btn">Close</button>  
      </div>
      <script>window.onload=function(){ document.getElementById('focusbutton').focus(); }</script>
EOF;

    } else {
      
      echo <<< EOF
      <div class="msg">
        <p>Please enter at least a title and URL for the bookmark.</p>
        <button onClick="window.history.go(-1);" id="focusbutton">Back</button>
      </div>
      <script>window.onload=function(){ document.getElementById('focusbutton').focus(); }</script>
EOF;
    }
  }
}

// pass wpurl from php to js
function worthreading_jsvars() {
  ?><script type='text/javascript'>
  // <![CDATA[
  var ajaxUrl = "<?php echo esc_js( get_bloginfo( 'wpurl' ) . '/wp-admin/admin-ajax.php' ); ?>";
  //]]>
  </script><?php
}

// Actions
add_action('get_header', 'worthreadingHeader');
add_action('wp_head', 'worthreading_jsvars');

