<?php

require get_theme_file_path('/search-route.php');

function cooking_files() {
  wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Rufina:wght@400;700&display=swap');

  wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css');

  wp_enqueue_style('cooking_main_styles', get_stylesheet_uri());

  // Hvis vi er inde på en enkelt opskrift, indlæser vi et script til den
  if (is_singular('recipe')) {
    wp_enqueue_script('cooking-single-recipe', get_theme_file_uri('/js/single-recipe.js'));
  }

  // Indlæs vores JavaScript til Live-search
  wp_enqueue_script('cooking-live-search', get_theme_file_uri('/js/live-search.js'));

  // Giv vores live-search script en besked om, hvilket URL den skal sende requests til
  wp_localize_script('cooking-live-search', 'cookingSearch', array(
    'root_url' => get_site_url()
  ));
}

add_action('wp_enqueue_scripts', 'cooking_files');

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

// En funktion, der tager en tekst med flere linjer og laver den om til en liste
function cooking_repeater_to_list($rows) {  
  
  // Hvis feltet er helt tomt, stopper vi og returnerer en tom liste
  if (empty($rows)) {    
    return array();  
  }  
  
  // https://stackoverflow.com/questions/5047533/php-equivalent-to-javascripts-string-split-method + https://stackoverflow.com/questions/7058168/explode-textarea-php-at-new-lines fundet via google
  $lines = explode("\n", $rows); 
  
  // Gør en ny, tom liste klar.
  $list = array();

  // Gå igennem alle linjerne fra vores tekst.
  foreach ($lines as $line) {
    
    $line = trim($line); 

    // Tjek om linjen indeholder noget tekst.
    if ($line !== '') {
      
      // Hvis linjen ikke er tom, putter vi den over i vores nye array.
      $list[] = $line; 
    }
  }

  // Send den færdige liste tilbage, så den kan bruges på hjemmesiden.
  return $list;
}

?>