<?php 
function cooking_post_types() {

  register_post_type('recipe', array(
    'public' => true,
    'show_in_rest' => true,
    'has_archive' => true,
    'rewrite' => array('slug' => 'recipes'),
    'menu_icon' => 'dashicons-carrot',
    'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'author', 'custom-fields'),
    'labels' => array(
      'name' => 'Recipes',
      'singular_name' => 'Recipe',
      'add_new_item' => 'Add New Recipe',
      'edit_item' => 'Edit Recipe',
      'all_items' => 'All Recipes'
    )
  ));

  register_post_type('cookware', array(
    'public' => true,
    'show_in_rest' => true,
    'has_archive' => true,
    'rewrite' => array('slug' => 'cookware'),
    'menu_icon' => 'dashicons-admin-tools',
    'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'author'),
    'labels' => array(
      'name' => 'Cookware',
      'singular_name' => 'Cookware',
      'add_new_item' => 'Add New Cookware',
      'edit_item' => 'Edit Cookware',
      'all_items' => 'All Cookware'
    )
  ));

  register_post_type('utensil', array(
    'public' => true,
    'show_in_rest' => true,
    'has_archive' => true,
    'rewrite' => array('slug' => 'utensils'),
    'menu_icon' => 'dashicons-admin-tools',
    'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'author'),
    'labels' => array(
      'name' => 'Utensils',
      'singular_name' => 'Utensil',
      'add_new_item' => 'Add New Utensil',
      'edit_item' => 'Edit Utensil',
      'all_items' => 'All Utensils'
    )
  ));
}
add_action('init', 'cooking_post_types');
?>