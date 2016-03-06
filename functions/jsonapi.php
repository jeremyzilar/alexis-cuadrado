<?php

function supchina_collections_endpoint( $data ) {
  $data = collection_feed_loop('50');
  if ( empty( $data ) ) {
    return null;
  }
  return $data;
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'supchina/v1', '/collections/', array(
      'methods' => 'GET',
      'callback' => 'supchina_collections_endpoint',
  ) );
} );
