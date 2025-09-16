<?php
/**
 * Plugin Name: VIEDO PAGE 404
 * Description: WOLF WALKING
 * Version: 1.1
 * Author: Paulina
 */

if (!defined('ABSPATH')) {
    exit;
}

class Clean404VideoOnly {
    
    private $options;
    
    public function __construct() {
        $this->options = get_option('clean_404_video_options', $this->get_defaults());
        $this->init();
    }
    
    private function init() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_post_save_clean_404_video', array($this, 'save_settings'));
        
        if ($this->options['enabled']) {
            // Przejmij kontrolę nad 404
            add_action('template_redirect', array($this, 'handle_404_page'), 1);
        }
    }
    
    /*Obsługa strony 404 - czysta strona bez header/footer*/
    public function handle_404_page() {
        if (!is_404()) return;
        
        // Ustaw poprawny status
        status_header(404);
        nocache_headers();
        
        // Wyczyść output
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        // Wyświetl czystą stronę 404
        $this->render_clean_404();
        exit;
    }
    
    /*Renderuj czystą stronę 404*/
    private function render_clean_404() {
        ?>
        <!DOCTYPE html>
        <html <?php language_attributes(); ?>>
        <head>
            <meta charset="<?php bloginfo('charset'); ?>">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="robots" content="noindex, nofollow">
            <title>404 - Strona nie została znaleziona | <?php bloginfo('name'); ?></title>
            
            <style>

                * {
                    box-sizing: border-box;
                    margin: 0;
                    padding: 0;
                }
                
                :root {
                    --primary-color: #1a1a1a;
                    --secondary-color: #0f0f0f;
                    --accent-color: #00ff9d;
                    --accent-color-dim: rgba(0, 255, 157, 0.5);
                    --text-color: #ffffff;
                    --text-color-dim: rgba(255, 255, 255, 0.7);
                    --text-muted: rgba(166, 194, 198, 1);
                    --background-card: #03181d;
                    --background-highlight: rgba(27, 118, 100, 0.1);
                    --border-highlight: rgba(27, 118, 100, 0.3);
                    --font-primary: "Montserrat", sans-serif;
                    --font-secondary: "Space Grotesk", sans-serif;
                    --font-georgia: Georgia, "Times New Roman", Times, serif;
                    --border-radius: 10px;
                    --transition-standard: all 0.3s ease;
                    --box-shadow-glow: 0 5px 15px rgba(0, 255, 157, 0.3);
                }
                
                body {
                    font-family: var(--font-primary), -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
                    background-color: var(--primary-color);
                    color: var(--text-color);
                    min-height: 100vh;
                    overflow-x: hidden;
                    position: relative;
                    line-height: 1.6;
                }
                
                /* INTRO ANIMATION SECTION */
                .intro-section {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    z-index: 9999;
                    background: var(--primary-color);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    opacity: 1;
                    transition: opacity 1s ease-out;
                }
                
                .intro-section.hidden {
                    opacity: 0;
                    pointer-events: none;
                }
                
                .intro-video {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }
                
                .intro-overlay {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.2);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex-direction: column;
                }
                
                .intro-title {
                    font-family: var(--font-secondary);
                    font-size: clamp(2rem, 8vw, 4rem);
                    font-weight: 700;
                    color: var(--accent-color);
                    text-shadow: 0 0 30px rgba(0, 255, 157, 0.8);
                    margin-bottom: 1rem;
                    opacity: 0;
                    transform: translateY(30px);
                    animation: fadeInUp 1s ease-out 1s forwards;
                }
                
                .intro-subtitle {
                    font-size: clamp(1rem, 3vw, 1.5rem);
                    color: var(--text-muted);
                    text-align: center;
                    opacity: 0;
                    transform: translateY(20px);
                    animation: fadeInUp 1s ease-out 1.5s forwards;
                }
                
                .skip-button {
                    position: absolute;
                    bottom: 2rem;
                    right: 2rem;
                    background: rgba(0, 0, 0, 0.7);
                    color: var(--text-color);
                    border: 1px solid var(--accent-color);
                    padding: 0.5rem 1rem;
                    border-radius: 5px;
                    cursor: pointer;
                    font-family: var(--font-primary);
                    font-size: 0.9rem;
                    opacity: 0;
                    animation: fadeIn 0.5s ease-out 2s forwards;
                    transition: all 0.3s ease;
                }
                
                .skip-button:hover {
                    background: rgba(0, 255, 157, 0.1);
                    transform: translateY(-2px);
                }
                
                @keyframes fadeInUp {
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
                
                @keyframes fadeIn {
                    to {
                        opacity: 1;
                    }
                }
                
                /* MAIN 404 CONTENT - ukryte początkowo */
                .main-404-content {
                    opacity: 0;
                    transform: translateY(50px);
                    transition: all 1.5s ease-out;
                }
                
                .main-404-content.visible {
                    opacity: 1;
                    transform: translateY(0);
                }
                
                /* Video Background dla głównej zawartości */
                .clean-404-video-bg {
                    position: fixed !important;
                    top: 0 !important;
                    left: 0 !important;
                    width: 100% !important;
                    height: 100% !important;
                    z-index: -999 !important;
                    overflow: hidden !important;
                    pointer-events: none !important;
                }
                
                .clean-404-video-bg video {
                    width: 100% !important;
                    height: 100% !important;
                    object-fit: cover !important;
                    opacity: <?php echo floatval($this->options['video_opacity']) / 100; ?> !important;
                    filter: blur(<?php echo intval($this->options['video_blur']); ?>px) !important;
                }
                
                .clean-404-video-overlay {
                    position: fixed !important;
                    top: 0 !important;
                    left: 0 !important;
                    width: 100% !important;
                    height: 100% !important;
                    z-index: -998 !important;
                    background: rgba(0, 0, 0, <?php echo floatval($this->options['overlay_opacity']); ?>) !important;
                    pointer-events: none !important;
                }
                
                /* Główny kontener */
                .clean-404-container {
                    position: relative;
                    z-index: 10;
                    min-height: 100vh;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    text-align: center;
                    padding: 2rem;
                }
                
                .clean-404-content {
                    max-width: 800px;
                    width: 100%;
                    background: rgba(0, 0, 0, 0.7);
                    padding: 3rem;
                    border-radius: 20px;
                    backdrop-filter: blur(10px);
                    border: 1px solid rgba(0, 255, 157, 0.3);
                }
                
                .clean-404-title {
                    font-family: var(--font-secondary);
                    font-size: clamp(4rem, 15vw, 8rem);
                    font-weight: 700;
                    color: var(--accent-color);
                    text-shadow: 0 0 30px rgba(0, 255, 157, 0.6);
                    margin-bottom: 2rem;
                    animation: pulse 2s ease-in-out infinite;
                    line-height: 1;
                }
                
                @keyframes pulse {
                    0%, 100% {
                        transform: scale(1);
                        opacity: 1;
                    }
                    50% {
                        transform: scale(1.05);
                        opacity: 0.8;
                    }
                }
                
                /* Tytuł */
                .clean-404-heading {
                    font-family: var(--font-secondary);
                    font-size: clamp(1.5rem, 5vw, 2.5rem);
                    font-weight: 600;
                    margin-bottom: 1.5rem;
                    color: var(--text-color);
                    text-transform: uppercase;
                }
                
                /* Podtytuł */
                .clean-404-subtitle {
                    font-size: clamp(1rem, 3vw, 1.25rem);
                    color: var(--text-muted);
                    margin-bottom: 2rem;
                    line-height: 1.6;
                }
                
                /* Cytat */
                .clean-404-quote {
                    font-size: 1.1rem;
                    font-style: italic;
                    color: var(--accent-color);
                    margin-bottom: 3rem;
                    padding: 1.5rem;
                    background: var(--background-card);
                    border-radius: var(--border-radius);
                    border: 1px solid var(--border-highlight);
                    position: relative;
                    overflow: hidden;
                    font-family: var(--font-georgia);
                }
                
                .clean-404-quote::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: linear-gradient(45deg, transparent, rgba(0, 255, 157, 0.05), transparent);
                    animation: shimmer 3s ease-in-out infinite;
                }
                
                @keyframes shimmer {
                    0%, 100% {
                        transform: translateX(-100%);
                    }
                    50% {
                        transform: translateX(100%);
                    }
                }
                
                /* Przyciski */
                .clean-404-buttons {
                    display: flex;
                    gap: 1rem;
                    justify-content: center;
                    flex-wrap: wrap;
                }
                
                .clean-404-btn {
                    padding: 0.75rem 1.5rem;
                    border-radius: 6px;
                    font-weight: 600;
                    text-decoration: none;
                    transition: var(--transition-standard);
                    display: inline-block;
                    text-align: center;
                    border: none;
                    cursor: pointer;
                    font-size: 1rem;
                    font-family: var(--font-primary);
                }
                
                .clean-404-btn-primary {
                    background-color: var(--accent-color);
                    color: var(--primary-color);
                }
                
                .clean-404-btn-primary:hover {
                    background-color: var(--text-color);
                    transform: translateY(-3px);
                    box-shadow: 0 10px 20px rgba(0, 255, 157, 0.2);
                }
                
                .clean-404-btn-secondary {
                    background-color: transparent;
                    color: var(--text-color);
                    border: 2px solid var(--accent-color);
                }
                
                .clean-404-btn-secondary:hover {
                    background-color: rgba(0, 255, 157, 0.1);
                    transform: translateY(-3px);
                }
                
                /* Responsywność */
                @media (max-width: 768px) {
                    .clean-404-container {
                        padding: 1rem;
                    }
                    
                    .clean-404-content {
                        padding: 2rem;
                    }
                    
                    .clean-404-buttons {
                        flex-direction: column;
                        align-items: center;
                    }
                    
                    .clean-404-btn {
                        width: 100%;
                        max-width: 250px;
                    }
                    
                    .clean-404-video-bg,
                    .intro-section {
                        display: <?php echo $this->options['mobile_video'] ? 'block' : 'none'; ?> !important;
                    }
                    
                    .skip-button {
                        bottom: 1rem;
                        right: 1rem;
                        font-size: 0.8rem;
                        padding: 0.4rem 0.8rem;
                    }
                }
                
                @media (max-width: 480px) {
                    .clean-404-content {
                        padding: 1.5rem;
                    }
                }
                
                /* Prefers reduced motion */
                @media (prefers-reduced-motion: reduce) {
                    .clean-404-title,
                    .intro-title,
                    .intro-subtitle,
                    .skip-button {
                        animation: none !important;
                    }
                    
                    .clean-404-quote::before {
                        animation: none !important;
                    }
                    
                    .main-404-content {
                        transition: none !important;
                    }
                }
                
                /* Ukryj video jeśli nie ustawione */
                <?php if (empty($this->options['video_url'])): ?>
                .clean-404-video-bg, .clean-404-video-overlay, .intro-section {
                    display: none !important;
                }
                <?php endif; ?>
            </style>
        </head>
        
        <body>
            <!-- INTRO ANIMATION -->
            <?php if (!empty($this->options['video_url'])): ?>
            <div class="intro-section" id="introSection">
                <video class="intro-video" id="introVideo" muted <?php echo $this->options['preload'] ? 'preload="auto"' : 'preload="metadata"'; ?>>
                    <source src="<?php echo esc_url($this->options['video_url']); ?>" type="video/mp4">
                </video>
                
                <div class="intro-overlay">
                    <h1 class="intro-title"><?php echo esc_html($this->options['intro_title'] ?? 'Błąd 404'); ?></h1>
                    <p class="intro-subtitle"><?php echo esc_html($this->options['intro_subtitle'] ?? 'Przygotowujemy coś specjalnego...'); ?></p>
                </div>
                
                <button class="skip-button" onclick="skipIntro()">Pomiń intro →</button>
            </div>
            <?php endif; ?>
            
            <!-- MAIN 404 CONTENT -->
            <div class="main-404-content" id="main404Content">
                <!-- Video Background dla głównej zawartości -->
                <?php if (!empty($this->options['video_url'])): ?>
                <div class="clean-404-video-bg">
                    <video autoplay muted loop playsinline <?php echo $this->options['preload'] ? 'preload="auto"' : 'preload="metadata"'; ?>>
                        <source src="<?php echo esc_url($this->options['video_url']); ?>" type="video/mp4">
                    </video>
                </div>
                
                <?php if ($this->options['overlay_opacity'] > 0): ?>
                <div class="clean-404-video-overlay"></div>
                <?php endif; ?>
                <?php endif; ?>
                
                <!-- Content -->
                <div class="clean-404-container">
                    <div class="clean-404-content">
                        <div class="clean-404-title">404</div>
                        
                        <h1 class="clean-404-heading"><?php echo esc_html($this->options['page_title']); ?></h1>
                        
                        <p class="clean-404-subtitle"><?php echo esc_html($this->options['page_subtitle']); ?></p>
                        
                        <div class="clean-404-quote">
                            "<?php echo esc_html($this->options['quote_text']); ?>"
                        </div>
                        
                        <div class="clean-404-buttons">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="clean-404-btn clean-404-btn-primary">
                                <?php echo esc_html($this->options['button_home']); ?>
                            </a>
                            <a href="<?php echo esc_url(home_url('/kontakt')); ?>" class="clean-404-btn clean-404-btn-secondary">
                                <?php echo esc_html($this->options['button_contact']); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <script>
            // Animacja intro i przejście do głównej zawartości
            (function() {
                const introSection = document.getElementById('introSection');
                const introVideo = document.getElementById('introVideo');
                const main404Content = document.getElementById('main404Content');
                const introDuration = <?php echo intval($this->options['intro_duration'] ?? 5); ?> * 1000; // w milisekundach
                
                if (introVideo && introSection) {
                    // Start intro video
                    introVideo.muted = true;
                    introVideo.play().catch(() => console.log('Intro video autoplay blocked'));
                    
                    // Automatyczne przejście po określonym czasie
                    setTimeout(showMain404, introDuration);
                    
                    // Obsługa końca video (jeśli krótsze niż ustawiony czas)
                    introVideo.addEventListener('ended', showMain404);
                } else {
                    // Jeśli brak intro video, od razu pokaż główną zawartość
                    showMain404();
                }
                
                function showMain404() {
                    if (introSection) {
                        introSection.classList.add('hidden');
                    }
                    
                    // Pokaż główną zawartość po krótkiej przerwie
                    setTimeout(() => {
                        main404Content.classList.add('visible');
                        
                        // Start background video
                        const backgroundVideo = document.querySelector('.clean-404-video-bg video');
                        if (backgroundVideo) {
                            backgroundVideo.muted = true;
                            backgroundVideo.loop = true;
                            backgroundVideo.play().catch(() => console.log('Background video autoplay blocked'));
                        }
                    }, 500);
                    
                    // Ukryj intro sekcję całkowicie po animacji
                    setTimeout(() => {
                        if (introSection) {
                            introSection.style.display = 'none';
                        }
                    }, 1500);
                }
                
                // Funkcja skip intro (globalna)
                window.skipIntro = showMain404;
                
                // Pause/resume video on visibility change
                document.addEventListener('visibilitychange', function() {
                    const activeVideo = introSection && !introSection.classList.contains('hidden') 
                        ? introVideo 
                        : document.querySelector('.clean-404-video-bg video');
                        
                    if (activeVideo) {
                        if (document.hidden) {
                            activeVideo.pause();
                        } else if (activeVideo.paused) {
                            activeVideo.play();
                        }
                    }
                });
            })();
            </script>
        </body>
        </html>
        <?php
    }
    
    /*Panel administracyjny*/
    public function add_admin_menu() {
        add_options_page(
            'Page 404',
            '404',
            'manage_options',
            'page 404',
            array($this, 'admin_page')
        );
    }
    
    /*Strona administracyjna*/
    public function admin_page() {
        if (isset($_GET['saved'])) {
            echo '<div class="notice notice-success"><p>Ustawienia zapisane!</p></div>';
        }
        ?>
        <div class="wrap">
            <h1> 404 - Video Only</h1>
            <p><strong>Animacja, content</strong></p>
            
            <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" enctype="multipart/form-data">
                <input type="hidden" name="action" value="save_clean_404_video">
                <?php wp_nonce_field('save_clean_404_video', 'clean_nonce'); ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">Włącz animację strony 404</th>
                        <td>
                            <label>
                                <input type="checkbox" name="enabled" value="1" 
                                       <?php checked($this->options['enabled'], 1); ?> />
                                Aktywuj stronę 404
                            </label>
                            <p class="description">Wyświetla najpierw intro, potem główną zawartość 404</p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Video MP4</th>
                        <td>
                            <input type="url" name="video_url" value="<?php echo esc_attr($this->options['video_url']); ?>" 
                                   class="large-text" placeholder="https://example.com/video.mp4" />
                            <br><br>
                            
                            <button type="button" class="button" id="upload-video-btn">📁 Wybierz z Media Library</button>
                            <br><br>
                            
                            <input type="file" name="video_file" accept="video/mp4" />
                            <p class="description">Video używane zarówno w intro jak i jako tło głównej zawartości</p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Ustawienia Intro</th>
                        <td>
                            <p><strong>Tytuł intro:</strong><br>
                                <input type="text" name="intro_title" value="<?php echo esc_attr($this->options['intro_title'] ?? 'Błąd 404'); ?>" class="regular-text" />
                            </p>
                            
                            <p><strong>Podtytuł intro:</strong><br>
                                <input type="text" name="intro_subtitle" value="<?php echo esc_attr($this->options['intro_subtitle'] ?? 'Przygotowujemy coś specjalnego...'); ?>" class="large-text" />
                            </p>
                            
                            <p><strong>Czas trwania intro (sekundy):</strong><br>
                                <input type="number" name="intro_duration" value="<?php echo intval($this->options['intro_duration'] ?? 5); ?>" min="2" max="15" />
                                <span class="description">Po tym czasie automatycznie przejdzie do głównej zawartości</span>
                            </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Ustawienia video tła</th>
                        <td>
                            <p><strong>Przezroczystość video:</strong> 
                                <input type="range" name="video_opacity" min="10" max="60" value="<?php echo $this->options['video_opacity']; ?>" 
                                       oninput="this.nextElementSibling.textContent = this.value + '%'" />
                                <span><?php echo $this->options['video_opacity']; ?>%</span>
                            </p>
                            
                            <p><strong>Rozmycie video:</strong> 
                                <input type="range" name="video_blur" min="0" max="10" value="<?php echo $this->options['video_blur']; ?>" 
                                       oninput="this.nextElementSibling.textContent = this.value + 'px'" />
                                <span><?php echo $this->options['video_blur']; ?>px</span>
                            </p>
                            
                            <p><strong>Ciemna nakładka:</strong> 
                                <input type="range" name="overlay_opacity" min="0" max="0.7" step="0.1" value="<?php echo $this->options['overlay_opacity']; ?>" 
                                       oninput="this.nextElementSibling.textContent = Math.round(this.value * 100) + '%'" />
                                <span><?php echo round($this->options['overlay_opacity'] * 100); ?>%</span>
                            </p>
                            
                            <p>
                                <label>
                                    <input type="checkbox" name="mobile_video" value="1" 
                                           <?php checked($this->options['mobile_video'], 1); ?> />
                                    Pokaż video na urządzeniach mobilnych
                                </label>
                            </p>
                            
                            <p>
                                <label>
                                    <input type="checkbox" name="preload" value="1" 
                                           <?php checked($this->options['preload'], 1); ?> />
                                    Preload video
                                </label>
                            </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Treść głównej strony</th>
                        <td>
                            <p><strong>Tytuł główny:</strong><br>
                                <input type="text" name="page_title" value="<?php echo esc_attr($this->options['page_title']); ?>" class="regular-text" />
                            </p>
                            
                            <p><strong>Podtytuł:</strong><br>
                                <textarea name="page_subtitle" rows="2" class="large-text"><?php echo esc_textarea($this->options['page_subtitle']); ?></textarea>
                            </p>
                            
                            <p><strong>Cytat:</strong><br>
                                <textarea name="quote_text" rows="3" class="large-text"><?php echo esc_textarea($this->options['quote_text']); ?></textarea>
                            </p>
                            
                            <p><strong>Przycisk powrotu:</strong><br>
                                <input type="text" name="button_home" value="<?php echo esc_attr($this->options['button_home']); ?>" class="regular-text" />
                            </p>
                            
                            <p><strong>Przycisk kontakt:</strong><br>
                                <input type="text" name="button_contact" value="<?php echo esc_attr($this->options['button_contact']); ?>" class="regular-text" />
                            </p>
                        </td>
                    </tr>
                </table>
                
                <?php submit_button('Zapisz ustawienia'); ?>
            </form>
            
            <!-- Test -->
            <div class="card" style="background: white; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4;">
                <h2>🧪 Test</h2>
                <p><a href="<?php echo home_url('/test-clean-404'); ?>" target="_blank" class="button button-primary">Otwórz test strony 404</a></p>
                <p class="description">Powinieneś zobaczyć: <strong>1) Intro z filmem → 2) Główną zawartość 404</strong></p>
            </div>
            <!-- jeszcze sie zastanowie jakie moze miec to znaczenie -->
            <!-- Info --> 
            <!-- <div class="card" style="background: #f9f9f9; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4;">
                <h2>ℹ️ Sekwencja animacji 404</h2>
                <ul>
                    <li>✅ <strong>Krok 1:</strong> Intro - Pełnoekranowy film z tytułem i przyciskiem "Pomiń"</li>
                    <li>✅ <strong>Krok 2:</strong> Przejście - Płynne fade-out intro i fade-in głównej zawartości</li>
                    <li>✅ <strong>Krok 3:</strong> Główna strona - Film jako tło + zawartość 404</li>
                    <li>✅ <strong>Usuwa</strong> - Header, footer, menu, sidebar</li>
                    <li>✅ <strong>Zachowuje</strong> - Twoje zmienne CSS i style</li>
                    <li>✅ <strong>Responsywna</strong> - Działa na wszystkich urządzeniach</li>
                    <li>✅ <strong>SEO friendly</strong> - Poprawny status HTTP 404</li>
                    <li>✅ <strong>Accessible</strong> - Respektuje prefers-reduced-motion</li>
                </ul>
                
                <h3>🎮 Kontrola użytkownika:</h3>
                <ul>
                    <li>• Przycisk "Pomiń intro" - natychmiastowe przejście</li>
                    <li>• Automatyczne przejście po ustawionym czasie</li>
                    <li>• Przejście po zakończeniu filmu (jeśli krótszy)</li>
                    <li>• Pauza/wznowienie przy zmianie zakładki</li>
                </ul>
            </div>
        </div> -->
        
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof wp !== 'undefined' && wp.media) {
                document.getElementById('upload-video-btn').addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const mediaUploader = wp.media({
                        title: 'Wybierz Video MP4',
                        library: { type: 'video' },
                        button: { text: 'Użyj tego video' },
                        multiple: false
                    });
                    
                    mediaUploader.on('select', function() {
                        const attachment = mediaUploader.state().get('selection').first().toJSON();
                        document.querySelector('input[name="video_url"]').value = attachment.url;
                    });
                    
                    mediaUploader.open();
                });
            }
        });
        </script>
        <?php
    }
    
    /* Zapisz ustawienia*/
    public function save_settings() {
        if (!wp_verify_nonce($_POST['clean_nonce'], 'save_clean_404_video')) {
            wp_die('Security check failed');
        }
        
        if (!current_user_can('manage_options')) {
            wp_die('Insufficient permissions');
        }
        
        $options = array(
            'enabled' => isset($_POST['enabled']) ? 1 : 0,
            'video_url' => sanitize_url($_POST['video_url']),
            'video_opacity' => max(10, min(60, intval($_POST['video_opacity']))),
            'video_blur' => max(0, min(10, intval($_POST['video_blur']))),
            'overlay_opacity' => max(0, min(0.7, floatval($_POST['overlay_opacity']))),
            'mobile_video' => isset($_POST['mobile_video']) ? 1 : 0,
            'preload' => isset($_POST['preload']) ? 1 : 0,
            
            // Nowe opcje intro
            'intro_title' => sanitize_text_field($_POST['intro_title']),
            'intro_subtitle' => sanitize_text_field($_POST['intro_subtitle']),
            'intro_duration' => max(2, min(15, intval($_POST['intro_duration']))),
            
            // Główna zawartość
            'page_title' => sanitize_text_field($_POST['page_title']),
            'page_subtitle' => sanitize_textarea_field($_POST['page_subtitle']),
            'quote_text' => sanitize_textarea_field($_POST['quote_text']),
            'button_home' => sanitize_text_field($_POST['button_home']),
            'button_contact' => sanitize_text_field($_POST['button_contact']),
        );
        
        // Handle file upload
        if (!empty($_FILES['video_file']['name'])) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
            
            $upload = wp_handle_upload($_FILES['video_file'], array('test_form' => false));
            if (!isset($upload['error'])) {
                $options['video_url'] = $upload['url'];
            }
        }
        
        update_option('clean_404_video_options', $options);
        
        wp_redirect(admin_url('options-general.php?page=clean-404-video&saved=1'));
        exit;
    }
    
    /*Domyślne opcje*/
    private function get_defaults() {
        return array(
            'enabled' => 0,
            'video_url' => '',
            'video_opacity' => 25,
            'video_blur' => 3,
            'overlay_opacity' => 0.3,
            'mobile_video' => 0,
            'preload' => 0,
            
            // Intro
            'intro_title' => 'Błąd 404',
            'intro_subtitle' => 'Przygotowujemy coś specjalnego...',
            'intro_duration' => 5,
            
            // Główna zawartość
            'page_title' => 'Zaginiona Ścieżka',
            'page_subtitle' => 'Zagłębiłeś się zbyt daleko w mroczne ostępy internetu...',
            'quote_text' => 'Zło jest złem, małe, większe, pośrednie... Jeżeli mam wybierać pomiędzy jednym a drugim, wolę nie wybierać wcale.',
            'button_home' => 'Powrót do Domu',
            'button_contact' => 'Wezwij Wiedźmina',
        );
    }
}

// Inicjalizacja
new Clean404VideoOnly();

// Enqueue Media Library scripts w adminie
add_action('admin_enqueue_scripts', function($hook) {
    if ($hook === 'settings_page_clean-404-video') {
        wp_enqueue_media();
    }
});

// Admin notice po aktywacji
register_activation_hook(__FILE__, function() {
    set_transient('clean_404_activated', true, 60);
});

add_action('admin_notices', function() {
    if (get_transient('clean_404_activated')) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><strong>🎬 Wideo 404 aktywowane!</strong> 
               Przejdź do <a href="<?php echo admin_url('options-general.php?page=clean-404-video'); ?>">Ustawienia > Page 404</a> 
               żeby włączyć.
            </p>
        </div>
        <?php
        delete_transient('clean_404_activated');
    }
});