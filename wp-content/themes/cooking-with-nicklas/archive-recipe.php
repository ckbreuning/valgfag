<?php

get_header(); ?>

<!-- Page banner -->
<section class="page-banner">
  <div class="container">
    <p class="label">Recipes</p>
    <h1 class="page-banner__title">All recipes</h1>
    <p class="page-banner__text">Recipes from home cooks, amateur chefs and professional chefs. Pick one and start cooking.</p>
  </div>
</section>


<!-- Recipe grid -->
<section class="section">
  <div class="container">

    <?php if (have_posts()) { ?>

      <div class="recipe-grid">
        <?php
          while (have_posts()) {
            the_post();

            get_template_part('template-parts/recipe-card');
          }
        ?>
      </div>

      <div class="pagination">
        <?php
          echo paginate_links(array(
            'prev_text' => '&larr; Previous',
            'next_text' => 'Next &rarr;'
          ));
        ?>
      </div>

    <?php } else { ?>

      <p class="archive-empty">No recipes have been published yet. Check back soon!</p>

    <?php } ?>

  </div>
</section>

<?php get_footer(); ?>
