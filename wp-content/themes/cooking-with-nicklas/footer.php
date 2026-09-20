<footer class="site-footer">
  <div class="container">
    <div class="site-footer__inner">
      <a class="site-logo" href="<?php echo site_url('/'); ?>"><?php bloginfo('name'); ?></a>

      <nav class="footer-nav">
        <?php
          wp_nav_menu(array(
            'theme_location' => 'footerMenuLocation'
          ));
        ?>
      </nav>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
