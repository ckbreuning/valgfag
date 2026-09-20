<?php 
get_header(); 
?>

<!-- Hero -->
<section class="hero">
  <div class="hero__content">
    <p class="eyebrow">Food is more than recipes</p>
    <h1 class="hero__title">Get inspired to cook better</h1>
    <p class="hero__text">Recipes, stories and know-how from passionate home cooks, amateur cooks and professional chefs.</p>
    
    <!-- get_post_type_archive_link finder det rigtige URL til archive siden for recipes -->
    <a class="btn" href="<?php echo get_post_type_archive_link('recipe'); ?>">See recipes &rarr;</a>
  </div>

  <!-- get_theme_file_uri henter baggrundsbilledet fra images mappen -->
  <div class="hero__image" style="background-image: url(<?php echo get_theme_file_uri('/images/screenshot.png'); ?>)"></div>
</section>


<!-- Sektion med udvalgte opskrifter -->
<section class="section">
  <div class="container">
    
    <div class="section__head">
      <h2 class="section__title">Featured recipes</h2>
      <a class="section__link" href="<?php echo get_post_type_archive_link('recipe'); ?>">See all recipes &rarr;</a>
    </div>

    <div class="recipe-grid">
      <?php
        // Vi henter de 4 nyeste indlæg af typen 'recipe'
        $recipes = new WP_Query(array(
          'posts_per_page' => 4,
          'post_type' => 'recipe'
        ));

        while ($recipes->have_posts()) {
          $recipes->the_post();

          get_template_part('template-parts/recipe-card');
        }
        
        wp_reset_postdata();
      ?>
    </div>
    
  </div>
</section>


<!-- Sektion med udvalgt cookware & utensils -->
<section class="section">
  <div class="container">
    
    <div class="section__head">
      <h2 class="section__title">Cookware &amp; utensils</h2>
      <div class="section__links">
        <!-- Links til de to forskellige archive sider -->
        <a class="section__link" href="<?php echo get_post_type_archive_link('cookware'); ?>">See all cookware &rarr;</a>
        <a class="section__link" href="<?php echo get_post_type_archive_link('utensil'); ?>">See all utensils &rarr;</a>
      </div>
    </div>

    <div class="equipment-grid equipment-grid--teaser">
      <?php
        // Denne gang beder vi om 3 indlæg i alt, og de må gerne være blandet fra både 'cookware' og 'utensil'
        $equipment = new WP_Query(array(
          'posts_per_page' => 3,
          'post_type' => array('cookware', 'utensil') 
        ));

        while ($equipment->have_posts()) {
          $equipment->the_post();

          get_template_part('template-parts/equipment-card');
        }
        
        wp_reset_postdata();
      ?>
    </div>
    
  </div>
</section>

<?php 
get_footer(); 
?>