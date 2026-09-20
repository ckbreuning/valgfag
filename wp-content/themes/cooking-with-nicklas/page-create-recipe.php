<?php
if (!is_user_logged_in()) {
  wp_redirect(wp_login_url(home_url('/create-recipe/')));
  exit;
}

if (!cooking_user_can_manage_recipes()) {
  wp_redirect(home_url('/'));
  exit;
}

$current_user_id = get_current_user_id();

$editing_recipe_id = 0;

if (!empty($_GET['edit_recipe'])) {
  $requested_id = absint($_GET['edit_recipe']);
  $requested_recipe = get_post($requested_id);

  if (
    $requested_recipe &&
    $requested_recipe->post_type === 'recipe' &&
    (int) $requested_recipe->post_author === $current_user_id
  ) {
    $editing_recipe_id = $requested_id;
  } else {
    wp_redirect(home_url('/create-recipe/'));
    exit;
  }
}

$form_error = '';

if (!empty($_POST['cooking_recipe_submit'])) {

  if (!wp_verify_nonce($_POST['cooking_recipe_nonce'] ?? '', 'cooking_save_recipe')) {

    $form_error = 'Your session expired, please try again.';

  } else {

    $title = sanitize_text_field($_POST['title'] ?? '');
    $description = sanitize_textarea_field($_POST['description'] ?? '');
    $total_time = absint($_POST['total_time'] ?? 0);
    $servings = absint($_POST['servings'] ?? 0);

    $ingredient_inputs = $_POST['ingredient'] ?? array();
    $step_inputs = $_POST['step'] ?? array();

    if ($title === '') {

      $form_error = 'Please give your recipe a title.';

    } else {

      $post_data = array(
        'post_type' => 'recipe',
        'post_status' => 'publish',
        'post_title' => $title,
        'post_author' => $current_user_id
      );

      if ($editing_recipe_id) {
        $post_data['ID'] = $editing_recipe_id;
        $saved_id = wp_update_post($post_data, true);
      } else {
        $saved_id = wp_insert_post($post_data, true);
      }

      if ($saved_id && !is_wp_error($saved_id)) {

        update_field('description', $description, $saved_id);
        update_field('total_time', $total_time, $saved_id);
        update_field('servings', $servings, $saved_id);

        $clean_ingredients = array();
        foreach ($ingredient_inputs as $ingredient) {
          $ingredient = sanitize_text_field($ingredient);
          if ($ingredient !== '') {
            $clean_ingredients[] = $ingredient;
          }
        }
        update_field('ingredients', implode("\n", $clean_ingredients), $saved_id);

        $clean_steps = array();
        foreach ($step_inputs as $step) {
          $step = sanitize_textarea_field($step);
          if ($step !== '') {
            $clean_steps[] = $step;
          }
        }
        update_field('method', implode("\n", $clean_steps), $saved_id);

        $picture_alt = sanitize_text_field($_POST['picture_alt'] ?? '');

        if (!empty($_FILES['picture']['name'])) {
          require_once ABSPATH . 'wp-admin/includes/image.php';
          require_once ABSPATH . 'wp-admin/includes/file.php';
          require_once ABSPATH . 'wp-admin/includes/media.php';

          $attachment_id = media_handle_upload('picture', $saved_id);

          if (!is_wp_error($attachment_id)) {
            update_field('picture', $attachment_id, $saved_id);
            update_post_meta($attachment_id, '_wp_attachment_image_alt', $picture_alt);
          }
        } elseif ($editing_recipe_id) {
          $current_picture = get_field('picture', $saved_id);
          if ($current_picture) {
            update_post_meta($current_picture['ID'], '_wp_attachment_image_alt', $picture_alt);
          }
        }

        wp_redirect(get_permalink($saved_id));
        exit;

      } else {
        $form_error = 'Something went wrong saving your recipe, please try again.';
      }
    }
  }
}


get_header();

$existing_title = $editing_recipe_id ? get_the_title($editing_recipe_id) : '';
$existing_description = $editing_recipe_id ? get_field('description', $editing_recipe_id) : '';
$existing_total_time = $editing_recipe_id ? get_field('total_time', $editing_recipe_id) : '';
$existing_servings = $editing_recipe_id ? get_field('servings', $editing_recipe_id) : '';
$existing_picture = $editing_recipe_id ? get_field('picture', $editing_recipe_id) : null;

$existing_ingredients = $editing_recipe_id ? cooking_repeater_to_list(get_field('ingredients', $editing_recipe_id)) : array();
if (!$existing_ingredients) {
  $existing_ingredients = array('');
}

$existing_steps = $editing_recipe_id ? cooking_repeater_to_list(get_field('method', $editing_recipe_id)) : array();
if (!$existing_steps) {
  $existing_steps = array('');
}
?>

