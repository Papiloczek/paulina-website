<?php
/*
Plugin Name: Loading Screen Overlay
Description: loading screen 
Version: 3.1
Author: ppIndustry
*/

if (!defined('ABSPATH')) {
    exit;
}

class LoadingScreenOverlay
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_footer', array($this, 'add_overlay'));
        add_action('admin_menu', array($this, 'admin_menu'));
    }

    public function admin_menu()
    {
        add_options_page(
            'Loading Overlay Settings',
            'Loading Overlay',
            'manage_options',
            'loading-overlay-settings',
            array($this, 'admin_page')
        );
    }

    public function admin_page()
    {
        if (isset($_POST['submit'])) {
            update_option('loading_overlay_enabled', isset($_POST['enabled']) ? 1 : 0);
            update_option('loading_overlay_animation', sanitize_text_field($_POST['animation']));
            update_option('loading_overlay_delay', intval($_POST['delay']));
            echo '<div class="notice notice-success"><p>Ustawienia zapisane!</p></div>';
        }

        $enabled = get_option('loading_overlay_enabled', 1);
        $animation = get_option('loading_overlay_animation', 'slide-from-corner');
        $delay = get_option('loading_overlay_delay', 500);
        ?>
        <div class="wrap">
            <h1>🚀 Loading Overlay Settings</h1>

            <form method="post">
                <table class="form-table">
                    <tr>
                        <th scope="row">Włącz Loading Overlay</th>
                        <td>
                            <input type="checkbox" name="enabled" value="1" <?php checked($enabled, 1); ?>>
                            <label>Wyświetl loading overlay na stronie głównej</label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Typ animacji</th>
                        <td>
                            <select name="animation">
                                <option value="slide-from-corner" <?php selected($animation, 'slide-from-corner'); ?>>Wysunięcie
                                    z rogu</option>
                                <option value="fade-in" <?php selected($animation, 'fade-in'); ?>>Fade In</option>
                                <option value="zoom-in" <?php selected($animation, 'zoom-in'); ?>>Zoom In</option>
                                <option value="slide-from-top" <?php selected($animation, 'slide-from-top'); ?>>Slide z góry
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Opóźnienie (ms)</th>
                        <td>
                            <input type="number" name="delay" value="<?php echo $delay; ?>" min="0" max="5000">
                            <p class="description">Opóźnienie przed pokazaniem overlay (0-5000ms)</p>
                        </td>
                    </tr>
                </table>

                <?php submit_button('💾 Zapisz ustawienia'); ?>
            </form>

            <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                <h3>🎬 Testowanie & Zarządzanie</h3>
                <p>
                    <button type="button" class="button button-primary" onclick="testOverlay()">
                        🎬 Test Overlay
                    </button>
                    <button type="button" class="button" onclick="clearCache()">
                        🗑️ Wyczyść Cache
                    </button>
                </p>
                <p style="color: #666; font-size: 13px;">
                    <strong>Test Overlay:</strong> Otwiera podgląd overlay w nowej karcie<br>
                    <strong>Wyczyść Cache:</strong> Resetuje cookie - overlay pokaże się ponownie
                </p>
            </div>

            <script>
                function testOverlay() {
                    window.open('<?php echo home_url('?test_overlay=1'); ?>', '_blank');
                }

                function clearCache() {
                    document.cookie = 'loading_overlay_seen=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT';
                    alert('Cache wyczyszczony! Overlay pokaże się ponownie na stronie głównej.');
                }
            </script>
        </div>
        <?php
    }

    public function enqueue_scripts()
    {
        if (!$this->should_show_overlay()) {
            return;
        }

        wp_enqueue_style('loading-overlay-css', plugin_dir_url(__FILE__) . 'screen-overlay.css', array(), '3.1');
        wp_enqueue_script('loading-overlay-js', plugin_dir_url(__FILE__) . 'screen-overlay.js', array(), '3.1', true);

        wp_localize_script('loading-overlay-js', 'loadingOverlaySettings', array(
            'animation' => get_option('loading_overlay_animation', 'slide-from-corner'),
            'delay' => get_option('loading_overlay_delay', 500),
            'homeUrl' => home_url()
        ));
    }

    public function add_overlay()
    {
        if (!$this->should_show_overlay()) {
            return;
        }

        ?>
        <div id="loading-overlay" class="loading-overlay hidden">
            <div class="overlay-content">
                <div class="terminal-wrapper">
                    <div class="terminal" id="terminal-overlay">
                        <div class="terminal-header">
                            <div class="terminal-circle terminal-red"></div>
                            <div class="terminal-circle terminal-yellow"></div>
                            <div class="terminal-circle terminal-green"></div>
                            <div class="terminal-title">launch_creative_strategy.py</div>
                        </div>
                        <div class="terminal-content">
                            <pre id="code-overlay"></pre>
                            <span class="cursor"></span>
                        </div>
                    </div>
                </div>

                <button id="execute-btn-overlay" class="execute-btn hidden">Execute Strategy</button>

                <div class="icon-display" id="icon-display-overlay">
                    <div class="icon" id="icon-1-overlay">🔍 Research & Analytics</div>
                    <div class="icon" id="icon-2-overlay">🎯 Strategy & Targeting</div>
                    <div class="icon" id="icon-3-overlay">🧠 AI-Powered Insights</div>
                    <div class="icon" id="icon-4-overlay">💻 Creative Development</div>
                </div>

                <div class="loading-bar-container" id="loading-overlay-bar">
                    <div class="loading-bar-fill"></div>
                    <div class="loading-glow"></div>
                </div>

                <div id="progress-text-overlay">Initializing resources...</div>

                <div id="final-text-overlay" class="final-text hidden">
                    <p>Digital Innovation Powered by</p>
                    <p><strong>ppIndustry</strong></p>
                </div>

                <!-- Przyciski -->
                <button id="enter-website-overlay" class="enter-website-btn" style="display: none;">
                    🚀 Enter Website
                </button>

                <button id="close-overlay" class="close-btn" style="display: none;">
                    Enter Website
                </button>

                <button id="skip-overlay" class="skip-btn">
                    Skip →
                </button>
            </div>

            <div class="overlay-background"></div>
        </div>
        <?php
    }

    private function should_show_overlay()
    {
        // Sprawdź czy overlay jest włączony
        if (!get_option('loading_overlay_enabled', 1)) {
            return false;
        }

        // Tryb testowy dla administratorów
        $test_mode = isset($_GET['test_overlay']) && current_user_can('manage_options');

        // Sprawdź cookie tylko jeśli nie jesteśmy w trybie testowym
        $already_seen = isset($_COOKIE['loading_overlay_seen']) && !$test_mode;

        // Sprawdź czy jesteśmy na stronie głównej
        $on_homepage = is_front_page() || is_home();

        return ($on_homepage || $test_mode) && !$already_seen;
    }
}

new LoadingScreenOverlay();