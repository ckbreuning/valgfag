<?php get_header(); ?>

<!-- Hero -->
<section class="hero">
  <div class="hero__content">
    <p class="eyebrow">Food is more than recipes</p>
    <h1 class="hero__title">Get inspired to cook better</h1>
    <p class="hero__text">Recipes, stories and know-how from passionate home cooks, amateur chefs and professional chefs.</p>
    <a class="btn" href="<?php echo get_post_type_archive_link('recipe'); ?>">See recipes &rarr;</a>
  </div>

  <div class="hero__image" style="background-image: url(<?php echo get_theme_file_uri('/images/screenshot.png'); ?>)"></div>
</section>


<!-- Recipes -->
<section class="section">
  <div class="container">
    <div class="section__head">
      <h2 class="section__title">Featured recipes</h2>
      <a class="section__link" href="<?php echo get_post_type_archive_link('recipe'); ?>">See all recipes &rarr;</a>
    </div>

    <div class="recipe-grid">
      <?php
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


<!-- Cookware & utensils -->
<section class="section">
  <div class="container">
    <div class="section__head">
      <h2 class="section__title">Cookware &amp; utensils</h2>
      <div class="section__links">
        <a class="section__link" href="<?php echo get_post_type_archive_link('cookware'); ?>">See all cookware &rarr;</a>
        <a class="section__link" href="<?php echo get_post_type_archive_link('utensil'); ?>">See all utensils &rarr;</a>
      </div>
    </div>

    <div class="equipment-grid equipment-grid--teaser">
      <?php
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

<?php get_footer(); ?>
