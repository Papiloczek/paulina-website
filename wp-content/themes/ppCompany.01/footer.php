<?php
echo '</div>'; // end container
?>

<footer class="site-footer">
  <div class="footer-content">

    <!-- Kolumna z logo i opisem -->
    <div class="footer-logo">
      <?php if (has_custom_logo()): ?>
        <div class="custom-logo">
          <?php the_custom_logo(); ?>
        </div>
      <?php else: ?>
        <h3 class="site-title">
          <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
            <?php bloginfo('name'); ?>
          </a>
        </h3>
      <?php endif; ?>

      <?php if (get_theme_mod('footer_description')): ?>
        <p class="footer-description">
          <?php echo esc_html(get_theme_mod('footer_description')); ?>
        </p>
      <?php endif; ?>

      <!-- Social Media Links -->
      <?php $social_platforms = array(
        'facebook' => 'Facebook',
        'twitter' => 'Twitter',
        'linkedin' => 'LinkedIn',
        'instagram' => 'Instagram',
        'github' => 'GitHub'
      ); ?>

      <?php $has_social = false;
      foreach ($social_platforms as $platform => $name) {
        if (get_theme_mod("social_{$platform}")) {
          $has_social = true;
          break;
        }
      } ?>

      <?php if ($has_social): ?>
        <div class="social-links">
          <?php foreach ($social_platforms as $platform => $name): ?>
            <?php if ($link = get_theme_mod("social_{$platform}")): ?>
              <a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener noreferrer"
                aria-label="<?php echo esc_attr($name); ?>" class="social-link social-<?php echo esc_attr($platform); ?>">
                <span class="social-icon"><?php echo substr($name, 0, 1); ?></span>
              </a>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- Kolumna z menu -->
    <div class="footer-links">
      <?php if (has_nav_menu('footer')): ?>
        <?php paulina_theme_footer_menu(); ?>
      <?php else: ?>
        <?php paulina_theme_footer_menu(); ?>
      <?php endif; ?>
    </div>

    <!-- Kolumna z informacjami dodatkowymi -->
    <div class="footer-widgets">
      <?php if (is_active_sidebar('footer-info')): ?>
        <div class="footer-widget-area">
          <?php dynamic_sidebar('footer-info'); ?>
        </div>
      <?php endif; ?>

      <?php if (is_active_sidebar('footer-contact')): ?>
        <div class="footer-widget-area">
          <?php dynamic_sidebar('footer-contact'); ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Copyright -->
  <div class="copy-right">
    <div class="container">
      <p>
        <?php
        $copyright_text = get_theme_mod('footer_copyright_text', '© 2025 PPINDUSTRY. Wszystkie prawa zastrzeżone.');
        echo esc_html($copyright_text);
        ?>
      </p>
    </div>
  </div>
</footer>


<?php
wp_footer();  // wywołanie dodatkowe skryptu w stopce
?>
</body>

</html>