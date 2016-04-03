<?php 

add_action('init', 'register_albums');
function register_albums() {
  register_post_type('album', array(
    'label'              => 'Albums',
    'labels'             => array(
      'name'               => _x('Albums', 'post type general name'),
      'singular_name'      => _x('Album', 'post type singular name'),
      'add_new'            => _x('Add New', 'ac_album'),
      'add_new_item'       => __('Add New Album'),
      'edit_item'          => __('Edit Album'),
      'new_item'           => __('New Album'),
      'view_item'          => __('View Album'),
      'search_items'       => __('Search Album'),
      'not_found'          => __('No albums found'),
      'not_found_in_trash' => __('No albums found in Trash'),
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
    'slug'               => 'album',
    'hierarchical'       => false,
    'menu_icon'          => 'dashicons-album'
  ));

}

