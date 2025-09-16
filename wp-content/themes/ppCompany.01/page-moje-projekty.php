<?php
/**
 * Template for Portfolio Page
 * Filename: page-moje-projekty.php
 */

get_header(); ?>

<div class="custom-cursor"></div>

<!-- Portfolio Hero Section -->
<?php get_template_part('template-parts/portfolio-hero'); ?>

<!-- Portfolio Content Section -->
<?php get_template_part('template-parts/portfolio-content'); ?>

<!-- Portfolio CTA Section -->
<?php get_template_part('template-parts/portfolio-cta'); ?>

<!-- Scroll to top button -->
<button id="scroll-to-top" aria-label="Przewiń na górę">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="18 15 12 9 6 15"></polyline>
    </svg>
</button>

<!-- Portfolio JavaScript -->
<?php get_template_part('template-parts/portfolio-scripts'); ?>

<?php get_footer(); ?>