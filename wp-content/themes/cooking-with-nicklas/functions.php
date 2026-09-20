<?php

// Load fonts, Font Awesome, and stylesheet
function cooking_files() {
  wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Rufina:wght@400;700&display=swap');

  wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css');

  wp_enqueue_style('cooking_main_styles', get_stylesheet_uri(), array(), filemtime(get_stylesheet_directory() . '/style.css'));

  if (is_page('create-recipe')) {
    wp_enqueue_script('cooking-recipe-form', get_theme_file_uri('/js/create-recipe.js'), array(), '1.0', true);
  }

  if (is_singular('recipe')) {
    wp_enqueue_script('cooking-single-recipe', get_theme_file_uri('/js/single-recipe.js'), array(), '1.0', true);
  }

  // Live search
  wp_enqueue_script('cooking-live-search', get_theme_file_uri('/js/live-search.js'), array(), '1.0', true);

  wp_localize_script('cooking-live-search', 'cookingSearch', array(
    'restUrl' => esc_url_raw(rest_url('wp/v2/recipe'))
  ));
}
add_action('wp_enqueue_scripts', 'cooking_files');


// Theme features
function cooking_features() {
  register_nav_menu('headerMenuLocation', 'Header Menu');
  register_nav_menu('footerMenuLocation', 'Footer Menu');

  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');

  add_image_size('cardImage', 600, 400, true);
  add_image_size('featureImage', 900, 700, true);
}
add_action('after_setup_theme', 'cooking_features');

function cooking_adjust_queries($query) {
  if (!is_admin() && is_post_type_archive('recipe') && $query->is_main_query()) {
    $query->set('posts_per_page', 12);
  }

  if (!is_admin() && is_post_type_archive(array('cookware', 'utensil')) && $query->is_main_query()) {
    $query->set('posts_per_page', 12);
  }
}
add_action('pre_get_posts', 'cooking_adjust_queries');

function cooking_user_can_manage_recipes($user = null) {

  if (!$user) {
    if (!is_user_logged_in()) {
      return false;
    }
    $user = wp_get_current_user();
  }

  $allowed_roles = array('amateur_cook', 'professional_chef', 'administrator');

  return (bool) array_intersect($allowed_roles, $user->roles);
}

function cooking_repeater_to_list($rows) {

  if (empty($rows)) {
    return array();
  }

  if (is_string($rows)) {
    return array_values(array_filter(array_map('trim', explode("\n", $rows))));
  }

  $list = array();

  foreach ($rows as $row) {
    $value = is_array($row) ? reset($row) : $row;

    if ($value !== '' && $value !== false && $value !== null) {
      $list[] = $value;
    }
  }

  return $list;
}
function cooking_add_recipe_menu_item($items, $args) {

  $gated_locations = array('headerMenuLocation', 'footerMenuLocation');

  if (!in_array($args->theme_location, $gated_locations)) {
    return $items;
  }

  if (!cooking_user_can_manage_recipes()) {
    return $items;
  }

  $items .= '<li class="menu-item"><a href="' . esc_url(home_url('/create-recipe/')) . '">Create &amp; edit recipes</a></li>';

  return $items;
}
add_filter('wp_nav_menu_items', 'cooking_add_recipe_menu_item', 10, 2);
