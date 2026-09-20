<?php

add_action('rest_api_init', 'cooking_register_search_route');

function cooking_register_search_route() {
  register_rest_route('cooking/v1', 'search', array(
    'methods' => WP_REST_SERVER::READABLE,
    'callback' => 'cooking_search_results',
    'permission_callback' => '__return_true'
  ));
}

function cooking_search_results($data) {
  $mainQuery = new WP_Query(array(
    'post_type' => 'recipe',
    's' => sanitize_text_field($data['term']),
    'posts_per_page' => 8
  ));

  $results = array();

  while ($mainQuery->have_posts()) {
    $mainQuery->the_post();

    array_push($results, array(
      'title' => get_the_title(),
      'permalink' => get_the_permalink()
    ));
  }

  wp_reset_postdata();

  return $results;
}
