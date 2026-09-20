<?php

get_header(); ?>

<!-- Page banner -->
<section class="page-banner">
  <div class="container">
    <p class="label">Cookware</p>
    <h1 class="page-banner__title">Cookware</h1>
    <p class="page-banner__text">Pots, pans and other cookware we recommend. Every card links straight to where you can buy it.</p>
  </div>
</section>


<!-- Cookware grid -->
<section class="section">
  <div class="container">

    <?php if (have_posts()) { ?>

      <div class="equipment-grid">
        <?php
          while (have_posts()) {
            the_post();
            get_template_part('template-parts/equipment-card');
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

      <p class="archive-empty">No cookware has been added yet. Check back soon!</p>

    <?php } ?>

  </div>
</section>

<?php get_footer(); ?>
