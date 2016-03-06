<?php

ini_set( 'upload_max_size' , '64M' );
ini_set( 'post_max_size', '64M');
ini_set( 'max_execution_time', '300' );

include_once 'functions/wp_enqueue_script.php';
include_once 'functions/loop.php';
include_once 'functions/images.php';
include_once 'functions/publications-taxonomy.php';
include_once 'functions/article-composer.php';
include_once 'functions/card-composer.php';
include_once 'functions/entry.php';
include_once 'functions/collections.php';
include_once 'functions/collection-composer.php';
include_once 'functions/bookmarks.php';
include_once 'functions/bookmark-composer.php';
include_once 'functions/jsonapi.php';



// Variables
if (! defined('WP_ENV'))
{
	define('WP_ENV', 'production');	// default to production environment
}

$tdir = get_template_directory_uri();
define('TDIR', $tdir);

$theme = get_template_directory_uri();
define('THEME', $theme);

$root = get_template_directory();
define('ROOT', $root);

// Includes Path
$inc = $root . '/inc/';
define('INC', $inc);

// Cards Path
$card = $root . '/cards/';
define('CARD', $card);

// Templates Path
$temp = $root . '/templates/';
define('TEMP', $temp);


$home_url = esc_url( home_url( '/' ) );
define('HOMEURL', $home_url);


// Hide WP Admin Bar
add_filter('show_admin_bar', '__return_false');
add_theme_support( 'infinite-scroll', array(
  'type'           => 'click',
  'container'      => 'stream-box',
  'render'         => 'stream_loop'
) );

add_theme_support( 'post-thumbnails' );


// Multiple POst Thumbnails
// See — https://github.com/voceconnect/multi-post-thumbnails/wiki
if (class_exists('MultiPostThumbnails')) {
  new MultiPostThumbnails(
    array(
      'label' => 'Article Image',
      'id' => 'article-image',
      'post_type' => 'post'
    )
  );
}


// Register a Menu
function supchina_register_menu() {
  register_nav_menu('app-menu',__( 'App Menu' ));
  register_nav_menu('list-maker',__( 'List Maker' ));
  register_nav_menu('site-nav',__( 'Site Nav' ));
  register_nav_menu('stream-nav',__( 'Stream Nav' ));
  register_nav_menu('footer-nav',__( 'Footer Nav' ));
}
add_action( 'init', 'supchina_register_menu' );





// Nav Menu
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class($classes, $item){
	if( in_array('current-menu-item', $classes) ){
		$classes[] = 'active ';
	}
	return $classes;
}



// if (!is_admin()) {
// 	// If Logged In, Add DRAFTS to Query
// 	if ( is_user_logged_in() ) {
// 		add_action( 'pre_get_posts', 'add_my_post_status_to_query' );
// 		function add_my_post_status_to_query( $query ) {
//       global $wp_query;
//       $args = array_merge( $wp_query->query, array( 'post_status' => array('publish', 'draft') ) );
//       query_posts( $args );
// 			if ( is_home() && $query->is_main_query() || is_feed())
// 				$query->set(
// 					'post_status', array('publish', 'draft')
// 				);
// 			return $query;
// 		}
// 	}

// }



function new_excerpt_more( $more ) {
	return '';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );


function custom_excerpt_length( $length ) {
	return 35;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


