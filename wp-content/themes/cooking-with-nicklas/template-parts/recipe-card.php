<?php
// Hent informationer fra WordPress 
$picture = get_field('picture');       // Billedet til opskriften
$total_time = get_field('total_time'); // Den samlede tid det tager at lave opskriften
$servings = get_field('servings');     // Antal portioner
?>

<a class="recipe-card" href="<?php the_permalink(); ?>">
  
  <?php 
  // Tjek om der findes et billede, før vi forsøger at vise det
  if ($picture) { ?>
    <img 
      class="recipe-card__image" 
      src="<?php echo esc_url($picture['sizes']['cardImage'] ?? $picture['url']); ?>" 
      alt="<?php echo $picture['alt']; ?>"
    >
  <?php } ?>

  <div class="recipe-card__body">
    <!-- Hent og vis overskriften på opskriften -->
    <h3 class="recipe-card__title"><?php the_title(); ?></h3>

    <!-- Sektion der viser hvem der har lavet opskriften -->
    <div class="author">
      <!-- Hent forfatterens profilbillede i størrelsen 40x40 pixels -->
      <?php echo get_avatar(get_the_author_meta('ID'), 40); ?>
      <div>
        <!-- Vis forfatterens navn -->
        <p class="author__name"><?php the_author(); ?></p>
        <p class="author__role">Chef</p>
      </div>
    </div>

    <?php 
    // Tjek om der enten er skrevet en total time eller et antal portioner
    if ($total_time || $servings) { ?>
      <p class="recipe-card__meta">
        
        <?php 
        if ($total_time) { ?>
          <!-- esc_html sørger for at teksten vises sikkert -->
          <span class="recipe-card__stat"><i class="fa-regular fa-clock"></i> <?php echo esc_html($total_time); ?> min</span>
        <?php } ?>
        
        <?php 
        if ($servings) { ?>
          <span class="recipe-card__stat"><i class="fa-solid fa-utensils"></i> <?php echo esc_html($servings); ?></span>
        <?php } ?>
        
      </p>
    <?php } ?>
    
  </div>
</a>