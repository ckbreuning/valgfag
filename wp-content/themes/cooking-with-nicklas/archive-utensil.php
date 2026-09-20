<?php
get_header(); ?>

<!-- Sidens banner -->
<section class="page-banner">
  <div class="container">
    <p class="label">Utensils</p>
    <h1 class="page-banner__title">Utensils</h1>
    <p class="page-banner__text">Knives, spatulas and other kitchen utensils we recommend.</p>
  </div>
</section>

<!-- Sektionen vises som grid -->
<section class="section">
  <div class="container">

    <?php 
    // Tjek om der er oprettet nogle redskaber i WordPress
    if (have_posts()) { ?>

      <div class="equipment-grid">
        <?php
          while (have_posts()) {
            the_post();
            
            get_template_part('template-parts/equipment-card');
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

      <!-- Hvis der ikke er tilføjet nogen redskaber -->
      <p class="archive-empty">No utensils have been added yet. Check back soon!</p>

    <?php } ?>

  </div>
</section>

<?php 
get_footer(); 
?>