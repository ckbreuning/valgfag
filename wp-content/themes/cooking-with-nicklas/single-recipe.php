<?php
get_header();

while (have_posts()) {
  the_post();

  $picture = get_field('picture');
  $description = get_field('description');
  $total_time = get_field('total_time');
  $servings = get_field('servings');
  
  // Bruger vores funktion fra functions.php
  $ingredients = cooking_repeater_to_list(get_field('ingredients'));
  $steps = cooking_repeater_to_list(get_field('method'));
  ?>

  <main class="section">
    <div class="container">

      <a class="back-link" href="<?php echo get_post_type_archive_link('recipe'); ?>">&larr; All recipes</a>

      <div class="recipe-intro">

        <div class="recipe-intro__picture">
          <?php 
          if ($picture) { ?>
            <img src="<?php echo esc_url($picture['sizes']['featureImage'] ?? $picture['url']); ?>" alt="<?php echo esc_attr($picture['alt']); ?>">
          <?php } ?>
        </div>

        <div class="recipe-intro__content">
          <p class="label">Recipe</p>
          
          <h1 class="recipe-intro__title"><?php the_title(); ?></h1>

          <?php 
          if ($description) { ?>
            <div class="recipe-intro__description">
              <?php echo $description; ?>
            </div>
          <?php } ?>

          <div class="author author--large">
            <?php echo get_avatar(get_the_author_meta('ID'), 56); ?>
            <div>
              <p class="author__name"><?php the_author(); ?></p>
              <p class="author__role">Chef</p>
            </div>
          </div>

          <?php 
          if ($total_time || $servings) { ?>
            <div class="recipe-stats">
              
              <?php if ($total_time) { ?>
                <div class="recipe-stats__item">
                  <i class="fa-regular fa-clock"></i> 
                  <div>
                    <p class="recipe-stats__label">Total time</p>
                    <p class="recipe-stats__value"><?php echo esc_html($total_time); ?> min</p>
                  </div>
                </div>
              <?php } ?>

              <?php if ($servings) { ?>
                <div class="recipe-stats__item">
                  <i class="fa-solid fa-utensils"></i> 
                  <div>
                    <p class="recipe-stats__label">Servings</p>
                    <p class="recipe-stats__value"><?php echo esc_html($servings); ?></p>
                  </div>
                </div>
              <?php } ?>
              
            </div>
          <?php } ?>
        </div>

      </div>


      <div class="recipe-body" id="recipe-body">

        <div class="focus-backdrop" id="focus-backdrop"></div>

        <div class="recipe-ingredients" id="recipe-ingredients">
          <div class="recipe-body__head">
            <h2 class="recipe-body__title">Ingredients</h2>

            <?php 
            if ($ingredients) { ?>
              <button type="button" class="collapse-toggle" id="ingredients-toggle" aria-expanded="true" aria-controls="ingredients-content">
                <i class="fa-solid fa-chevron-up"></i>
              </button>
            <?php } ?>
          </div>

          <div class="ingredients-content" id="ingredients-content">
            <?php 
            if ($ingredients) { ?>
              <ul class="ingredient-list">
                <?php 
                foreach ($ingredients as $ingredient) { ?>
                  <li><?php echo esc_html($ingredient); ?></li>
                <?php } ?>
              </ul>
            <?php } else { ?>
              <p>No ingredients added yet.</p>
            <?php } ?>
          </div>
        </div>

        <div class="recipe-method">
          <div class="recipe-body__head">
            <h2 class="recipe-body__title">Method</h2>

            <?php 
            if ($steps) { ?>
              <button type="button" class="btn btn--small focus-toggle" id="focus-toggle">
                <i class="fa-solid fa-expand"></i> <span id="focus-toggle-label">Focus mode</span>
              </button>
            <?php } ?>
          </div>

          <?php 
          if ($steps) { ?>
            <ol class="method-list">
              <?php 
              foreach ($steps as $step) { ?>
                <li><?php echo esc_html($step); ?></li>
              <?php } ?>
            </ol>
          <?php } else { ?>
            <p>No method added yet.</p>
          <?php } ?>
        </div>

      </div>

    </div>
  </main>

<?php 
} 
get_footer(); 
?>