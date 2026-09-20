<?php

$picture = get_field('picture');
$description = get_field('description');
$buy_link = get_field('buy_link');

$href = $buy_link ? $buy_link : '#';
?>

<a class="equipment-card" href="<?php echo esc_url($href); ?>" target="_blank" rel="noopener noreferrer">
  <?php if ($picture) { ?>

    <img
      class="equipment-card__image"
      src="<?php echo esc_url($picture['url']); ?>"
      alt="<?php echo esc_attr($picture['alt']); ?>"
    >
  <?php } ?>

  <div class="equipment-card__body">
    <h3 class="equipment-card__title"><?php the_title(); ?></h3>

    <?php if ($description) { ?>

      <p class="equipment-card__text"><?php echo esc_html(wp_trim_words($description, 15)); ?></p>
    <?php } ?>

    <p class="equipment-card__cta external-indicator">
      Buy on partner site <i class="fa-solid fa-arrow-up-right-from-square"></i>
    </p>
  </div>
</a>