<main class="section">
  <div class="container">
    <div class="form-page">

      <p class="label">Share your cooking</p>

      <?php if ($editing_recipe_id) : ?>
        <h1 class="form-page__title">Edit your recipe</h1>
        <p class="form-page__text">Make your changes below and save to update the recipe.</p>
      <?php else : ?>
        <h1 class="form-page__title">Create a recipe</h1>
        <p class="form-page__text">Fill in the details below and your recipe will be published on the site straight away.</p>
      <?php endif; ?>

      <?php if ($form_error) : ?>
        <p class="form-error"><?php echo esc_html($form_error); ?></p>
      <?php endif; ?>

      <form class="recipe-form" method="post" enctype="multipart/form-data">
        <?php wp_nonce_field('cooking_save_recipe', 'cooking_recipe_nonce'); ?>

        <div class="recipe-field">
          <label for="title">Title</label>
          <input type="text" id="title" name="title" value="<?php echo esc_attr($existing_title); ?>" required>
        </div>

        <div class="recipe-field">
          <label for="description">Description</label>
          <textarea id="description" name="description" rows="4"><?php echo esc_textarea($existing_description); ?></textarea>
        </div>

        <div class="recipe-field">
          <label for="picture">Picture</label>
          <?php if ($existing_picture) : ?>
            <img class="recipe-field__current-image" src="<?php echo esc_url($existing_picture['sizes']['cardImage'] ?? $existing_picture['url']); ?>" alt="<?php echo esc_attr($existing_picture['alt'] ?? ''); ?>">
          <?php endif; ?>
          <input type="file" id="picture" name="picture" accept="image/*">
        </div>

        <div class="recipe-field">
          <label for="picture_alt">Image alt text</label>
          <input
            type="text"
            id="picture_alt"
            name="picture_alt"
            value="<?php echo esc_attr($existing_picture['alt'] ?? ''); ?>"
            placeholder="Describe the picture, e.g. &quot;A bowl of tomato soup topped with basil&quot;"
          >
        </div>

        <div class="recipe-field-row">
          <div class="recipe-field">
            <label for="total_time">Total time (minutes)</label>
            <input type="number" id="total_time" name="total_time" min="0" value="<?php echo esc_attr($existing_total_time); ?>">
          </div>

          <div class="recipe-field">
            <label for="servings">Servings</label>
            <input type="number" id="servings" name="servings" min="0" value="<?php echo esc_attr($existing_servings); ?>">
          </div>
        </div>

        <div class="recipe-field">
          <label>Ingredients</label>
          <div id="ingredients-list" class="dynamic-list">
            <?php foreach ($existing_ingredients as $ingredient) : ?>
              <div class="dynamic-list__row">
                <input type="text" name="ingredient[]" value="<?php echo esc_attr($ingredient); ?>" placeholder="e.g. 200g flour">
                <button type="button" class="dynamic-list__remove">&times;</button>
              </div>
            <?php endforeach; ?>
          </div>
          <button type="button" class="btn btn--small" id="add-ingredient">+ Add ingredient</button>
        </div>

        <div class="recipe-field">
          <label>Method</label>
          <div id="steps-list" class="dynamic-list">
            <?php foreach ($existing_steps as $step) : ?>
              <div class="dynamic-list__row">
                <textarea name="step[]" rows="2" placeholder="Describe this step"><?php echo esc_textarea($step); ?></textarea>
                <button type="button" class="dynamic-list__remove">&times;</button>
              </div>
            <?php endforeach; ?>
          </div>
          <button type="button" class="btn btn--small" id="add-step">+ Add step</button>
        </div>

        <input type="submit" name="cooking_recipe_submit" class="btn" value="<?php echo $editing_recipe_id ? 'Save changes' : 'Publish recipe'; ?>">
      </form>

      <?php
        if (!$editing_recipe_id) :
          $your_recipes = new WP_Query(array(
            'post_type' => 'recipe',
            'author' => $current_user_id,
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC'
          ));

          if ($your_recipes->have_posts()) :
      ?>
        <div class="your-recipes">
          <h2 class="your-recipes__title">Your recipes</h2>
          <ul class="your-recipes__list">
            <?php while ($your_recipes->have_posts()) : $your_recipes->the_post(); ?>
              <li class="your-recipes__item">
                <span class="your-recipes__name"><?php the_title(); ?></span>
                <a class="your-recipes__edit" href="<?php echo esc_url(add_query_arg('edit_recipe', get_the_ID(), home_url('/create-recipe/'))); ?>">Edit</a>
              </li>
            <?php endwhile; ?>
          </ul>
        </div>
      <?php
          endif;
          wp_reset_postdata();
        endif;
      ?>

    </div>
  </div>
</main>

<?php get_footer(); ?>