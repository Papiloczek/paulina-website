<?php
/*
Plugin Name: Loading Screen Plugin Pro
Description: Ekran ładowania z panelem administracyjnym i podglądem
Version: 2.0
Author: ppIndustry
*/

if (!defined('ABSPATH')) {
    exit;
}

class LoadingScreenPlugin
{

    public function __construct()
    {
        add_action('init', array($this, 'init'));
        add_action('admin_menu', array($this, 'admin_menu'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_body_open', array($this, 'add_loading_screen'));
        add_action('wp_ajax_preview_loading_screen', array($this, 'preview_loading_screen'));
        add_action('wp_ajax_nopriv_preview_loading_screen', array($this, 'preview_loading_screen'));
    }

    public function init()
    {
        // Inicjalizacja wtyczki
    }

    // Panel administracyjny
    public function admin_menu()
    {
        add_options_page(
            'Loading Screen Settings',
            'Loading Screen',
            'manage_options',
            'loading-screen-settings',
            array($this, 'admin_page')
        );
    }

    // Strona administracyjna
    public function admin_page()
    {
        if (isset($_POST['submit'])) {
            update_option('loading_screen_enabled', isset($_POST['enabled']) ? 1 : 0);
            update_option('loading_screen_cache_time', sanitize_text_field($_POST['cache_time']));
            echo '<div class="notice notice-success"><p>Ustawienia zapisane!</p></div>';
        }

        $enabled = get_option('loading_screen_enabled', 1);
        $cache_time = get_option('loading_screen_cache_time', 3600);
        ?>
        <div class="wrap">
            <h1>Loading Screen Settings</h1>

            <form method="post" action="">
                <table class="form-table">
                    <tr>
                        <th scope="row">Włącz Loading Screen</th>
                        <td>
                            <input type="checkbox" name="enabled" value="1" <?php checked($enabled, 1); ?>>
                            <label>Wyświetl ekran ładowania na stronie głównej</label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Czas cache (sekundy)</th>
                        <td>
                            <input type="number" name="cache_time" value="<?php echo $cache_time; ?>" min="0" max="86400">
                            <p class="description">Jak długo nie pokazywać ponownie ekranu ładowania (0 = zawsze pokazuj)</p>
                        </td>
                    </tr>
                </table>

                <?php submit_button(); ?>
            </form>

            <hr>

            <h2>Podgląd i Zarządzanie</h2>

            <p>
                <button type="button" class="button button-primary" onclick="previewLoadingScreen()">
                    🎬 Podgląd Loading Screen
                </button>
                <button type="button" class="button" onclick="clearLoadingCache()">
                    🗑️ Wyczyść Cache
                </button>
                <button type="button" class="button" onclick="testMobile()">
                    📱 Test Mobile View
                </button>
            </p>

            <div id="preview-container" style="display: none; border: 1px solid #ccc; margin-top: 20px;">
                <iframe id="preview-frame" width="100%" height="600" frameborder="0"></iframe>
            </div>

            <h3>Instrukcje:</h3>
            <ul>
                <li><strong>Podgląd:</strong> Otwiera okno z podglądem ekranu ładowania</li>
                <li><strong>Wyczyść Cache:</strong> Usuwa cookie, aby ponownie pokazać loading screen</li>
                <li><strong>Test Mobile:</strong> Podgląd w trybie mobilnym</li>
            </ul>

            <script>
                function previewLoadingScreen() {
                    const container = document.getElementById('preview-container');
                    const frame = document.getElementById('preview-frame');

                    frame.src = '<?php echo admin_url('admin-ajax.php'); ?>?action=preview_loading_screen&preview=1';
                    container.style.display = 'block';

                    // Scroll do podglądu
                    container.scrollIntoView({ behavior: 'smooth' });
                }

                function clearLoadingCache() {
                    document.cookie = 'loading_screen_viewed=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT';
                    alert('Cache został wyczyszczony! Teraz możesz odwiedzić stronę główną, aby zobaczyć loading screen.');
                }

                function testMobile() {
                    const container = document.getElementById('preview-container');
                    const frame = document.getElementById('preview-frame');

                    // Ustaw szerokość mobilną
                    frame.width = '375';
                    frame.height = '667';
                    frame.src = '<?php echo admin_url('admin-ajax.php'); ?>?action=preview_loading_screen&preview=1&mobile=1';
                    container.style.display = 'block';
                    container.scrollIntoView({ behavior: 'smooth' });
                }
            </script>

            <style>
                .form-table th {
                    width: 200px;
                }

                #preview-container {
                    background: #f1f1f1;
                    padding: 20px;
                    border-radius: 5px;
                }
            </style>
        </div>
        <?php
    }

    // Funkcja podglądu
    public function preview_loading_screen()
    {
        if (!current_user_can('manage_options')) {
            wp_die('Brak uprawnień');
        }

        $is_mobile = isset($_GET['mobile']);

        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Loading Screen Preview</title>
            <style>
                body {
                    margin: 0;
                    padding: 0;
                    <?php if ($is_mobile): ?>
                        width: 375px;
                        height: 667px;
                    <?php endif; ?>
                }
            </style>
            <?php
            // Załaduj style loading screen
            echo '<link rel="stylesheet" href="' . plugin_dir_url(__FILE__) . 'loading-screen.css">';
            ?>
        </head>

        <body>
            <?php include(plugin_dir_path(__FILE__) . 'loading-screen.php'); ?>

            <div
                style="position: fixed; top: 10px; right: 10px; background: rgba(0,0,0,0.8); color: white; padding: 10px; border-radius: 5px; font-size: 12px; z-index: 10000;">
                <?php echo $is_mobile ? '📱 Mobile Preview' : '💻 Desktop Preview'; ?>
            </div>

            <script src="<?php echo plugin_dir_url(__FILE__) . 'loading-screen.js'; ?>"></script>
        </body>

        </html>
        <?php
        exit;
    }

    // Dodanie ekranu ładowania
    public function add_loading_screen()
    {
        if (!get_option('loading_screen_enabled', 1)) {
            return;
        }

        $cache_time = get_option('loading_screen_cache_time', 3600);
        $force_preview = isset($_GET['loading_preview']) && current_user_can('manage_options');

        if ((is_front_page() || is_home()) && (!isset($_COOKIE['loading_screen_viewed']) || $force_preview)) {
            echo '<div id="loading-screen-overlay">';
            include(plugin_dir_path(__FILE__) . 'loading-screen.php');
            echo '</div>';

            if (!$force_preview && $cache_time > 0) {
                echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const enterBtn = document.getElementById("enter-website");
                        if (enterBtn) {
                            enterBtn.addEventListener("click", function() {
                                document.cookie = "loading_screen_viewed=1; path=/; max-age=' . $cache_time . '";
                            });
                        }
                    });
                </script>';
            }
        }
    }

    // Ładowanie skryptów i stylów
    public function enqueue_scripts()
    {
        if (!get_option('loading_screen_enabled', 1)) {
            return;
        }

        $cache_time = get_option('loading_screen_cache_time', 3600);
        $force_preview = isset($_GET['loading_preview']) && current_user_can('manage_options');

        if ((is_front_page() || is_home()) && (!isset($_COOKIE['loading_screen_viewed']) || $force_preview)) {
            wp_enqueue_style('loading-screen-styles', plugin_dir_url(__FILE__) . 'loading-screen.css', array(), '2.0');
            wp_enqueue_script('loading-screen-script', plugin_dir_url(__FILE__) . 'loading-screen.js', array(), '2.0', true);

            // Ukryj zawartość strony podczas loading screen
            wp_add_inline_style('loading-screen-styles', '
                body .header-wrapper, 
                body .page-description, 
                body .last_post_section_w, 
                body .processor-animation, 
                body .aboute-me,
                body .blog-section, 
                body .container, 
                body .site-footer,
                body header,
                body main,
                body footer {
                    display: none !important;
                }
                
                body.content-visible .header-wrapper, 
                body.content-visible .page-description, 
                body.content-visible .last_post_section_w, 
                body.content-visible .processor-animation,
                body.content-visible .aboute-me, 
                body.content-visible .blog-section, 
                body.content-visible .container,
                body.content-visible .site-footer,
                body.content-visible header,
                body.content-visible main,
                body.content-visible footer {
                    display: block !important;
                }
                
                #loading-screen-overlay {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100vh;
                    background: linear-gradient(135deg, #080b14 0%, #12151e 100%);
                    z-index: 99999;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    font-family: "Courier New", Courier, monospace;
                }
                
                #loading-screen-overlay.fade-out {
                    opacity: 0;
                    visibility: hidden;
                    transition: all 0.5s ease-out;
                }
            ');

            // Dodaj ulepszoną obsługę JavaScript
            wp_add_inline_script('loading-screen-script', '
                document.addEventListener("DOMContentLoaded", function() {
                    const enterWebsiteBtn = document.getElementById("enter-website");
                    const overlay = document.getElementById("loading-screen-overlay");
                    
                    if (enterWebsiteBtn && overlay) {
                        enterWebsiteBtn.addEventListener("click", function(e) {
                            e.preventDefault();
                            
                            // Animacja znikania
                            overlay.classList.add("fade-out");
                            
                            setTimeout(function() {
                                overlay.style.display = "none";
                                document.body.classList.add("content-visible");
                            }, 500);
                        });
                    }
                });
            ');
        }

        // Dodaj link do podglądu dla adminów
        if (current_user_can('manage_options') && (is_front_page() || is_home())) {
            wp_add_inline_style('wp-admin-bar', '
                #wpadminbar {
                    position: relative !important;
                }
                .loading-preview-link {
                    position: fixed;
                    top: 32px;
                    right: 20px;
                    background: #0073aa;
                    color: white;
                    padding: 8px 12px;
                    text-decoration: none;
                    border-radius: 3px;
                    font-size: 12px;
                    z-index: 99998;
                }
            ');

            // add_action('wp_footer', function () {
            //     echo '<a href="?loading_preview=1" class="loading-preview-link">👁️ Podgląd Loading Screen</a>';
            // });
        }
    }
}

// Inicjalizacja wtyczki
new LoadingScreenPlugin();