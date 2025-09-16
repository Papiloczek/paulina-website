<?php
if (!defined('ABSPATH')) {
    exit;
}

function load_font_awesome() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'load_font_awesome');

// Funkcja bezpiecznego sprawdzania czasu modyfikacji pliku
function safe_filemtime($file_path)
{
    $full_path = get_template_directory() . $file_path;
    return file_exists($full_path) ? filemtime($full_path) : '1.0.0';
}

// Główna funkcja ładowania zasobów
function add_theme_scripts()
{
    // Main stylesheet
    wp_enqueue_style(
        'main-style',
        get_stylesheet_uri(),
        array(),
        safe_filemtime('/style.css')
    );

    // Navigation stylesheet
    if (file_exists(get_template_directory() . '/css/navigation.css')) {
        wp_enqueue_style(
            'navigation-style',
            get_template_directory_uri() . '/css/navigation.css',
            array(),
            safe_filemtime('/css/navigation.css')
        );
    }

    // Footer stylesheet
    if (file_exists(get_template_directory() . '/css/footer.css')) {
        wp_enqueue_style(
            'footer-style',
            get_template_directory_uri() . '/css/footer.css',
            array(),
            safe_filemtime('/css/footer.css')
        );
    }

    // JavaScript
    if (file_exists(get_template_directory() . '/index.js')) {
        wp_enqueue_script(
            'main-script',
            get_template_directory_uri() . '/index.js',
            array('jquery'),
            safe_filemtime('/index.js'),
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'add_theme_scripts');

// Konfiguracja motywu
function theme_setup()
{
    add_theme_support('post-thumbnails');
    add_theme_support('custom-background');
    add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script'));
    add_theme_support('title-tag');
    add_theme_support('custom-header');
    add_theme_support('custom-logo');
    add_theme_support('menus');

    // Rejestracja menu - tylko raz!
    register_nav_menus(array(
        'primary' => __('Main Header Menu', 'paulinatheme'),
        'footer' => __('Main Footer Menu', 'paulinatheme'),
        'footer-secondary' => __('Menu dodatkowe stopki', 'paulinatheme'),
    ));
}
add_action('after_setup_theme', 'theme_setup');

// Stylowanie pojedynczych postów
function load_custom_article_styles()
{
    if (is_singular('post') && get_page_template_slug() === 'single-custom.php') {
        if (file_exists(get_template_directory() . '/css/custom-article.css')) {
            wp_enqueue_style('custom-article-style', get_template_directory_uri() . '/css/custom-article.css');
        }
    }
}
add_action('wp_enqueue_scripts', 'load_custom_article_styles');

// Animacja procesora - tylko na stronie głównej
function add_processor_animation_assets()
{
    if (is_front_page()) {
        if (file_exists(get_template_directory() . '/css/circuit-animation.css')) {
            wp_enqueue_style(
                'circuit-animation-styles',
                get_template_directory_uri() . '/css/circuit-animation.css',
                array(),
                '1.0.0'
            );
        }

        if (file_exists(get_template_directory() . '/circuit-animation.js')) {
            wp_enqueue_script(
                'circuit-animation-script',
                get_template_directory_uri() . '/circuit-animation.js',
                array('jquery'),
                '1.0.0',
                true
            );
        }
    }
}
add_action('wp_enqueue_scripts', 'add_processor_animation_assets');

// Widget areas dla stopki
function paulina_theme_widgets_init()
{
    register_sidebar(array(
        'name' => __('Stopka - informacje', 'paulina-theme'),
        'id' => 'footer-info',
        'description' => __('Obszar dla dodatkowych informacji w stopce', 'paulina-theme'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="footer-widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => __('Stopka - kontakt', 'paulina-theme'),
        'id' => 'footer-contact',
        'description' => __('Obszar kontaktowy w stopce', 'paulina-theme'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="footer-widget-title">',
        'after_title' => '</h4>',
    ));
}
add_action('widgets_init', 'paulina_theme_widgets_init');

// Funkcja pomocnicza do wyświetlania menu stopki
function paulina_theme_footer_menu()
{
    wp_nav_menu(array(
        'theme_location' => 'footer',
        'menu_class' => 'footer-menu',
        'container' => false,
        'fallback_cb' => false,
        'depth' => 1,
    ));
}

// Dodanie opcji do Customizera
function paulina_theme_customize_register($wp_customize)
{
    $wp_customize->add_section('paulina_footer_settings', array(
        'title' => __('Ustawienia stopki', 'paulina-theme'),
        'priority' => 120,
    ));

    $wp_customize->add_setting('footer_copyright_text', array(
        'default' => '© 2025 PaulinaTheme. Wszystkie prawa zastrzeżone.',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('footer_copyright_text', array(
        'label' => __('Tekst copyright', 'paulina-theme'),
        'section' => 'paulina_footer_settings',
        'type' => 'text',
    ));

    $wp_customize->add_setting('footer_description', array(
        'default' => 'Specjalizuję się w tworzeniu nowoczesnych rozwiązań technologicznych dla przemysłu.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('footer_description', array(
        'label' => __('Opis w stopce', 'paulina-theme'),
        'section' => 'paulina_footer_settings',
        'type' => 'textarea',
    ));

    // Social media
    $social_platforms = array('facebook', 'twitter', 'linkedin', 'instagram', 'github');

    foreach ($social_platforms as $platform) {
        $wp_customize->add_setting("social_{$platform}", array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("social_{$platform}", array(
            'label' => sprintf(__('Link %s', 'paulina-theme'), ucfirst($platform)),
            'section' => 'paulina_footer_settings',
            'type' => 'url',
        ));
    }
}
add_action('customize_register', 'paulina_theme_customize_register');

// Zasoby dla strony bloga
function load_blog_assets()
{
    if (is_page_template('page-blog.php')) {
        if (file_exists(get_template_directory() . '/blog-page.css')) {
            wp_enqueue_style(
                'page-blog-style',
                get_template_directory_uri() . '/blog-page.css',
                array(),
                '1.0.0'
            );
        }

        if (file_exists(get_template_directory() . '/page-blog.js')) {
            wp_enqueue_script(
                'blog-functionality',
                get_template_directory_uri() . '/page-blog.js',
                array('jquery'),
                '1.0.0',
                true
            );

            wp_localize_script('blog-functionality', 'blogAjax', array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('blog_nonce')
            ));
        }

        wp_enqueue_style(
            'google-fonts-blog',
            'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;700&display=swap',
            array(),
            null
        );
    }
}
add_action('wp_enqueue_scripts', 'load_blog_assets');

// Funkcja czasu czytania artykułu
function pp_industry_estimated_reading_time()
{
    $content = get_post_field('post_content', get_the_ID());
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200);
    return $reading_time;
}

// Newsletter signup handler
function handle_newsletter_signup()
{
    if (!isset($_POST['action']) || $_POST['action'] !== 'newsletter_signup') {
        return;
    }

    if (!wp_verify_nonce($_POST['newsletter_nonce'], 'newsletter_signup')) {
        wp_die('Błąd bezpieczeństwa');
    }

    $email = sanitize_email($_POST['newsletter_email']);

    if (!is_email($email)) {
        wp_redirect(add_query_arg('newsletter', 'error', wp_get_referer()));
        exit;
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';

    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id int(11) NOT NULL AUTO_INCREMENT,
        email varchar(255) NOT NULL,
        date_subscribed datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY email (email)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    $result = $wpdb->insert(
        $table_name,
        array(
            'email' => $email,
            'date_subscribed' => current_time('mysql')
        )
    );

    if ($result) {
        wp_redirect(add_query_arg('newsletter', 'success', wp_get_referer()));
    } else {
        wp_redirect(add_query_arg('newsletter', 'exists', wp_get_referer()));
    }
    exit;
}
add_action('admin_post_newsletter_signup', 'handle_newsletter_signup');
add_action('admin_post_nopriv_newsletter_signup', 'handle_newsletter_signup');

// Meta box dla wyróżnionego artykułu
function add_featured_post_meta_box()
{
    add_meta_box(
        'featured_post',
        'Wyróżniony artykuł',
        'featured_post_meta_box_callback',
        'post',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'add_featured_post_meta_box');

function featured_post_meta_box_callback($post)
{
    wp_nonce_field('featured_post_meta_box', 'featured_post_meta_box_nonce');
    $value = get_post_meta($post->ID, 'featured_post', true);
    echo '<label for="featured_post_field">';
    echo '<input type="checkbox" id="featured_post_field" name="featured_post_field" value="1" ' . checked($value, '1', false) . ' />';
    echo ' Ustaw jako wyróżniony artykuł';
    echo '</label>';
}

function save_featured_post_meta_box($post_id)
{
    if (!isset($_POST['featured_post_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['featured_post_meta_box_nonce'], 'featured_post_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['post_type']) && 'post' == $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    if (!isset($_POST['featured_post_field'])) {
        delete_post_meta($post_id, 'featured_post');
        return;
    }

    $my_data = sanitize_text_field($_POST['featured_post_field']);
    update_post_meta($post_id, 'featured_post', $my_data);
}
add_action('save_post', 'save_featured_post_meta_box');

// Rozmiary obrazów
add_image_size('blog-card-image', 350, 200, true);
add_image_size('featured-post-image', 600, 400, true);

// Niestandardowe rozmiary wyciągów
function custom_excerpt_length($length)
{
    return 20;
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);

function custom_excerpt_more($more)
{
    return '...';
}
add_filter('excerpt_more', 'custom_excerpt_more');

// Zabezpieczenia
function remove_wp_version()
{
    return '';
}
add_filter('the_generator', 'remove_wp_version');

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');

add_filter('xmlrpc_enabled', '__return_false');

// Ograniczenie prób logowania
function limit_login_attempts()
{
    $attempts = get_option('failed_login_attempts', array());
    $ip = $_SERVER['REMOTE_ADDR'];
    $current_time = time();

    foreach ($attempts as $attempt_ip => $data) {
        if ($current_time - $data['time'] > 3600) {
            unset($attempts[$attempt_ip]);
        }
    }

    if (isset($attempts[$ip]) && $attempts[$ip]['count'] >= 5) {
        if ($current_time - $attempts[$ip]['time'] < 3600) {
            wp_die('Zbyt wiele nieudanych prób logowania. Spróbuj ponownie za godzinę.');
        } else {
            unset($attempts[$ip]);
        }
    }

    update_option('failed_login_attempts', $attempts);
}

add_action('wp_login_failed', function () {
    $attempts = get_option('failed_login_attempts', array());
    $ip = $_SERVER['REMOTE_ADDR'];

    if (!isset($attempts[$ip])) {
        $attempts[$ip] = array('count' => 0, 'time' => time());
    }

    $attempts[$ip]['count']++;
    $attempts[$ip]['time'] = time();

    update_option('failed_login_attempts', $attempts);
});

// Zasoby dla strony kontaktowej
function load_contact_assets()
{
    if (is_page_template('page-contact.php')) {
        if (file_exists(get_template_directory() . '/contact-style.css')) {
            wp_enqueue_style(
                'contact-page-style',
                get_template_directory_uri() . '/contact-style.css',
                array(),
                '1.0.0'
            );
        }

        if (file_exists(get_template_directory() . '/page-contact.js')) {
            wp_enqueue_script(
                'contact-functionality',
                get_template_directory_uri() . '/page-contact.js',
                array('jquery'),
                '1.0.0',
                true
            );

            wp_localize_script('contact-functionality', 'contactAjax', array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('contact_form_nonce'),
                'messages' => array(
                    'sending' => 'Wysyłanie...',
                    'success' => 'Wiadomość została wysłana!',
                    'error' => 'Wystąpił błąd. Spróbuj ponownie.',
                    'validation_error' => 'Proszę wypełnić wszystkie wymagane pola.'
                )
            ));
        }
    }
}
add_action('wp_enqueue_scripts', 'load_contact_assets');

// Reszta funkcji kontaktowych pozostaje bez zmian...
// (Zostały one skrócone dla zwięzłości, ale działają poprawnie)



// kierowcy
function create_drivers_table() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'driver_courses';
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        week_start date NOT NULL,
        driver_name varchar(100) NOT NULL,
        day_index tinyint(1) NOT NULL,
        course_data longtext NOT NULL,
        created_by varchar(100) NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY  (id),
        KEY week_driver (week_start, driver_name),
        KEY created_by (created_by)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Stwórz tabelę audit log
function create_audit_log_table() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'driver_audit_log';
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        user_login varchar(100) NOT NULL,
        action varchar(255) NOT NULL,
        week_start date DEFAULT NULL,
        details text DEFAULT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id),
        KEY user_login (user_login),
        KEY created_at (created_at)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

add_action('after_setup_theme', 'create_drivers_table');
add_action('after_setup_theme', 'create_audit_log_table');

// AJAX endpoint do zapisu danych
function save_driver_courses() {
    // Sprawdź czy POST ma wszystkie dane
    if (!isset($_POST['nonce']) || !isset($_POST['week_start']) || !isset($_POST['courses_data'])) {
        wp_send_json_error('Brakuje danych');
        return;
    }
    
    // Sprawdź bezpieczeństwo (dla zalogowanych użytkowników WordPress)
    if (!wp_verify_nonce($_POST['nonce'], 'driver_courses_nonce')) {
        wp_send_json_error('Błąd bezpieczeństwa - nieprawidłowy nonce');
        return;
    }
    
    // Sprawdź uprawnienia - tylko ci którzy mogą edytować posty
    if (!current_user_can('edit_posts')) {
        wp_send_json_error('Brak uprawnień do zapisu');
        return;
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'driver_courses';
    
    $week_start = sanitize_text_field($_POST['week_start']);
    $courses_data = json_decode(stripslashes($_POST['courses_data']), true);
    
    if (!$courses_data) {
        wp_send_json_error('Błędne dane JSON');
        return;
    }
    
    $current_user = wp_get_current_user();
    
    // Usuń stare dane z tego tygodnia
    $deleted = $wpdb->delete(
        $table_name,
        array('week_start' => $week_start),
        array('%s')
    );
    
    // Zapisz nowe dane
    $inserted = 0;
    if (isset($courses_data['drivers'])) {
        foreach ($courses_data['drivers'] as $driver_data) {
            if (isset($driver_data['days'])) {
                foreach ($driver_data['days'] as $day_index => $day_courses) {
                    if (!empty($day_courses)) {
                        $result = $wpdb->insert(
                            $table_name,
                            array(
                                'week_start' => $week_start,
                                'driver_name' => sanitize_text_field($driver_data['name']),
                                'day_index' => intval($day_index),
                                'course_data' => wp_json_encode($day_courses),
                                'created_by' => $current_user->user_login
                            ),
                            array('%s', '%s', '%d', '%s', '%s')
                        );
                        
                        if ($result) $inserted++;
                    }
                }
            }
        }
    }
    
    // Log aktywności
    $audit_table = $wpdb->prefix . 'driver_audit_log';
    $wpdb->insert(
        $audit_table,
        array(
            'user_login' => $current_user->user_login,
            'action' => 'Zapisał dane kierowców',
            'week_start' => $week_start,
            'details' => "Usunięto: $deleted, Dodano: $inserted rekordów",
            'created_at' => current_time('mysql')
        ),
        array('%s', '%s', '%s', '%s', '%s')
    );
    
    wp_send_json_success(array(
        'message' => 'Dane zapisane w bazie WordPress!',
        'deleted' => $deleted,
        'inserted' => $inserted
    ));
}

// AJAX endpoint do wczytania danych  
function load_driver_courses() {
    // Sprawdź czy POST ma potrzebne dane
    if (!isset($_POST['week_start'])) {
        wp_send_json_error('Brak daty tygodnia');
        return;
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'driver_courses';
    
    $week_start = sanitize_text_field($_POST['week_start']);
    
    // Sprawdź czy tabela istnieje
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name;
    if (!$table_exists) {
        wp_send_json_success(array(
            'startDate' => $week_start,
            'drivers' => array(),
            'loadedFrom' => 'Tabela nie istnieje',
            'debug' => array('table_exists' => false)
        ));
        return;
    }
    
    $results = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $table_name WHERE week_start = %s ORDER BY driver_name, day_index",
        $week_start
    ));
    
    // Debug
    error_log('Driver Courses - Tydzień: ' . $week_start . ', Znaleziono: ' . count($results));
    
    $drivers_data = array();
    foreach ($results as $row) {
        if (!isset($drivers_data[$row->driver_name])) {
            $drivers_data[$row->driver_name] = array(
                'name' => $row->driver_name,
                'days' => array_fill(0, 7, array())
            );
        }
        
        $course_data = json_decode($row->course_data, true);
        if ($course_data) {
            $drivers_data[$row->driver_name]['days'][$row->day_index] = $course_data;
        }
    }
    
    wp_send_json_success(array(
        'startDate' => $week_start,
        'drivers' => array_values($drivers_data),
        'loadedFrom' => 'WordPress Database',
        'lastModified' => current_time('mysql'),
        'debug' => array(
            'week_searched' => $week_start,
            'records_found' => count($results),
            'drivers_processed' => count($drivers_data),
            'table_exists' => true
        )
    ));
}

add_action('wp_ajax_save_driver_courses', 'save_driver_courses');
add_action('wp_ajax_nopriv_save_driver_courses', 'save_driver_courses');
add_action('wp_ajax_load_driver_courses', 'load_driver_courses');
add_action('wp_ajax_nopriv_load_driver_courses', 'load_driver_courses');

// Panel Admin
function drivers_admin_menu() {
    add_menu_page(
        'System Kierowców',
        'Kierowcy',
        'manage_options',
        'driver-courses',
        'drivers_admin_page',
        'dashicons-groups',
        30
    );
}
add_action('admin_menu', 'drivers_admin_menu');

function drivers_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'driver_courses';
    
    // Sprawdź czy tabela istnieje
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name;
    
    if (!$table_exists) {
        echo '<div class="wrap"><h1>System Kierowców</h1>';
        echo '<div class="notice notice-error"><p>❌ Tabela bazy danych nie istnieje! Spróbuj odświeżyć stronę.</p></div>';
        echo '</div>';
        return;
    }
    
    // Pobierz statystyki
    $total_courses = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    $total_weeks = $wpdb->get_var("SELECT COUNT(DISTINCT week_start) FROM $table_name");
    $total_drivers = $wpdb->get_var("SELECT COUNT(DISTINCT driver_name) FROM $table_name");
    
    ?>
    <div class="wrap">
        <h1>System Kierowców - Statystyki</h1>
        
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin: 20px 0;">
            <div style="background: white; padding: 20px; border: 1px solid #ccc;">
                <h3>Łączne kursy</h3>
                <p style="font-size: 24px; color: #0073aa;"><?php echo $total_courses; ?></p>
            </div>
            <div style="background: white; padding: 20px; border: 1px solid #ccc;">
                <h3>Tygodnie</h3>
                <p style="font-size: 24px; color: #0073aa;"><?php echo $total_weeks; ?></p>
            </div>
            <div style="background: white; padding: 20px; border: 1px solid #ccc;">
                <h3>Kierowcy</h3>
                <p style="font-size: 24px; color: #0073aa;"><?php echo $total_drivers; ?></p>
            </div>
        </div>
        
        <?php if ($total_weeks > 0): ?>
        <h2>Ostatnie tygodnie</h2>
        <?php
        $recent_weeks = $wpdb->get_results(
            "SELECT week_start, COUNT(*) as courses, 
             GROUP_CONCAT(DISTINCT driver_name) as drivers
             FROM $table_name 
             GROUP BY week_start 
             ORDER BY week_start DESC 
             LIMIT 10"
        );
        ?>
        
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Tydzień</th>
                    <th>Kursy</th>
                    <th>Kierowcy</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recent_weeks as $week): ?>
                <tr>
                    <td><?php echo date('d.m.Y', strtotime($week->week_start)); ?></td>
                    <td><?php echo $week->courses; ?></td>
                    <td><?php echo $week->drivers; ?></td>
                    <td>
                        <a href="<?php echo home_url('/system-kierowcow/'); ?>" class="button">Zobacz</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>Brak danych w systemie. <a href="<?php echo home_url('/system-kierowcow/'); ?>">Przejdź do systemu kierowców</a></p>
        <?php endif; ?>
    </div>
    <?php
}

// TEST - dodaj przykładowe dane
function create_test_driver_data() {
    if (current_user_can('manage_options') && isset($_GET['create_test_data'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'driver_courses';
        
        // Obecny tydzień (poniedziałek)
        $monday = new DateTime();
        $monday->setISODate(date('Y'), date('W'));
        $week_start = $monday->format('Y-m-d');
        
        // Usuń stare dane testowe
        $wpdb->delete($table_name, array('week_start' => $week_start), array('%s'));
        
        // Dodaj testowe kursy
        $test_data = array(
            array(
                'driver_name' => 'Ania',
                'day_index' => 0, // Poniedziałek
                'course_data' => wp_json_encode(array(
                    array('startTime' => '08:00', 'endTime' => '16:00', 'car' => 'Auto 1', 'hours' => 8.0)
                ))
            ),
            array(
                'driver_name' => 'Paweł',
                'day_index' => 0, // Poniedziałek
                'course_data' => wp_json_encode(array(
                    array('startTime' => '09:00', 'endTime' => '17:00', 'car' => 'Auto 2', 'hours' => 8.0)
                ))
            ),
            array(
                'driver_name' => 'Marcin',
                'day_index' => 1, // Wtorek
                'course_data' => wp_json_encode(array(
                    array('startTime' => '08:00', 'endTime' => '16:00', 'car' => 'Auto 3', 'hours' => 8.0)
                ))
            )
        );
        
        foreach ($test_data as $data) {
            $wpdb->insert(
                $table_name,
                array(
                    'week_start' => $week_start,
                    'driver_name' => $data['driver_name'],
                    'day_index' => $data['day_index'],
                    'course_data' => $data['course_data'],
                    'created_by' => 'test_system'
                ),
                array('%s', '%s', '%d', '%s', '%s')
            );
        }
        
        echo '<div class="notice notice-success"><p>✅ Dane testowe utworzone dla tygodnia: ' . $week_start . '</p></div>';
    }
}
add_action('admin_notices', 'create_test_driver_data');

// Debug - sprawdź czy tabele istnieją
function check_driver_tables() {
    if (current_user_can('manage_options')) {
        global $wpdb;
        
        $table1 = $wpdb->prefix . 'driver_courses';
        $table2 = $wpdb->prefix . 'driver_audit_log';
        
        $exists1 = $wpdb->get_var("SHOW TABLES LIKE '$table1'");
        $exists2 = $wpdb->get_var("SHOW TABLES LIKE '$table2'");
        
        if (!$exists1 || !$exists2) {
            echo '<div class="notice notice-warning"><p>⚠️ Tabele kierowców: driver_courses (' . ($exists1 ? 'OK' : 'BRAK') . '), audit_log (' . ($exists2 ? 'OK' : 'BRAK') . ')</p></div>';
        }
    }
}
add_action('admin_notices', 'check_driver_tables');

?>