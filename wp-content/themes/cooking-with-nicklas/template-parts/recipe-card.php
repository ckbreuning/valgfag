<?php

$picture = get_field('picture');
$total_time = get_field('total_time');
$servings = get_field('servings');
?>

<a class="recipe-card" href="<?php the_permalink(); ?>">
  <?php if ($picture) { ?>
    <img class="recipe-card__image" src="<?php echo esc_url($picture['sizes']['cardImage'] ?? $picture['url']); ?>" alt="<?php echo esc_attr($picture['alt']); ?>">
  <?php } ?>

  <div class="recipe-card__body">
    <h3 class="recipe-card__title"><?php the_title(); ?></h3>

    <div class="author">
      <?php echo get_avatar(get_the_author_meta('ID'), 40); ?>
      <div>
        <p class="author__name"><?php the_author(); ?></p>
        <p class="author__role">Chef</p>
      </div>
    </div>

    <?php if ($total_time || $servings) { ?>
      <p class="recipe-card__meta">
        <?php if ($total_time) { ?>
          <span class="recipe-card__stat"><i class="fa-regular fa-clock"></i> <?php echo esc_html($total_time); ?> min</span>
        <?php } ?>
        <?php if ($servings) { ?>
          <span class="recipe-card__stat"><i class="fa-solid fa-utensils"></i> <?php echo esc_html($servings); ?></span>
        <?php } ?>
      </p>
    <?php } ?>
  </div>
</a>
