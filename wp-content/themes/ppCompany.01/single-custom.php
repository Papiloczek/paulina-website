<?php
/**
 * Template Name: Custom Article Layout for blog
 * Template Post Type: post
 */

get_header();
?>
<div class="container_singular">
    <article class="article-singular">
        <header class="article-header">
            <h1 class="article-title"><?php the_title(); ?></h1>
            <div class="article-meta">
                <div class="article-meta-item">
                    <span class="date"><?php the_date(); ?></span>
                </div>
                <div class="article-meta-item">
                    <?php
                    $categories = get_the_category();
                    if (!empty($categories)) {
                        echo '<span>Kategoria: ';
                        $category_links = array();
                        foreach ($categories as $category) {
                            $category_links[] = '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>';
                        }
                        echo implode(', ', $category_links);
                        echo '</span>';
                    }
                    ?>
                </div>
            </div>
        </header>
    </article>
    <div class="article-body">
        <?php the_content(); ?>
    </div>

    <footer class="article-footer">
        <div class="article-tags">
            <?php
            $tags = get_the_tags();
            if ($tags) {
                foreach ($tags as $tag) {
                    echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="article-tag">' . esc_html($tag->name) . '</a>';
                }
            } else {
                // Fallback tags jeśli post nie ma przypisanych tagów
                echo '<a href="#" class="article-tag">web design</a>';
                echo '<a href="#" class="article-tag">strony internetowe</a>';
                echo '<a href="#" class="article-tag">porady</a>';
            }

            // Dodaj linki do kategorii jako "tagi"
            $categories = get_the_category();
            if (!empty($categories)) {
                foreach ($categories as $category) {
                    echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="article-tag">' . esc_html($category->name) . '</a>';
                }
            }
            ?>
        </div>

        <div class="article-share">
            <span>Udostępnij:</span>
            <button class="share-button">Facebook</button>
            <button class="share-button">LinkedIn</button>
        </div>

        <div class="author-box">
            <img src="/api/placeholder/160/160" alt="PaulinaPP" class="author-image">
            <div class="author-info">
                <h4>Paulina</h4>
                <p>Web developer z 3-letnim doświadczeniem w nauce i rozwoju umiejętności, w tym 2 lata aktywnej pracy
                    zawodowej. Specjalizuję się w tworzeniu nowoczesnych i funkcjonalnych stron internetowych, które nie
                    tylko dobrze wyglądają, ale przede wszystkim realizują cele biznesowe klientów.</p>
            </div>
        </div>
    </footer>
    </article>

    <section class="related-posts">
        <h3>Powiązane artykuły</h3>
        <div class="related-posts-grid">
            <div class="related-post">
                <img src="/api/placeholder/400/200" alt="Powiązany artykuł" class="related-post-image">
                <div class="related-post-content">
                    <h4 class="related-post-title"><a href="#">Jak wybrać dobrego wykonawcę strony internetowej?</a>
                    </h4>
                    <div class="related-post-meta">22 kwietnia 2025</div>
                </div>
            </div>
            <div class="related-post">
                <img src="/api/placeholder/400/200" alt="Powiązany artykuł" class="related-post-image">
                <div class="related-post-content">
                    <h4 class="related-post-title"><a href="#">7 trendów w projektowaniu stron w 2025 roku</a></h4>
                    <div class="related-post-meta">15 kwietnia 2025</div>
                </div>
            </div>
            <div class="related-post">
                <img src="/api/placeholder/400/200" alt="Powiązany artykuł" class="related-post-image">
                <div class="related-post-content">
                    <h4 class="related-post-title"><a href="#">Jak zwiększyć konwersję na stronie internetowej?</a></h4>
                    <div class="related-post-meta">10 kwietnia 2025</div>
                </div>
            </div>
        </div>
    </section>

  <!-- komentarze -->
 <?php
    $comments = get_comments(array(
        'post_id' => get_the_ID(),
        'status' => 'approve',
        'order' => 'ASC'
    ));
    
    $comments_count = get_comments_number();
    ?>
    
    <?php if ($comments_count > 0 || comments_open()) : ?>
    <section class="comments-section">
        <h3>Komentarze (<?php echo $comments_count; ?>)</h3>
        
        <?php if ($comments) : ?>
            <?php foreach ($comments as $comment) : ?>
            <div class="comment">
                <div class="comment-header">
                    <div class="comment-author"><?php echo esc_html($comment->comment_author); ?></div>
                    <div class="comment-date"><?php echo get_comment_date('j F Y, H:i', $comment->comment_ID); ?></div>
                </div>
                <div class="comment-content">
                    <p><?php echo wpautop(esc_html($comment->comment_content)); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
    <?php endif; ?>

    <?php if (comments_open()) : ?>
    <div class="comment-form">
        <h4>Dodaj komentarz</h4>
        
        <?php
        // Sprawdź czy formularz został wysłany
        if (isset($_GET['comment_submitted'])) {
            echo '<div class="comment-success" style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 4px;">✅ Komentarz został dodany pomyślnie!</div>';
        }
        ?>
        
        <form id="commentform" action="<?php echo esc_url(site_url('/wp-comments-post.php')); ?>" method="post">
            <div class="form-group">
                <label for="author">Imię *</label>
                <input type="text" id="author" name="author" class="form-control" value="<?php echo esc_attr(wp_get_current_commenter()['comment_author']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo esc_attr(wp_get_current_commenter()['comment_author_email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="comment">Komentarz *</label>
                <textarea id="comment" name="comment" class="form-control" rows="5" required></textarea>
            </div>
            
            <!-- Ukryte pola wymagane przez WordPress -->
            <input type="hidden" name="comment_post_ID" value="<?php echo get_the_ID(); ?>">
            <input type="hidden" name="comment_parent" value="0">
            
            <!-- Dodaj przekierowanie po wysłaniu -->
            <input type="hidden" name="redirect_to" value="<?php echo esc_url(add_query_arg('comment_submitted', '1', get_permalink())); ?>">
            
            <?php 
            // Dodaj nonce field dla bezpieczeństwa
            wp_nonce_field('comment_form_' . get_the_ID(), 'comment_form_nonce'); 
            ?>
            
            <button type="submit" class="btn">Dodaj komentarz</button>
        </form>
    </div>
    <?php endif; ?>
</div>

<button id="scroll-to-top" aria-label="Przewiń na górę">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="18 15 12 9 6 15"></polyline>
    </svg>
</button>

<?php get_footer(); ?>