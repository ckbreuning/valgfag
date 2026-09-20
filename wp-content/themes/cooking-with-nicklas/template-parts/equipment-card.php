<?php
// Hent informationerne for billedet, beskrivelsen og købslinket fra WordPress
$picture = get_field('picture');
$description = get_field('description');
$buy_link = get_field('buy_link');

// Hvis der findes et købslink, gemmer vi det i $href. 
// Hvis linket er tomt, bruger vi et '#' som "falsk" link.
$href = $buy_link ? $buy_link : '#';
?>

<!-- esc_url sørger for at fjerne farlig kode fra linket, så det er sikkert at klikke på -->
<a class="equipment-card" href="<?php echo esc_url($href); ?>" target="_blank" rel="noopener noreferrer">
  
  <?php 
  // Tjek om der er tilføjet et billede. Hvis ja, så kør koden herunder:
  if ($picture) { ?>
    <img
      class="equipment-card__image"
      src="<?php echo esc_url($picture['url']); ?>" 
      alt="<?php echo $picture['alt']; ?>"
    >
  <?php } ?>

  <div class="equipment-card__body">
    <!-- Hent og vis den overskrift, som dette produkt har i WordPress -->
    <h3 class="equipment-card__title"><?php the_title(); ?></h3>

    <?php 
    // Tjek om der er skrevet en beskrivelse. Hvis ja, så kør koden herunder:
    if ($description) { ?>
      <!-- esc_html sørger for, at teksten er sikker at vise på siden -->
      <p class="equipment-card__text"><?php echo esc_html(wp_trim_words($description, 15)); ?></p>
    <?php } ?>

    <!-- En CTA, der fortæller brugeren, hvad der sker, når de klikker -->
    <p class="equipment-card__cta external-indicator">
      Buy on partner site <i class="fa-solid fa-arrow-up-right-from-square"></i>
    </p>
  </div>
</a>