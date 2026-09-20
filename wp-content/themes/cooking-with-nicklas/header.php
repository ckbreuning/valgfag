<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
  <div class="container site-header__inner">
    <a class="site-logo" href="<?php echo site_url('/'); ?>"><?php bloginfo('name'); ?></a>

    <nav class="main-nav">
      <?php
        wp_nav_menu(array(
          'theme_location' => 'headerMenuLocation'
        ));
      ?>
    </nav>

    <div class="auth-nav">
      <div class="site-search">
        <i class="fa-solid fa-magnifying-glass site-search__icon"></i>
        <input
          type="text"
          id="recipe-search-input"
          class="site-search__input"
          placeholder="Search recipes&hellip;"
          autocomplete="off"
          aria-label="Search recipes"
        >
        <ul id="recipe-search-results" class="site-search__results"></ul>
      </div>

      <?php if (is_user_logged_in()) { ?>
        <a class="auth-link" href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>">Log out</a>
      <?php } else { ?>
        <a class="auth-link" href="<?php echo esc_url(wp_login_url(home_url('/'))); ?>">Log in</a>
        <a class="btn btn--small" href="<?php echo esc_url(wp_registration_url()); ?>">Sign up</a>
      <?php } ?>
    </div>
  </div>
</header>
