<?php
/*
Template Name: Blog Technologiczny
*/

get_header(); ?>


<!-- Hero sekcja bloga -->
<section class="blog-hero">
    <div class="container">
        <div class="blog-hero-content">
            <h1 class="blog-hero-title">Blog Technologiczny</h1>
            <p class="blog-hero-description">
                Dzielę się praktyczną wiedzą z zakresu tworzenia stron internetowych, optymalizacji SEO i nowych
                technologii.
                To przestrzeń, w której technologia spotyka doświadczenie i pasję do rozwoju cyfrowego.
            </p>
            <div class="blog-stats">
                <div class="blog-stat-item">
                    <span class="stat-number"><?php echo wp_count_posts()->publish; ?></span>
                    <span class="stat-label">Artykuły</span>
                </div>
                <div class="blog-stat-item">
                    <span
                        class="stat-number"><?php echo wp_count_terms('category', array('hide_empty' => true)); ?></span>
                    <span class="stat-label">Kategorie</span>
                </div>
                <div class="blog-stat-item">
                    <span class="stat-number">2+</span>
                    <span class="stat-label">Lat doświadczenia</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filtry i wyszukiwarka -->
<section class="blog-filters">
    <div class="container">
        <div class="filters-wrapper">

            <!-- Wyszukiwarka -->
            <div class="blog-search">
                <form class="search-form" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="search" class="search-field" placeholder="Szukaj artykułów..." name="s"
                        value="<?php echo get_search_query(); ?>">
                    <button type="submit" class="search-submit">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <polyline points="21 21 16.65 16.65"></polyline>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Filtry kategorii -->
            <div class="blog-categories-filter">
                <div class="category-filters">
                    <button class="category-filter active" data-category="all">Wszystkie</button>
                    <?php
                    $categories = get_categories(array(
                        'orderby' => 'name',
                        'order' => 'ASC',
                        'hide_empty' => true
                    ));
                    foreach ($categories as $category) {
                        echo '<button class="category-filter" data-category="' . $category->slug . '">' .
                            $category->name . ' <span style="opacity: 0.7; font-size: 0.8rem;">(' . $category->count . ')</span></button>';
                    }
                    ?>
                </div>
            </div>

            <!-- Sortowanie -->
            <div class="blog-sort">
                <select class="sort-select" id="blog-sort">
                    <option value="date-desc">Najnowsze</option>
                    <option value="date-asc">Najstarsze</option>
                    <option value="title-asc">A-Z</option>
                </select>
            </div>
        </div>
    </div>
</section>

<!-- Główna sekcja z artykułami -->
<section class="blog-content">
    <div class="container">

        <?php
        // Pobranie wyróżnionego artykułu (najnowszy z kategorii 'featured' lub sticky post)
        $featured_query = new WP_Query(array(
            'posts_per_page' => 1,
            'meta_key' => 'featured_post',
            'meta_value' => '1',
            'post_status' => 'publish'
        ));

        if (!$featured_query->have_posts()) {
            // Jeśli nie ma wyróżnionego, weź najnowszy post
            $featured_query = new WP_Query(array(
                'posts_per_page' => 1,
                'post_status' => 'publish'
            ));
        }

        if ($featured_query->have_posts()): ?>
            <!-- Wyróżniony artykuł -->
            <div class="featured-post-section">
                <h2 class="section-title">Wyróżniony artykuł</h2>
                <?php while ($featured_query->have_posts()):
                    $featured_query->the_post(); ?>
                    <article class="featured-post" onclick="window.location.href='<?php the_permalink(); ?>'">
                        <div class="featured-post-image">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('large'); ?>
                            <?php else: ?>
                                🤖
                            <?php endif; ?>
                            <div class="featured-post-category">
                                <?php
                                $categories = get_the_category();
                                if (!empty($categories)) {
                                    echo esc_html($categories[0]->name);
                                }
                                ?>
                            </div>
                        </div>

                        <div class="featured-post-content">
                            <div class="featured-post-meta">
                                <time><?php echo get_the_date('j F Y'); ?></time>
                                <span><?php echo ceil(str_word_count(get_the_content()) / 200); ?> min czytania</span>
                            </div>

                            <h3 class="featured-post-title"><?php the_title(); ?></h3>

                            <div class="featured-post-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 30); ?>
                            </div>

                            <div class="featured-post-cta">
                                Czytaj całość →
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
        <?php endif;
        wp_reset_postdata(); ?>

        <!-- Siatka wszystkich artykułów -->
        <div class="all-posts-section">
            <div class="section-header">
                <h2 class="section-title">Wszystkie artykuły</h2>
                <div class="posts-count">
                    <span id="posts-count-number"><?php echo wp_count_posts()->publish; ?></span> artykułów
                </div>
            </div>

            <div class="blog-posts-grid" id="blog-posts-container">
                <?php
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $blog_query = new WP_Query(array(
                    'posts_per_page' => 9,
                    'paged' => $paged,
                    'post_status' => 'publish'
                ));

                if ($blog_query->have_posts()):
                    while ($blog_query->have_posts()):
                        $blog_query->the_post();
                        // Użycie template part dla karty bloga
                        get_template_part('template-parts/content-blog');
                    endwhile;
                    ?>
                </div>

                <!-- Paginacja -->
                <div class="blog-pagination">
                    <?php
                    echo paginate_links(array(
                        'total' => $blog_query->max_num_pages,
                        'current' => $paged,
                        'format' => '?paged=%#%',
                        'prev_text' => '← Poprzednia',
                        'next_text' => 'Następna →'
                    ));
                    ?>
                </div>

            <?php else: ?>
                <p>Nie znaleziono artykułów.</p>
            <?php endif;
                wp_reset_postdata(); ?>
        </div>
    </div>
</section>

<!-- Newsletter -->
<section class="blog-newsletter">
    <div class="container">
        <div class="newsletter-content">
            <h2 class="newsletter-title">Zapisz się do newslettera</h2>
            <p class="newsletter-description">
                Otrzymuj praktyczne porady i artykuły o nowoczesnych rozwiązaniach w web developmencie i cyfrowym
                marketingu
                prosto na swoją skrzynkę.
            </p>
            <form class="newsletter-form" method="post" action="<?php echo admin_url('admin-post.php'); ?>">
                <input type="hidden" name="action" value="newsletter_signup">
                <?php wp_nonce_field('newsletter_signup', 'newsletter_nonce'); ?>
                <input type="email" class="newsletter-email" placeholder="Twój adres email" name="newsletter_email"
                    required>
                <button type="submit" class="newsletter-submit">Zapisz się</button>
            </form>
            <p style="font-size: 0.9rem; color: var(--text-color-dim); margin-top: 1rem;">
                Nie wysyłamy spamu. Możesz zrezygnować w każdej chwili.
            </p>
        </div>
    </div>
</section>

<button id="scroll-to-top" aria-label="Przewiń na górę">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="18 15 12 9 6 15"></polyline>
    </svg>
</button>

<?php get_footer(); ?>