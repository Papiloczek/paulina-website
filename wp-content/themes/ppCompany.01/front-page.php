<?php get_header(); ?>

<div class="custom-cursor"></div>
<section id="firtsPage" class="first-page">
  <div class="page-description">
    <h2 class="main_page_description_w">
      <span class="word">Creativity</span>
      <span class="word1"> Profession</span>
      <span class="word2"> Support</span>
    </h2>
  </div>

  <div class="processor-wrapper">
    <div class="processor-animation">
      <div class="center-light"></div>
    </div>
  </div>
</section>

<section id="about-me" class="hero-main">
  <div class="container">

    <div class="hero-content">
      <div class="hero-intro">
        <h1 class="hero-title">Cześć, jestem<span class="highlight">Paulina Ptok</span> </h1>
        <h2 class="hero-subtitle">Web Developer & Digital marketing</h2>
        <p class="hero-description">Tworzę nowoczesne strony internetowe. Łączę technologię z designem, aby pomóc firmą
          zaistnieć w sieci i rozwijać się cyfrowo</p>
      </div>
      <div class="hero-actions">
        <a href="https://ppindustry.pl/paulina-ptok" class="btn-primary">Poznaj mnie bliżej</a>
        <a href="<?php echo home_url('/moje-projekty'); ?>" class="btn-secondary"><i class="fas fa-briefcase"></i>Zobacz
          moje projekty</a>
      </div>
    </div>

    <div class="hero-visual">
      <div class="hero-avatar">
        <div class="avatar-placeholder">
          <i class="fas fa-code"></i>
        </div>
        <div class="avatar-glow"></div>
      </div>

      <!-- Floating elements -->
      <div class="floating-tech">
        <span class="tech-item" style="--delay: 0s">React</span>
        <span class="tech-item" style="--delay: 1s">WordPress</span>
        <span class="tech-item" style="--delay: 2s">JavaScript</span>
        <span class="tech-item" style="--delay: 3s">PHP</span>
        <span class="tech-item" style="--delay: 4s">CSS</span>
      </div>
    </div>

  </div>
</section>

<section id="blog" class="blog-section">
  <div class="container">
    <h3 class="article">Artykuły</h3>
    <?php get_template_part('template-parts/last_posts'); ?>
  </div>
</section>

<section id="form" class="form-section"></section>

<button id="scroll-to-top" aria-label="Przewiń na górę">
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <polyline points="18 15 12 9 6 15"></polyline>
  </svg>
</button>

<?php get_footer();