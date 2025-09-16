<?php
/**
 * Template for CV Generator Page
 * Filename: page-cv-generator.php
 */

// Wyłącz domyślne style WordPress dla tej strony
remove_action('wp_head', 'wp_print_styles', 8);
remove_action('wp_head', 'wp_print_head_scripts', 9);

// Własny header bez standardowych stylów
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Generator - <?php bloginfo('name'); ?></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <!-- Dodaj link powrotu do portfolio -->
    <style>
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

        /* Tu będą wszystkie style z CV */
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: var(--main-gradient);
            min-height: 100vh;
        }

        /* Panel Admina */
        .admin-panel {
            position: fixed;
            top: 0;
            right: -350px;
            width: 350px;
            height: 100vh;
            background: white;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.2);
            transition: right 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }

        .admin-panel.open {
            right: 0;
        }

        .admin-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 25px;
            cursor: pointer;
            z-index: 1001;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .admin-toggle:hover {
            background: var(--secondary-color);
            transform: scale(1.05);
        }

        .admin-content {
            padding: 20px;
        }

        .admin-section {
            margin-bottom: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }

        .admin-section h3 {
            color: var(--dark-color);
            margin-bottom: 15px;
            font-size: 1.2em;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: var(--dark-color);
        }

        .input-group input,
        .input-group textarea,
        .input-group select {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .input-group input:focus,
        .input-group textarea:focus,
        .input-group select:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .color-picker {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .color-option {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            border: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .color-option.active {
            border-color: #333;
            transform: scale(1.1);
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
            margin: 5px;
        }

        .btn:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }

        .btn-danger {
            background: var(--secondary-color);
        }

        .btn-success {
            background: #27ae60;
        }

        /* Kontrolki drukowania */
        .print-controls {
            position: fixed;
            top: 80px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            z-index: 999;
        }

        /* CV Container */
        .cv-container {
            padding: 20px;
            transition: margin-right 0.3s ease;
        }

        .cv-container.admin-open {
            margin-right: 350px;
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
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            margin: 0 auto 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
            font-weight: bold;
            color: white;
            border: 4px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            cursor: pointer;
            position: relative;
        }

        .profile-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .profile-upload {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            font-size: 14px;
            text-align: center;
        }

        .profile-img:hover .profile-upload {
            opacity: 1;
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

        .sidebar h3 {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .skill-item {
            margin-bottom: 20px;
            position: relative;
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

        .skill-delete {
            background: var(--secondary-color);
            color: white;
            border: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 12px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .skill-item:hover .skill-delete {
            opacity: 1;
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
            transition: width 1s ease;
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
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
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
            position: relative;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 1.8em;
            color: var(--dark-color);
            padding-bottom: 10px;
            border-bottom: 3px solid var(--primary-color);
            position: relative;
            flex-grow: 1;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--secondary-color);
        }

        .section-delete {
            background: var(--secondary-color);
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .section:hover .section-delete {
            opacity: 1;
        }

        .experience-item,
        .education-item {
            margin-bottom: 30px;
            padding: 25px;
            background: var(--light-bg);
            border-radius: 10px;
            border-left: 4px solid var(--primary-color);
            transition: all 0.3s ease;
            position: relative;
        }

        .experience-item:hover,
        .education-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .item-delete {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--secondary-color);
            color: white;
            border: none;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 12px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .experience-item:hover .item-delete,
        .education-item:hover .item-delete {
            opacity: 1;
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
            position: relative;
        }

        .language-delete {
            background: var(--secondary-color);
            color: white;
            border: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 12px;
            opacity: 0;
            transition: opacity 0.3s ease;
            position: absolute;
            right: 5px;
        }

        .language-item:hover .language-delete {
            opacity: 1;
        }

        .level {
            font-size: 0.9em;
            opacity: 0.8;
        }

        /* Media Queries */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                margin: 10px;
            }

            .sidebar {
                width: 100%;
                text-align: center;
            }

            .main-content {
                padding: 30px 20px;
            }

            .name {
                font-size: 2em;
            }

            .admin-panel {
                width: 100%;
                right: -100%;
            }

            .cv-container.admin-open {
                margin-right: 0;
            }

            .back-to-portfolio {
                position: relative;
                top: auto;
                left: auto;
                margin: 20px;
                display: inline-flex;
            }
        }

        /* Print Styles */
        @media print {

            .admin-panel,
            .admin-toggle,
            .print-controls,
            .skill-delete,
            .section-delete,
            .item-delete,
            .language-delete,
            .profile-upload,
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

        .editable {
            border: 2px dashed transparent;
            transition: border-color 0.3s ease;
            cursor: pointer;
        }

        .editable:hover {
            border-color: var(--primary-color);
        }

        .editing {
            border-color: var(--secondary-color);
        }

        /* Loading indicator */
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
    </style>
</head>

<body>
    <!-- Link powrotu do portfolio -->
    <a href="<?php echo home_url('/moje-projekty/'); ?>" class="back-to-portfolio">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7" />
        </svg>
        Portfolio
    </a>

    <button class="admin-toggle" onclick="toggleAdmin()">⚙️ Panel</button>

    <div class="print-controls">
        <button class="btn" onclick="printCV()">🖨️ Drukuj</button>
        <button class="btn" onclick="downloadPDF()">📄 PDF</button>
        <button class="btn" onclick="downloadJPG()">🖼️ JPG</button>
    </div>

    <div class="loading" id="loadingIndicator">
        Generowanie obrazu...
    </div>

    <!-- panel admina -->
    <div class="admin-panel" id="adminPanel">
        <div class="admin-content">
            <h2>Panel Administracyjny</h2>

            <div class="admin-section">
                <h3>Kolory motywu</h3>
                <div class="input-group">
                    <label>Kolor główny:</label>
                    <div class="color-picker" id="primaryColors">
                        <div class="color-option active" style="background: #00ff9d"
                            onclick="changeColor('primary', '#00ff9d')"></div>
                        <div class="color-option" style="background: #e74c3c"
                            onclick="changeColor('primary', '#e74c3c')"></div>
                        <div class="color-option" style="background: #2ecc71"
                            onclick="changeColor('primary', '#2ecc71')"></div>
                        <div class="color-option" style="background: #f39c12"
                            onclick="changeColor('primary', '#f39c12')"></div>
                        <div class="color-option" style="background: #9b59b6"
                            onclick="changeColor('primary', '#9b59b6')"></div>
                        <div class="color-option" style="background: #1abc9c"
                            onclick="changeColor('primary', '#1abc9c')"></div>
                    </div>
                </div>

                <div class="input-group">
                    <label>Kolor akcentu:</label>
                    <div class="color-picker" id="secondaryColors">
                        <div class="color-option" style="background: #3498db"
                            onclick="changeColor('secondary', '#3498db')"></div>
                        <div class="color-option active" style="background: #e74c3c"
                            onclick="changeColor('secondary', '#e74c3c')"></div>
                        <div class="color-option" style="background: #2ecc71"
                            onclick="changeColor('secondary', '#2ecc71')"></div>
                        <div class="color-option" style="background: #f39c12"
                            onclick="changeColor('secondary', '#f39c12')"></div>
                        <div class="color-option" style="background: #9b59b6"
                            onclick="changeColor('secondary', '#9b59b6')"></div>
                        <div class="color-option" style="background: #1abc9c"
                            onclick="changeColor('secondary', '#1abc9c')"></div>
                    </div>
                </div>
            </div>

            <div class="admin-section">
                <h3>Dane osobowe</h3>
                <div class="input-group">
                    <label>Imię i nazwisko:</label>
                    <input type="text" id="fullName" value="Jan Kowalski" onchange="updatePersonalData()">
                </div>
                <div class="input-group">
                    <label>Stanowisko:</label>
                    <input type="text" id="jobTitle" value="Frontend Developer & UI/UX Designer"
                        onchange="updatePersonalData()">
                </div>
                <div class="input-group">
                    <label>Email:</label>
                    <input type="email" id="email" value="jan.kowalski@email.com" onchange="updatePersonalData()">
                </div>
                <div class="input-group">
                    <label>Telefon:</label>
                    <input type="tel" id="phone" value="+48 123 456 789" onchange="updatePersonalData()">
                </div>
                <div class="input-group">
                    <label>Lokalizacja:</label>
                    <input type="text" id="location" value="Warszawa, Polska" onchange="updatePersonalData()">
                </div>
                <div class="input-group">
                    <label>LinkedIn:</label>
                    <input type="text" id="linkedin" value="linkedin.com/in/jankowalski"
                        onchange="updatePersonalData()">
                </div>
            </div>

            <div class="admin-section">
                <h3>Umiejętności</h3>
                <div id="skillsAdmin"></div>
                <div class="input-group">
                    <label>Nowa umiejętność:</label>
                    <input type="text" id="newSkillName" placeholder="Nazwa umiejętności">
                    <input type="range" id="newSkillLevel" min="0" max="100" value="50">
                    <span id="skillLevelDisplay">50%</span>
                    <button class="btn" onclick="addSkill()">Dodaj</button>
                </div>
            </div>

            <div class="admin-section">
                <h3>Języki</h3>
                <div id="languagesAdmin"></div>
                <div class="input-group">
                    <label>Nowy język:</label>
                    <input type="text" id="newLanguageName" placeholder="Nazwa języka">
                    <select id="newLanguageLevel">
                        <option value="A1">A1</option>
                        <option value="A2">A2</option>
                        <option value="B1">B1</option>
                        <option value="B2">B2</option>
                        <option value="C1">C1</option>
                        <option value="C2">C2</option>
                        <option value="Ojczysty">Ojczysty</option>
                    </select>
                    <button class="btn" onclick="addLanguage()">Dodaj</button>
                </div>
            </div>

            <div class="admin-section">
                <h3>Doświadczenie</h3>
                <button class="btn btn-success" onclick="addExperience()">+ Dodaj doświadczenie</button>
            </div>

            <div class="admin-section">
                <h3>Wykształcenie</h3>
                <button class="btn btn-success" onclick="addEducation()">+ Dodaj wykształcenie</button>
            </div>

            <div class="admin-section">
                <h3>Sekcje</h3>
                <button class="btn btn-success" onclick="addSection()">+ Dodaj sekcję</button>
            </div>
        </div>
    </div>
    <!-- strona -->
    <div class="cv-container" id="cvContainer">
        <div class="container" id="cvElement">
            <div class="sidebar">
                <div class="profile-img" onclick="document.getElementById('photoInput').click()">
                    <span id="profileInitials">JK</span>
                    <div class="profile-upload">
                        <div>Kliknij aby<br>dodać zdjęcie</div>
                    </div>
                </div>
                <input type="file" id="photoInput" accept="image/*" style="display: none;"
                    onchange="uploadPhoto(event)">

                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-icon">📧</div>
                        <div id="contactEmail">jan.kowalski@email.com</div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">📱</div>
                        <div id="contactPhone">+48 123 456 789</div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">📍</div>
                        <div id="contactLocation">Warszawa, Polska</div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">💼</div>
                        <div id="contactLinkedin">linkedin.com/in/jankowalski</div>
                    </div>
                </div>

                <h3>Umiejętności</h3>
                <div id="skillsList">
                    <div class="skill-item">
                        <div class="skill-header">
                            <div class="skill-name">JavaScript</div>
                            <button class="skill-delete" onclick="removeSkill(this)">×</button>
                        </div>
                        <div class="skill-bar">
                            <div class="skill-progress" style="width: 90%"></div>
                        </div>
                    </div>
                    <div class="skill-item">
                        <div class="skill-header">
                            <div class="skill-name">HTML/CSS</div>
                            <button class="skill-delete" onclick="removeSkill(this)">×</button>
                        </div>
                        <div class="skill-bar">
                            <div class="skill-progress" style="width: 95%"></div>
                        </div>
                    </div>
                    <div class="skill-item">
                        <div class="skill-header">
                            <div class="skill-name">React</div>
                            <button class="skill-delete" onclick="removeSkill(this)">×</button>
                        </div>
                        <div class="skill-bar">
                            <div class="skill-progress" style="width: 85%"></div>
                        </div>
                    </div>
                </div>

                <h3>Języki</h3>
                <div id="languagesList">
                    <div class="language-item">
                        <span>Polski</span>
                        <span class="level">Ojczysty</span>
                        <button class="language-delete" onclick="removeLanguage(this)">×</button>
                    </div>
                    <div class="language-item">
                        <span>Angielski</span>
                        <span class="level">B2</span>
                        <button class="language-delete" onclick="removeLanguage(this)">×</button>
                    </div>
                </div>
            </div>

            <div class="main-content">
                <div class="header">
                    <h1 class="name editable" onclick="makeEditable(this)" id="displayName">Jan Kowalski</h1>
                    <p class="title editable" onclick="makeEditable(this)" id="displayTitle">Frontend Developer & UI/UX
                        Designer</p>
                </div>

                <div class="section">
                    <div class="section-header">
                        <h2 class="section-title editable" onclick="makeEditable(this)">O mnie</h2>
                        <button class="section-delete" onclick="removeSection(this)">× Usuń sekcję</button>
                    </div>
                    <p class="editable" onclick="makeEditable(this)">Pasjonat technologii z 5-letnim doświadczeniem w
                        tworzeniu nowoczesnych aplikacji webowych. Specjalizuję się w JavaScript, React i designie user
                        experience. Lubię pracować w zespole i rozwiązywać złożone problemy techniczne. Zawsze otwarty
                        na nowe wyzwania i ciągłe doskonalenie swoich umiejętności.</p>
                </div>

                <div class="section">
                    <div class="section-header">
                        <h2 class="section-title">Doświadczenie zawodowe</h2>
                        <button class="section-delete" onclick="removeSection(this)">× Usuń sekcję</button>
                    </div>

                    <div id="experienceList">
                        <div class="experience-item">
                            <button class="item-delete" onclick="removeExperienceItem(this)">×</button>
                            <div class="job-title editable" onclick="makeEditable(this)">Senior Frontend Developer</div>
                            <div class="company editable" onclick="makeEditable(this)">TechCorp Sp. z o.o.</div>
                            <div class="date editable" onclick="makeEditable(this)">Styczeń 2022 - obecnie</div>
                            <div class="description editable" onclick="makeEditable(this)">
                                Odpowiedzialny za rozwój i utrzymanie aplikacji webowych dla klientów korporacyjnych.
                                Tworzenie responsywnych interfejsów użytkownika w React.js. Współpraca z zespołem UX/UI
                                nad optymalizacją user experience.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section">
                    <div class="section-header">
                        <h2 class="section-title">Wykształcenie</h2>
                        <button class="section-delete" onclick="removeSection(this)">× Usuń sekcję</button>
                    </div>

                    <div id="educationList">
                        <div class="education-item">
                            <button class="item-delete" onclick="removeEducationItem(this)">×</button>
                            <div class="degree editable" onclick="makeEditable(this)">Magister Informatyki</div>
                            <div class="school editable" onclick="makeEditable(this)">Politechnika Warszawska</div>
                            <div class="date editable" onclick="makeEditable(this)">2017 - 2019</div>
                            <div class="description editable" onclick="makeEditable(this)">
                                Specjalizacja: Inżynieria Oprogramowania. Praca magisterska: "Optymalizacja wydajności
                                aplikacji webowych w środowisku React".
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentEditingElement = null;
        let skills = [];
        let languages = [];

        // Toggle admin panel
        function toggleAdmin() {
            const panel = document.getElementById('adminPanel');
            const container = document.getElementById('cvContainer');
            panel.classList.toggle('open');
            container.classList.toggle('admin-open');
        }

        // Color management
        function changeColor(type, color) {
            document.documentElement.style.setProperty(`--${type}-color`, color);

            // Update active color
            const colorPickers = document.querySelectorAll(`#${type}Colors .color-option`);
            colorPickers.forEach(picker => picker.classList.remove('active'));
            event.target.classList.add('active');
        }

        // Personal data updates
        function updatePersonalData() {
            document.getElementById('displayName').textContent = document.getElementById('fullName').value;
            document.getElementById('displayTitle').textContent = document.getElementById('jobTitle').value;
            document.getElementById('contactEmail').textContent = document.getElementById('email').value;
            document.getElementById('contactPhone').textContent = document.getElementById('phone').value;
            document.getElementById('contactLocation').textContent = document.getElementById('location').value;
            document.getElementById('contactLinkedin').textContent = document.getElementById('linkedin').value;

            // Update initials
            const fullName = document.getElementById('fullName').value;
            const initials = fullName.split(' ').map(name => name.charAt(0)).join('').toUpperCase();
            document.getElementById('profileInitials').textContent = initials;
        }

        // Photo upload
        function uploadPhoto(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const profileImg = document.querySelector('.profile-img');
                    profileImg.innerHTML = `
                        <img src="${e.target.result}" alt="Profile Photo">
                        <div class="profile-upload">
                            <div>Kliknij aby<br>zmienić zdjęcie</div>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            }
        }

        // Skills management
        function addSkill() {
            const name = document.getElementById('newSkillName').value.trim();
            const level = document.getElementById('newSkillLevel').value;

            if (name) {
                const skillsList = document.getElementById('skillsList');
                const skillDiv = document.createElement('div');
                skillDiv.className = 'skill-item';
                skillDiv.innerHTML = `
                    <div class="skill-header">
                        <div class="skill-name">${name}</div>
                        <button class="skill-delete" onclick="removeSkill(this)">×</button>
                    </div>
                    <div class="skill-bar">
                        <div class="skill-progress" style="width: ${level}%"></div>
                    </div>
                `;
                skillsList.appendChild(skillDiv);

                document.getElementById('newSkillName').value = '';
                document.getElementById('newSkillLevel').value = 50;
                document.getElementById('skillLevelDisplay').textContent = '50%';
            }
        }

        function removeSkill(button) {
            button.closest('.skill-item').remove();
        }

        // Languages management
        function addLanguage() {
            const name = document.getElementById('newLanguageName').value.trim();
            const level = document.getElementById('newLanguageLevel').value;

            if (name) {
                const languagesList = document.getElementById('languagesList');
                const languageDiv = document.createElement('div');
                languageDiv.className = 'language-item';
                languageDiv.innerHTML = `
                    <span>${name}</span>
                    <span class="level">${level}</span>
                    <button class="language-delete" onclick="removeLanguage(this)">×</button>
                `;
                languagesList.appendChild(languageDiv);

                document.getElementById('newLanguageName').value = '';
                document.getElementById('newLanguageLevel').selectedIndex = 0;
            }
        }

        function removeLanguage(button) {
            button.closest('.language-item').remove();
        }

        // Experience management
        function addExperience() {
            const experienceList = document.getElementById('experienceList');
            const experienceDiv = document.createElement('div');
            experienceDiv.className = 'experience-item';
            experienceDiv.innerHTML = `
                <button class="item-delete" onclick="removeExperienceItem(this)">×</button>
                <div class="job-title editable" onclick="makeEditable(this)">Nowe stanowisko</div>
                <div class="company editable" onclick="makeEditable(this)">Nazwa firmy</div>
                <div class="date editable" onclick="makeEditable(this)">Data rozpoczęcia - Data zakończenia</div>
                <div class="description editable" onclick="makeEditable(this)">
                    Opis obowiązków i osiągnięć w tej roli...
                </div>
            `;
            experienceList.appendChild(experienceDiv);
        }

        function removeExperienceItem(button) {
            button.closest('.experience-item').remove();
        }

        // Education management
        function addEducation() {
            const educationList = document.getElementById('educationList');
            const educationDiv = document.createElement('div');
            educationDiv.className = 'education-item';
            educationDiv.innerHTML = `
                <button class="item-delete" onclick="removeEducationItem(this)">×</button>
                <div class="degree editable" onclick="makeEditable(this)">Tytuł/Stopień naukowy</div>
                <div class="school editable" onclick="makeEditable(this)">Nazwa uczelni</div>
                <div class="date editable" onclick="makeEditable(this)">Data rozpoczęcia - Data zakończenia</div>
                <div class="description editable" onclick="makeEditable(this)">
                    Opis kierunku studiów, specjalizacji, ważnych projektów...
                </div>
            `;
            educationList.appendChild(educationDiv);
        }

        function removeEducationItem(button) {
            button.closest('.education-item').remove();
        }

        // Section management
        function addSection() {
            const sectionTitle = prompt('Podaj nazwę nowej sekcji:');
            if (sectionTitle) {
                const mainContent = document.querySelector('.main-content');
                const sectionDiv = document.createElement('div');
                sectionDiv.className = 'section';
                sectionDiv.innerHTML = `
                    <div class="section-header">
                        <h2 class="section-title editable" onclick="makeEditable(this)">${sectionTitle}</h2>
                        <button class="section-delete" onclick="removeSection(this)">× Usuń sekcję</button>
                    </div>
                    <p class="editable" onclick="makeEditable(this)">Kliknij tutaj, aby dodać treść sekcji...</p>
                `;
                mainContent.appendChild(sectionDiv);
            }
        }

        function removeSection(button) {
            if (confirm('Czy na pewno chcesz usunąć tę sekcję?')) {
                button.closest('.section').remove();
            }
        }

        // Editable content
        function makeEditable(element) {
            if (currentEditingElement && currentEditingElement !== element) {
                finishEditing(currentEditingElement);
            }

            currentEditingElement = element;
            element.classList.add('editing');

            const originalText = element.textContent;
            const isMultiline = element.tagName === 'P' || element.classList.contains('description');

            if (isMultiline) {
                const textarea = document.createElement('textarea');
                textarea.value = originalText;
                textarea.style.width = '100%';
                textarea.style.minHeight = '100px';
                textarea.style.padding = '10px';
                textarea.style.border = '2px solid var(--primary-color)';
                textarea.style.borderRadius = '5px';
                textarea.style.fontSize = getComputedStyle(element).fontSize;
                textarea.style.fontFamily = getComputedStyle(element).fontFamily;
                textarea.style.resize = 'vertical';

                element.innerHTML = '';
                element.appendChild(textarea);
                textarea.focus();

                textarea.addEventListener('blur', () => finishEditing(element));
                textarea.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        element.textContent = originalText;
                        finishEditing(element);
                    }
                });
            } else {
                const input = document.createElement('input');
                input.type = 'text';
                input.value = originalText;
                input.style.width = '100%';
                input.style.padding = '5px';
                input.style.border = '2px solid var(--primary-color)';
                input.style.borderRadius = '5px';
                input.style.fontSize = getComputedStyle(element).fontSize;
                input.style.fontFamily = getComputedStyle(element).fontFamily;
                input.style.fontWeight = getComputedStyle(element).fontWeight;

                element.innerHTML = '';
                element.appendChild(input);
                input.focus();
                input.select();

                input.addEventListener('blur', () => finishEditing(element));
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter') {
                        finishEditing(element);
                    } else if (e.key === 'Escape') {
                        element.textContent = originalText;
                        finishEditing(element);
                    }
                });
            }
        }

        function finishEditing(element) {
            if (!element) return;

            const input = element.querySelector('input, textarea');
            if (input) {
                element.textContent = input.value;
            }

            element.classList.remove('editing');
            currentEditingElement = null;
        }

        // Print and export functions
        function printCV() {
            const panel = document.getElementById('adminPanel');
            const container = document.getElementById('cvContainer');
            const wasOpen = panel.classList.contains('open');

            if (wasOpen) {
                panel.classList.remove('open');
                container.classList.remove('admin-open');
            }

            setTimeout(() => {
                window.print();

                if (wasOpen) {
                    panel.classList.add('open');
                    container.classList.add('admin-open');
                }
            }, 100);
        }

        function downloadPDF() {
            printCV();
        }

        function downloadJPG() {
            const loadingIndicator = document.getElementById('loadingIndicator');
            const panel = document.getElementById('adminPanel');
            const container = document.getElementById('cvContainer');
            const wasOpen = panel.classList.contains('open');

            if (wasOpen) {
                panel.classList.remove('open');
                container.classList.remove('admin-open');
            }

            loadingIndicator.style.display = 'block';

            setTimeout(() => {
                const element = document.getElementById('cvElement');

                const options = {
                    scale: 2,
                    useCORS: true,
                    allowTaint: true,
                    backgroundColor: '#ffffff',
                    width: 1000,
                    height: 1400,
                    scrollX: 0,
                    scrollY: 0
                };

                html2canvas(element, options).then(canvas => {
                    const link = document.createElement('a');
                    link.download = `CV_${document.getElementById('fullName').value.replace(/\s+/g, '_')}.jpg`;
                    const dataURL = canvas.toDataURL('image/jpeg', 0.95);
                    link.href = dataURL;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                    loadingIndicator.style.display = 'none';

                    if (wasOpen) {
                        panel.classList.add('open');
                        container.classList.add('admin-open');
                    }
                }).catch(error => {
                    console.error('Error generating JPG:', error);
                    alert('Wystąpił błąd podczas generowania JPG. Spróbuj ponownie.');
                    loadingIndicator.style.display = 'none';

                    if (wasOpen) {
                        panel.classList.add('open');
                        container.classList.add('admin-open');
                    }
                });
            }, 500);
        }

        // Event listeners
        document.getElementById('newSkillLevel').addEventListener('input', function () {
            document.getElementById('skillLevelDisplay').textContent = this.value + '%';
        });

        window.addEventListener('load', function () {
            const skillBars = document.querySelectorAll('.skill-progress');
            skillBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 500);
            });
        });

        document.addEventListener('click', function (e) {
            if (currentEditingElement && !currentEditingElement.contains(e.target) && !e.target.classList.contains('editable')) {
                finishEditing(currentEditingElement);
            }
        });
    </script>
</body>

</html>