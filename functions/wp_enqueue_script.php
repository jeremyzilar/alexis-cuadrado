<?php


function supchina_scripts() {

  if (WP_ENV === 'development') {
    $assets = array(
      'css'       => '/assets/css/main.css',
      'js'        => '/assets/js/main-min.js',
      'modernizr' => '/assets/vendor/modernizr/modernizr.js',
      'jquery'    => '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js'
    );
  } else {
    $get_assets = file_get_contents(get_template_directory() . '/assets/manifest.json');
    $assets     = json_decode($get_assets, true);
    $assets     = array(
      'css'       => '/assets/css/main.css?' . $assets['assets/css/main.css']['hash'],
      'js'        => '/assets/js/main-min.js?' . $assets['assets/js/scripts.min.js']['hash'],
      'modernizr' => '/assets/js/vendor/modernizr.min.js',
      'jquery' => '/assets/js/jquery.min.js' // For working locally without wifi
    );
  }
  wp_enqueue_style('supchina_css', get_template_directory_uri() . $assets['css'], false, null);

  /**
   * jQuery is loaded using the same method from HTML5 Boilerplate:
   * Grab Google CDN's latest jQuery with a protocol relative URL; fallback to local if offline
   * It's kept in the header instead of footer to avoid conflicts with plugins.
   */
  if (!is_admin() && current_theme_supports('jquery-cdn')) {
    wp_deregister_script('jquery');
    wp_register_script('jquery', $assets['jquery'], array(), null, false);
    add_filter('script_loader_src', 'roots_jquery_local_fallback', 10, 2);
  }

  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  wp_enqueue_script('modernizr', get_template_directory_uri() . $assets['modernizr'], array(), null, false);
  wp_enqueue_script('jquery');
  wp_enqueue_script('sup_js', get_template_directory_uri() . $assets['js'], array(), null, true);
}
add_action('wp_enqueue_scripts', 'supchina_scripts', 100);


function load_admin_style() {
  $v = date('d');
  wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/assets/css/admin.css', false, $v, 'all' );
}
add_action( 'admin_enqueue_scripts', 'load_admin_style' );

function supchina_adminjs() {
  $v = date('d');
  wp_enqueue_script( 'admin-media', get_template_directory_uri() . '/assets/js/admin/media-min.js', array( 'media-editor' ), $v, 'all');
}
add_action( 'load-post.php', 'supchina_adminjs' );
add_action( 'load-post-new.php', 'supchina_adminjs' );

?>