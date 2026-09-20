<?php
get_header(); ?>

<!-- Sidens banner -->
<section class="page-banner">
  <div class="container">
    <p class="label">Recipes</p>
    <h1 class="page-banner__title">All recipes</h1>
    <p class="page-banner__text">Recipes from amateur cooks and professional chefs.</p>
  </div>
</section>

<!-- Sektionen vises som grid -->
<section class="section">
  <div class="container">

    <?php 
    // Tjek om der er oprettet nogle opskrifter i WordPress
    if (have_posts()) { ?>

      <div class="recipe-grid">
        <?php
          while (have_posts()) {
            the_post();

            get_template_part('template-parts/recipe-card');
          }
        ?>
      </div>

      <!-- Sidetal i bunden -->
      <div class="pagination">
        <?php
          echo paginate_links(array(
            'prev_text' => '&larr; Previous', 
            'next_text' => 'Next &rarr;' 
          ));
        ?>
      </div>

    <?php } else { ?>

      <!-- Hvis der ikke er tilføjet nogen opskrifter -->
      <p class="archive-empty">No recipes have been published yet. Check back soon!</p>

    <?php } ?>

  </div>
</section>

<?php 
get_footer(); 
?>