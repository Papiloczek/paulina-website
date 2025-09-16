<?php
/*
Template Name: Strona Kontaktowa
*/

get_header(); ?>

<!-- Hero sekcja kontakt -->
<section class="contact-hero">
  <div class="container">
    <div class="contact-hero-content">
      <h1 class="contact-hero-title">Skontaktuj się ze mną</h1>
      <p class="contact-hero-description">
        Tworzysz coś w sieci i potrzebujesz wsparcia web developera?
        Chętnie pogadam o współpracy lub pomogę rozwiązać problem.
        Napisz do mnie - odpowiem na każdą wiadomość!
      </p>
      <div class="contact-stats">
        <div class="contact-stat-item">
          <span class="stat-icon">⚡</span>
          <span class="stat-text">Szybka odpowiedź</span>
        </div>
        <div class="contact-stat-item">
          <span class="stat-icon">🤝</span>
          <span class="stat-text">Profesjonalne doradztwo</span>
        </div>
        <div class="contact-stat-item">
          <span class="stat-icon">🔒</span>
          <span class="stat-text">Poufność gwarantowana</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Główna sekcja kontaktowa -->
<section class="contact-main">
  <div class="container">
    <div class="contact-content-wrapper">

      <!-- Formularz kontaktowy -->
      <div class="contact-form-section">
        <h2 class="section-title">Napisz do mnie</h2>

        <?php
        // Wyświetlanie komunikatów
        if (isset($_GET['message'])) {
          switch ($_GET['message']) {
            case 'success':
              echo '<div class="contact-message success">
                                    <span class="message-icon">✅</span>
                                    <span>Dziękuję! Twoja wiadomość została wysłana. Odpowiem najszybciej jak to możliwe.</span>
                                  </div>';
              break;
            case 'error':
              echo '<div class="contact-message error">
                                    <span class="message-icon">❌</span>
                                    <span>Wystąpił błąd podczas wysyłania wiadomości. Spróbuj ponownie.</span>
                                  </div>';
              break;
            case 'invalid':
              echo '<div class="contact-message error">
                                    <span class="message-icon">⚠️</span>
                                    <span>Proszę wypełnić wszystkie wymagane pola poprawnie.</span>
                                  </div>';
              break;
          }
        }
        ?>

        <form class="contact-form" method="post" action="<?php echo admin_url('admin-post.php'); ?>" id="contact-form">
          <input type="hidden" name="action" value="submit_contact_form">
          <?php wp_nonce_field('contact_form_nonce', 'contact_nonce'); ?>

          <div class="form-row">
            <div class="form-group">
              <label for="contact-name" class="form-label">
                Imię i nazwisko <span class="required">*</span>
              </label>
              <input type="text" id="contact-name" name="contact_name" class="form-input"
                placeholder="Jak mam się do Ciebie zwracać?" required
                value="<?php echo isset($_POST['contact_name']) ? esc_attr($_POST['contact_name']) : ''; ?>">
            </div>

            <div class="form-group">
              <label for="contact-email" class="form-label">
                Email <span class="required">*</span>
              </label>
              <input type="email" id="contact-email" name="contact_email" class="form-input"
                placeholder="twoj@email.com" required
                value="<?php echo isset($_POST['contact_email']) ? esc_attr($_POST['contact_email']) : ''; ?>">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="contact-company" class="form-label">
                Firma/Organizacja
              </label>
              <input type="text" id="contact-company" name="contact_company" class="form-input"
                placeholder="Nazwa firmy (opcjonalnie)"
                value="<?php echo isset($_POST['contact_company']) ? esc_attr($_POST['contact_company']) : ''; ?>">
            </div>

            <div class="form-group">
              <label for="contact-subject" class="form-label">
                Temat <span class="required">*</span>
              </label>
              <select id="contact-subject" name="contact_subject" class="form-select" required>
                <option value="">Wybierz temat</option>
                <option value="konsultacje">Konsultacje technologiczne</option>
                <option value="wspolpraca">Współpraca biznesowa</option>
                <option value="blog">Pytanie o artykuł z bloga</option>
                <option value="speaking">Wystąpienia/prezentacje</option>
                <option value="media">Współpraca medialna</option>
                <option value="inne">Inne</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="contact-message" class="form-label">
              Wiadomość <span class="required">*</span>
            </label>
            <textarea id="contact-message" name="contact_message" class="form-textarea" rows="6"
              placeholder="Opisz szczegółowo, w czym mogę Ci pomóc..."
              required><?php echo isset($_POST['contact_message']) ? esc_textarea($_POST['contact_message']) : ''; ?></textarea>
            <div class="character-count">
              <span id="char-count">0</span>/1000 znaków
            </div>
          </div>

          <div class="form-group checkbox-group">
            <label class="checkbox-label">
              <input type="checkbox" name="contact_privacy" value="1" required>
              <span class="checkmark"></span>
              Akceptuję <a href="/polityka-prywatnosci" target="_blank">politykę prywatności</a>
              i wyrażam zgodę na przetwarzanie danych osobowych <span class="required">*</span>
            </label>
          </div>

          <div class="form-group checkbox-group">
            <label class="checkbox-label">
              <input type="checkbox" name="contact_newsletter" value="1">
              <span class="checkmark"></span>
              Chcę otrzymywać newsletter z najnowszymi artykułami
            </label>
          </div>

          <div class="form-submit">
            <button type="submit" class="submit-btn" id="submit-btn">
              <span class="btn-text">Wyślij wiadomość</span>
              <span class="btn-icon">→</span>
              <div class="btn-loader" style="display: none;">
                <div class="spinner"></div>
              </div>
            </button>
            <p class="form-note">
              * Pola wymagane. Odpowiem w ciągu 24 godzin.
            </p>
          </div>
        </form>
      </div>

      <!-- Informacje kontaktowe -->
      <div class="contact-info-section">
        <h2 class="section-title">Inne sposoby kontaktu</h2>

        <div class="contact-methods">
          <div class="contact-method">
            <div class="method-icon">📧</div>
            <div class="method-content">
              <h3 class="method-title">Email</h3>
              <p class="method-description">Preferowany sposób kontaktu</p>
              <a href="mailto: paulina@ppindustry.pl" class="method-link">
                paulina@ppindustry.pl
              </a>
            </div>
          </div>

          <div class="contact-method">
            <div class="method-icon">💼</div>
            <div class="method-content">
              <h3 class="method-title">LinkedIn</h3>
              <p class="method-description">Połączmy się profesjonalnie</p>
              <a href="#" target="_blank" class="method-link">
                /in/paulina
              </a>
            </div>
          </div>

          <div class="contact-method">
            <div class="method-icon">📱</div>
            <div class="method-content">
              <h3 class="method-title">Telefon</h3>
              <p class="method-description">W nagłych przypadkach</p>
              <a href="tel:+48123456789" class="method-link">
                +48
              </a>
            </div>
          </div>
        </div>

        <!-- FAQ szybkie odpowiedzi -->
        <div class="contact-faq">
          <h3 class="faq-title">Częste pytania</h3>
          <div class="faq-items">
            <div class="faq-item">
              <div class="faq-question">
                <span class="faq-icon">💡</span>
                <span>Jak długo trwa odpowiedź?</span>
              </div>
              <div class="faq-answer">
                Staram się odpowiadać w ciągu 24 godzin, w dni robocze zwykle szybciej.
              </div>
            </div>

            <div class="faq-item">
              <div class="faq-question">
                <span class="faq-icon">🤝</span>
                <span>Czy oferujesz konsultacje?</span>
              </div>
              <div class="faq-answer">
                Tak, konsultuję w zakresie projektowania i optymalizacji stron internetowych, wdrażania WordPressa,
                poprawy użyteczności (UX) oraz strategii SEO. Pomagam także w analizie i rozwoju obecnych projektów.
              </div>
            </div>

            <div class="faq-item">
              <div class="faq-question">
                <span class="faq-icon">🎤</span>
                <span>Czy prowadzisz szkolenia?</span>
              </div>
              <div class="faq-answer">
                Nie.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Sekcja newsletter -->
<section class="blog-newsletter">
  <div class="container">
    <div class="newsletter-content">
      <h2 class="newsletter-title">Zapisz się do newslettera</h2>
      <p class="newsletter-description">
        Otrzymuj praktyczne porady i artykuły o nowoczesnych rozwiązaniach w web developmencie i cyfrowym marketingu
        prosto na swoją skrzynkę.
      </p>
      <form class="newsletter-form" method="post" action="<?php echo admin_url('admin-post.php'); ?>">
        <input type="hidden" name="action" value="newsletter_signup">
        <?php wp_nonce_field('newsletter_signup', 'newsletter_nonce'); ?>
        <input type="email" class="newsletter-email" placeholder="Twój adres email" name="newsletter_email" required>
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