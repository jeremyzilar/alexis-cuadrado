<?php

add_action('init', 'register_collections');
function register_collections() {
  // collections are stored in a custom post type 'bookmark'
  register_post_type('collection', array(
    'label'              => 'Collections',
    'labels'             => array(
      'name'               => _x('Collections', 'post type general name'),
      'singular_name'      => _x('Collection', 'post type singular name'),
      'add_new'            => _x('Add New', 'sg_collection'),
      'add_new_item'       => __('Add New Collection'),
      'edit_item'          => __('Edit Collection'),
      'new_item'           => __('New Collection'),
      'view_item'          => __('View Collection'),
      'search_items'       => __('Search collection'),
      'not_found'          => __('No collections found'),
      'not_found_in_trash' => __('No collections found in Trash'),
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
    'supports'           => array('title','excerpt','thumbnail','custom-fields'),
    'slug'               => 'collection',
    'rewrite' => array('slug' => 'collection'),
    'hierarchical'       => false,
  ));
}