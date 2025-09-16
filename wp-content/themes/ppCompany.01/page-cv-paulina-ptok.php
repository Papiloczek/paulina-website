<?php
/**
 * Template Name: CV Paulina Ptok
 */

?>

<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CV - Paulina Ptok</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />

    <style>
      :root {
        --primary-color: #00ff9d;
        --secondary-color: #e74c3c;
        --dark-color: #2c3e50;
        --light-bg: #f8f9fa;
        --sidebar-bg: linear-gradient(145deg, #2c3e50, #34495e);
        --main-gradient: linear-gradient(135deg, #010809 0%, #1a1a1a 100%);
      }

      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        color: #333;
        background: var(--main-gradient);
        min-height: 100vh;
      }

      .back-to-portfolio {
        position: fixed;
        top: 20px;
        left: 20px;
        background: var(--primary-color);
        color: white;
        padding: 10px 20px;
        border-radius: 25px;
        text-decoration: none;
        z-index: 1002;
        font-weight: bold;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
      }

      .back-to-portfolio:hover {
        background: var(--secondary-color);
        transform: scale(1.05);
        color: white;
        text-decoration: none;
      }

      .print-controls {
        position: fixed;
        top: 20px;
        right: 20px;
        display: flex;
        gap: 10px;
        z-index: 999;
      }

      .btn {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
        font-weight: bold;
      }

      .btn:hover {
        background: var(--secondary-color);
        transform: translateY(-2px);
      }

      .cv-container {
        padding: 20px;
      }

      .container {
        max-width: 1000px;
        margin: 0 auto;
        background: white;
        border-radius: 15px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        display: flex;
        min-height: 800px;
      }

      .sidebar {
        width: 300px;
        flex-shrink: 0;
        background: var(--sidebar-bg);
        color: white;
        padding: 40px 30px;
      }

      .profile-img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        margin: 0 auto 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 4px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
        position: relative;
        /* Moja zjdecie  */
        background-image: url("https://ppindustry.pl/wp-content/uploads/2025/09/Paulina-scaled.jpg");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
      }

      .profile-initials {
        font-size: 60px;
        font-weight: bold;
        color: white;
        background: linear-gradient(
          45deg,
          var(--primary-color),
          var(--secondary-color)
        );
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        display: none; /* Pokaż gdy nie ma zdjęcia */
      }

      .contact-info {
        margin-bottom: 40px;
      }

      .contact-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        padding: 10px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        transition: all 0.3s ease;
      }

      .contact-item:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateX(5px);
      }

      .contact-icon {
        width: 20px;
        height: 20px;
        margin-right: 15px;
        background: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
      }

      .contact-icon i {
        color: white;
      }

      .contact-item a {
        color: white;
        text-decoration: none;
        transition: color 0.3s ease;
      }

      .contact-item a:hover {
        color: var(--primary-color);
        text-decoration: underline;
      }

      .social-links {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 40px;
        padding: 20px 0;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      }

      .social-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        color: white;
        text-decoration: none;
        font-size: 24px;
        transition: all 0.3s ease;
        border: 2px solid transparent;
      }

      .social-link:hover {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 255, 157, 0.4);
      }

      .sidebar h3 {
        color: var(--primary-color);
        margin-bottom: 20px;
        font-size: 18px;
        text-transform: uppercase;
        letter-spacing: 1px;
      }

      .skill-item {
        margin-bottom: 20px;
      }

      .skill-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
      }

      .skill-name {
        font-weight: 500;
      }

      .skill-name i {
        margin-right: 8px;
        width: 16px;
        text-align: center;
        color: var(--primary-color);
      }

      .skill-level {
        font-size: 0.9em;
        opacity: 0.8;
      }

      .skill-bar {
        height: 8px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 4px;
        overflow: hidden;
      }

      .skill-progress {
        height: 100%;
        background: linear-gradient(90deg, var(--primary-color), #2ecc71);
        border-radius: 4px;
        transition: width 2s ease;
      }

      .main-content {
        flex: 1;
        padding: 40px;
      }

      .header {
        margin-bottom: 40px;
        text-align: center;
        position: relative;
      }

      .name {
        font-size: 2.5em;
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 10px;
        background: linear-gradient(
          45deg,
          var(--primary-color),
          var(--secondary-color)
        );
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
      }

      .title {
        font-size: 1.3em;
        color: #7f8c8d;
        font-weight: 300;
      }

      .section {
        margin-bottom: 40px;
      }

      .section-title {
        font-size: 1.8em;
        color: var(--dark-color);
        padding-bottom: 10px;
        border-bottom: 3px solid var(--primary-color);
        position: relative;
        margin-bottom: 20px;
      }

      .section-title::after {
        content: "";
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 50px;
        height: 3px;
        background: var(--secondary-color);
      }

      .experience-item,
      .education-item {
        margin-bottom: 30px;
        padding: 25px;
        background: var(--light-bg);
        border-radius: 10px;
        border-left: 4px solid var(--primary-color);
        transition: all 0.3s ease;
      }

      .experience-item:hover,
      .education-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      }

      .job-title,
      .degree {
        font-size: 1.3em;
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 5px;
      }

      .company,
      .school {
        font-weight: 500;
        color: var(--primary-color);
        margin-bottom: 5px;
      }

      .date {
        color: #7f8c8d;
        font-size: 0.9em;
        margin-bottom: 15px;
      }

      .description {
        color: #555;
        line-height: 1.7;
      }

      .language-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding: 10px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
      }

      .level {
        font-size: 0.9em;
        opacity: 0.8;
      }

      .loading {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 20px 40px;
        border-radius: 10px;
        z-index: 9999;
        display: none;
      }

      /* Animacje pojawiania się */
      .fade-in {
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.8s ease forwards;
      }

      .fade-in:nth-child(1) {
        animation-delay: 0.1s;
      }
      .fade-in:nth-child(2) {
        animation-delay: 0.2s;
      }
      .fade-in:nth-child(3) {
        animation-delay: 0.3s;
      }
      .fade-in:nth-child(4) {
        animation-delay: 0.4s;
      }
      .fade-in:nth-child(5) {
        animation-delay: 0.5s;
      }
      .fade-in:nth-child(6) {
        animation-delay: 0.6s;
      }

      @keyframes fadeInUp {
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      .slide-in-left {
        opacity: 0;
        transform: translateX(-50px);
        animation: slideInLeft 1s ease forwards;
        animation-delay: 0.3s;
      }

      @keyframes slideInLeft {
        to {
          opacity: 1;
          transform: translateX(0);
        }
      }

      .slide-in-right {
        opacity: 0;
        transform: translateX(50px);
        animation: slideInRight 1s ease forwards;
        animation-delay: 0.5s;
      }

      @keyframes slideInRight {
        to {
          opacity: 1;
          transform: translateX(0);
        }
      }

      /* Media Queries */
      @media (max-width: 768px) {
        .cv-container {
          padding: 10px;
        }

        .container {
          flex-direction: column;
          margin: 0;
          border-radius: 0;
          min-height: 100vh;
        }

        .sidebar {
          width: 100%;
          text-align: center;
          padding: 30px 20px;
        }

        .main-content {
          padding: 30px 20px;
        }

        .name {
          font-size: 2em;
        }

        .back-to-portfolio {
          position: static;
          margin: 10px auto;
          display: inline-flex;
          width: fit-content;
        }

        .print-controls {
          position: static;
          margin: 10px auto;
          justify-content: center;
          width: fit-content;
        }

        .profile-img {
          width: 120px;
          height: 120px;
          margin-bottom: 20px;
        }

        .social-links {
          margin-bottom: 30px;
        }

        .social-link {
          width: 45px;
          height: 45px;
          font-size: 20px;
        }

        .section-title {
          font-size: 1.5em;
        }

        .job-title,
        .degree {
          font-size: 1.1em;
        }

        .experience-item,
        .education-item {
          padding: 20px;
        }

        .skill-item {
          margin-bottom: 15px;
        }

        .contact-item {
          padding: 8px;
          margin-bottom: 12px;
        }
      }

      @media (max-width: 480px) {
        .name {
          font-size: 1.8em;
        }

        .title {
          font-size: 1.1em;
        }

        .section-title {
          font-size: 1.3em;
        }

        .sidebar {
          padding: 20px 15px;
        }

        .main-content {
          padding: 20px 15px;
        }

        .social-links {
          gap: 15px;
        }
      }

      /* Print Styles */
      @media print {
        .print-controls,
        .back-to-portfolio {
          display: none !important;
        }

        body {
          background: white !important;
          padding: 0 !important;
          margin: 0 !important;
          -webkit-print-color-adjust: exact !important;
          color-adjust: exact !important;
        }

        .cv-container {
          padding: 0 !important;
          margin: 0 !important;
        }

        .container {
          box-shadow: none !important;
          max-width: none !important;
          margin: 0 !important;
          border-radius: 0 !important;
          min-height: auto !important;
          page-break-inside: avoid !important;
          display: flex !important;
          flex-direction: row !important;
        }

        .sidebar {
          width: 35% !important;
          flex-shrink: 0 !important;
          page-break-inside: avoid !important;
          background: #2c3e50 !important;
          color: white !important;
        }

        .main-content {
          width: 65% !important;
          flex: none !important;
          page-break-inside: avoid !important;
        }

        .section {
          page-break-inside: avoid !important;
        }

        .experience-item,
        .education-item {
          page-break-inside: avoid !important;
        }

        .profile-img {
          background: #00ff9d !important;
        }

        .skill-progress {
          background: #00ff9d !important;
        }
      }
    </style>
  </head>

  <body>
    <!-- Link powrotu do portfolio -->
    <a href="/moje-projekty/" class="back-to-portfolio">
      <svg
        width="16"
        height="16"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
      >
        <path d="M19 12H5M12 19l-7-7 7-7" />
      </svg>
      Portfolio
    </a>

    <div class="print-controls">
      <button class="btn" onclick="printCV()">
        <i class="fas fa-print"></i> Drukuj
      </button>
      <button class="btn" onclick="downloadJPG()">
        <i class="fas fa-download"></i> Pobierz JPG
      </button>
    </div>

    <div class="loading" id="loadingIndicator">Generowanie obrazu...</div>

    <div class="cv-container" id="cvContainer">
      <div class="container" id="cvElement">
        <div class="sidebar slide-in-left">
          <!-- ZDJĘCIE PROFILOWE -->
          <div class="profile-img"></div>

          <div class="contact-info">
            <div class="contact-item fade-in">
              <div class="contact-icon"><i class="fas fa-envelope"></i></div>
              <div>
                <a href="mailto:paulina@ppindustry.pl">paulina@ppindustry.pl</a>
              </div>
            </div>
            <div class="contact-item fade-in">
              <div class="contact-icon"><i class="fas fa-phone"></i></div>
              <div><a href="tel:+48510513039">+48 510 513 039</a></div>
            </div>
            <div class="contact-item fade-in">
              <div class="contact-icon">
                <i class="fas fa-map-marker-alt"></i>
              </div>
              <div>Zabrze, Polska</div>
            </div>
          </div>

          <div class="social-links">
            <a href="https://ppindustry.pl" target="_blank" class="social-link">
              <i class="fas fa-globe"></i>
            </a>

            <a
              href="https://linkedin.com/in/paulina-ptok-489a10204"
              target="_blank"
              class="social-link"
            >
              <i class="fab fa-linkedin"></i>
            </a>
            <a
              href="https://github.com/Papiloczek"
              target="_blank"
              class="social-link"
            >
              <i class="fab fa-github"></i>
            </a>
          </div>

          <h3>Umiejętności</h3>
          <div id="skillsList">
            <div class="skill-item fade-in">
              <div class="skill-header">
                <div class="skill-name">
                  <i class="fab fa-wordpress"></i> WordPress
                </div>
              </div>
              <div class="skill-bar">
                <div class="skill-progress" style="width: 70%"></div>
              </div>
            </div>
            <div class="skill-item fade-in">
              <div class="skill-header">
                <div class="skill-name">
                  <i class="fab fa-html5"></i> HTML/CSS
                </div>
              </div>
              <div class="skill-bar">
                <div class="skill-progress" style="width: 80%"></div>
              </div>
            </div>
            <div class="skill-item fade-in">
              <div class="skill-header">
                <div class="skill-name">
                  <i class="fab fa-js-square"></i> JavaScript
                </div>
              </div>
              <div class="skill-bar">
                <div class="skill-progress" style="width: 40%"></div>
              </div>
            </div>
            <div class="skill-item fade-in">
              <div class="skill-header">
                <div class="skill-name"><i class="fab fa-php"></i> PHP</div>
              </div>
              <div class="skill-bar">
                <div class="skill-progress" style="width: 30%"></div>
              </div>
            </div>
            <div class="skill-item fade-in">
              <div class="skill-header">
                <div class="skill-name"><i class="fas fa-search"></i> SEO</div>
              </div>
              <div class="skill-bar">
                <div class="skill-progress" style="width: 75%"></div>
              </div>
            </div>
            <div class="skill-item fade-in">
              <div class="skill-header">
                <div class="skill-name">
                  <i class="fas fa-database"></i> MySQL
                </div>
              </div>
              <div class="skill-bar">
                <div class="skill-progress" style="width: 60%"></div>
              </div>
            </div>
            <div class="skill-item fade-in">
              <div class="skill-header">
                <div class="skill-name">
                  <i class="fab fa-facebook"></i> Meta Ads
                </div>
              </div>
              <div class="skill-bar">
                <div class="skill-progress" style="width: 70%"></div>
              </div>
            </div>
          </div>

          <h3>Języki</h3>
          <div id="languagesList">
            <div class="language-item">
              <span><i class="fas fa-flag"></i> Angielski</span>
              <span class="level">B1</span>
            </div>
          </div>
        </div>

        <div class="main-content slide-in-right">
          <div class="header">
            <h1 class="name">Paulina Ptok</h1>
            <p class="title">Web Developer</p>
          </div>

          <div class="section fade-in">
            <h2 class="section-title">O mnie</h2>
            <p>
              Inżynier bezpieczeństwa w transformacji na Web Developera. Po 3
              latach nauki i praktyki rozwijam umiejętności w JavaScript, PHP,
              WordPress i optymalizacji SEO. Obecnie zarządzam kompleksowo
              stroną e-commerce, osiągając wymierne rezultaty w ruchu i
              konwersji. Łączę inżynierskie podejście z entuzjazmem do
              technologii webowych i chęcią dalszego rozwoju.
            </p>
          </div>

          <div class="section fade-in">
            <h2 class="section-title">Doświadczenie zawodowe</h2>

            <div class="experience-item fade-in">
              <div class="job-title">Web Developer</div>
              <div class="company">Firma Jubilerska Markiewicz</div>
              <div class="date">czerwiec 2023 - obecnie</div>
              <div class="description">
                Kompleksowo zarządzam stroną internetową firmy opartą na
                WordPress. Samodzielnie tworzę nowe treści i podstrony, wdrażam
                funkcjonalności oraz optymalizuję witrynę pod kątem SEO. Dbam o
                bezpieczeństwo i wydajność strony, a także prowadzę działania
                marketingowe - zarządzam reklamami Meta (Facebook/Instagram) i
                wykorzystuję media społecznościowe do kierowania ruchu na
                stronę. Cały proces prowadzę od A do Z, łącząc aspekty
                techniczne z marketingowymi.
              </div>
            </div>

            <div class="experience-item fade-in">
              <div class="job-title">Starszy Inspektor ds. BHP</div>
              <div class="company">Przedsiębiorstwo Konsultingowe AGM</div>
              <div class="date">czerwiec 2021 - luty 2022</div>
              <div class="description">
                Wdrażałam złożone przepisy BHP w praktykę organizacyjną, tworząc
                i aktualizując kompleksową dokumentację oraz procedury
                bezpieczeństwa. Prowadziłam audyty i kontrole zgodności z
                normami BHP. Analizowałam wypadki przy pracy, identyfikując
                przyczyny źródłowe i zlecając działania prewencyjne.
                Realizowałam szkolenia BHP dostosowane do specyfiki różnych
                stanowisk pracy oraz opracowywałam kompleksowe oceny ryzyka
                zawodowego.
              </div>
            </div>

            <div class="experience-item fade-in">
              <div class="job-title">Starszy referent techniczny</div>
              <div class="company">Bumar Łabędy S.A Zakłady mechaniczne</div>
              <div class="date">wrzesień 2018 - marzec 2020</div>
              <div class="description">
                Zarządzanie przepływem dokumentacji techniczno-konstrukcyjnej w
                firmie. Odpowiedzialność za prawidłowość, aktualność i
                archiwizację dokumentów oraz prowadzenie zakładowej bazy danych
                dokumentacji. Kontrola jakości dokumentacji konstrukcyjnej i
                wprowadzanie niezbędnych korekt.
              </div>
            </div>
          </div>

          <div class="section fade-in">
            <h2 class="section-title">Wykształcenie</h2>

            <div class="education-item">
              <div class="degree">
                Inżynieria aplikacji mobilnych i baz danych
              </div>
              <div class="school">Politechnika Śląska</div>
              <div class="date">2022 - 2023</div>
              <div class="description">
                Studia podyplomowe na Wydziale Automatyki, Elektroniki i
                Informatyki. Zdobycie praktycznej wiedzy z zakresu tworzenia
                aplikacji webowych i mobilnych, zarządzania bazami danych oraz
                nowoczesnych technologii programistycznych.
              </div>
            </div>

            <div class="education-item">
              <div class="degree">Magister, Bezpieczeństwo i higiena pracy</div>
              <div class="school">Politechnika Śląska</div>
              <div class="date">2020 - 2021</div>
              <div class="description">
                Studia magisterskie uzupełniające w zakresie bezpieczeństwa i
                higieny pracy. Pogłębienie wiedzy z zakresu zarządzania
                bezpieczeństwem w organizacji i przepisów prawnych.
              </div>
            </div>

            <div class="education-item">
              <div class="degree">Inżynier, Bezpieczeństwo i higiena pracy</div>
              <div class="school">Politechnika Śląska</div>
              <div class="date">2014 - 2018</div>
              <div class="description">
                Studia inżynierskie w zakresie bezpieczeństwa i higieny pracy.
                Podstawowe wykształcenie techniczne z zakresu inżynierii
                bezpieczeństwa, oceny ryzyka zawodowego i systemów zarządzania
                BHP.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
      // Print function
      function printCV() {
        window.print();
      }

      // Download as JPG
      function downloadJPG() {
        const loadingIndicator = document.getElementById("loadingIndicator");
        loadingIndicator.style.display = "block";

        setTimeout(() => {
          const element = document.getElementById("cvElement");

          const options = {
            scale: 2,
            useCORS: true,
            allowTaint: true,
            backgroundColor: "#ffffff",
            width: 1000,
            height: 1400,
            scrollX: 0,
            scrollY: 0,
          };

          html2canvas(element, options)
            .then((canvas) => {
              const link = document.createElement("a");
              link.download = "CV_Paulina_Ptok.jpg";
              const dataURL = canvas.toDataURL("image/jpeg", 0.95);
              link.href = dataURL;
              document.body.appendChild(link);
              link.click();
              document.body.removeChild(link);

              loadingIndicator.style.display = "none";
            })
            .catch((error) => {
              console.error("Error generating JPG:", error);
              alert("Wystąpił błąd podczas generowania JPG. Spróbuj ponownie.");
              loadingIndicator.style.display = "none";
            });
        }, 500);
      }

      // Skill bar animation on load
      window.addEventListener("load", function () {
        const skillBars = document.querySelectorAll(".skill-progress");
        skillBars.forEach((bar) => {
          const width = bar.style.width;
          bar.style.width = "0%";
          setTimeout(() => {
            bar.style.width = width;
          }, 500);
        });
      });
    </script>
  </body>
</html>
