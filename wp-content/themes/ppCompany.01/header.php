<!doctype html>
<html>
 <head>
    <meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-24X7ZDK0FR"></script>
    <meta name="description" content="CV Pauliny Ptok - Web Developer z doświadczeniem w WordPress, JavaScript, PHP i SEO. Zabrze, Polska.">
    <meta name="keywords" content="Paulina Ptok, Web Developer, WordPress, JavaScript, PHP, SEO, CV, Zabrze">
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-24X7ZDK0FR');
</script>
</head>
<body <?php body_class(); ?>> 


<div class="header-wrapper">

  <div class="logo-container">
    <?php if ( function_exists( 'the_custom_logo' ) ) {
      the_custom_logo();
    } ?>
  </div>

  <nav class="desktop-menu">
        <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class'     => 'menu',
                'container'      => false,
            ));
        ?>
    </nav>

    <?php wp_body_open(); ?>

  <button class="hamburger" onclick="toggleFullScreenMenu()">☰</button>

  <div class="fullscreen-menu">
    <?php
      wp_nav_menu(array(
        'theme_location' => 'primary',
        'menu_class'     => 'menu',
        'container'      => false,
      ));
    ?>
  </div>
</div>



