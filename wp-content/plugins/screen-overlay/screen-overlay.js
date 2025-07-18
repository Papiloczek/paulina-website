/**
 * Loading Screen Overlay Pro
 * v3.1 by ppIndustry
 */

document.addEventListener("DOMContentLoaded", function () {
  const overlay = document.getElementById("loading-overlay");
  if (!overlay) return;

  // Pobierz ustawienia z WordPress
  const settings = window.loadingOverlaySettings || {
    animation: "slide-from-corner",
    delay: 500,
    homeUrl: "/",
  };

  // Pokaż overlay z opóźnieniem
  setTimeout(function () {
    showOverlay();
  }, settings.delay);

  function showOverlay() {
    overlay.classList.remove("hidden");
    overlay.classList.add(settings.animation);

    // Trigger animację
    setTimeout(function () {
      overlay.classList.add("show");
    }, 50);

    // Rozpocznij typewriter effect
    setTimeout(function () {
      startTypewriter();
    }, 800);

    // Pokaż Skip button po 6 sekundach
    setTimeout(function () {
      const skipButton = document.getElementById("skip-overlay");
      if (skipButton) {
        skipButton.style.display = "block";
        skipButton.style.opacity = "1";
        skipButton.style.transform = "translateY(0)";
      }
    }, 6000);
  }

  function startTypewriter() {
    const codeElement = document.getElementById("code-overlay");
    const cursor = document.querySelector(".cursor");
    const executeBtn = document.getElementById("execute-btn-overlay");
    const terminal = document.getElementById("terminal-overlay");

    const codeText = `<span class="prompt">$</span> <span class="command-line">python launch_creative_strategy.py</span>

<span class="comment"># Launching digital innovation engine...</span>
<span class="keyword">import</span> <span class="variable">creativity</span>, <span class="variable">strategy</span>, <span class="variable">ai_power</span>

<span class="keyword">def</span> <span class="function">initialize</span>():
    <span class="variable">stack</span> = [<span class="string">"Research"</span>, <span class="string">"AI"</span>, <span class="string">"Development"</span>]
    <span class="keyword">return</span> <span class="function">Engine</span>(power=<span class="number">100</span>).<span class="function">activate</span>(<span class="variable">stack</span>)

<span class="prompt">$</span> <span class="function">run</span>() → <span class="string">"SUCCESS"</span>
<span class="prompt">$</span> Status: <span class="variable">READY</span> ✓`;


    let i = 0;
    const speed = window.innerWidth <= 768 ? 30 : 50;

    // Dodaj efekty ze starej wersji
    let highlightLine = document.createElement("div");
    highlightLine.className = "highlight-line";
    if (terminal) {
      terminal.appendChild(highlightLine);
    }

    // Dodaj floating particles
    createParticles();

    // Dodaj 3D tilt effect
    if (terminal) {
      terminal.addEventListener("mousemove", function (e) {
        const rect = terminal.getBoundingClientRect();
        const xAxis = (rect.width / 2 - (e.clientX - rect.left)) / 30;
        const yAxis = (rect.height / 2 - (e.clientY - rect.top)) / 30;
        terminal.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
      });

      terminal.addEventListener("mouseleave", function () {
        terminal.style.transform = "rotateY(0deg) rotateX(0deg)";
      });
    }

    function typeWriter() {
      if (i < codeText.length) {
        codeElement.innerHTML = codeText.slice(0, i + 1);

        // Auto-scroll z ulepszoną logiką
        const terminalContent = document.querySelector(".terminal-content");
        if (terminalContent) {
          const shouldScroll =
            terminalContent.scrollHeight > terminalContent.clientHeight;

          if (shouldScroll) {
            requestAnimationFrame(() => {
              terminalContent.scrollTop = terminalContent.scrollHeight;
            });
          }
        }

        i++;
        setTimeout(typeWriter, speed);
      } else {
        // Ukryj cursor i highlight line
        cursor.style.display = "none";
        if (highlightLine) {
          highlightLine.style.opacity = "0";
        }

        setTimeout(function () {
          executeBtn.classList.remove("hidden");
          executeBtn.style.animation = "fadeIn 0.5s forwards";
        }, 800);
      }
    }

    typeWriter();
  }

  // Funkcja tworzenia particles
  function createParticles() {
    const terminal = document.getElementById("terminal-overlay");
    if (!terminal) return;

    for (let i = 0; i < 10; i++) {
      let particle = document.createElement("div");
      particle.className = "particle";
      particle.style.left = Math.random() * 600 + "px";
      particle.style.top = Math.random() * 200 + 50 + "px";
      particle.style.animationDelay = Math.random() * 5 + "s";
      terminal.appendChild(particle);
    }
  }

  // Obsługa przycisku Execute
  document
    .getElementById("execute-btn-overlay")
    .addEventListener("click", function () {
      this.disabled = true;
      this.style.opacity = "0.6";
      this.style.transform = "scale(0.95)";
      showIconsSequentially();
    });

  // Obsługa Skip - natychmiastowe przejście
  document
    .getElementById("skip-overlay")
    .addEventListener("click", function () {
      // Ukryj wszystkie animacje
      document.querySelectorAll(".icon").forEach((icon) => {
        icon.style.opacity = "0";
      });

      const executeBtn = document.getElementById("execute-btn-overlay");
      const loadingBar = document.getElementById("loading-overlay-bar");
      const progressText = document.getElementById("progress-text-overlay");
      const cursor = document.querySelector(".cursor");
      const highlightLine = document.querySelector(".highlight-line");

      if (executeBtn) executeBtn.style.display = "none";
      if (loadingBar) loadingBar.style.display = "none";
      if (progressText) progressText.style.display = "none";
      if (cursor) cursor.style.display = "none";
      if (highlightLine) highlightLine.style.opacity = "0";

      // Pokaż final text natychmiast
      const finalText = document.getElementById("final-text-overlay");
      if (finalText) {
        finalText.classList.remove("hidden");
        finalText.style.opacity = "1";
        finalText.style.transform = "translateY(0)";
      }

      showCloseButton();
    });

  function showIconsSequentially() {
    const icons = [
      document.getElementById("icon-1-overlay"),
      document.getElementById("icon-2-overlay"),
      document.getElementById("icon-3-overlay"),
      document.getElementById("icon-4-overlay"),
    ];

    const loadingBar = document.getElementById("loading-overlay-bar");
    const progressText = document.getElementById("progress-text-overlay");
    const finalText = document.getElementById("final-text-overlay");

    // Pokaż loading bar
    loadingBar.style.display = "block";
    progressText.style.display = "block";

    // Animuj loading bar z glow effect
    setTimeout(function () {
      const loadingBarFill = loadingBar.querySelector(".loading-bar-fill");
      const loadingGlow = loadingBar.querySelector(".loading-glow");

      if (loadingBarFill) loadingBarFill.style.width = "100%";
      if (loadingGlow) loadingGlow.style.opacity = "1";
    }, 100);

    // Pokaż ikony sekwencyjnie
    icons.forEach((icon, i) => {
      setTimeout(() => {
        if (icon) {
          icon.style.opacity = "1";
          icon.style.transform = "scale(1)";

          // Ukryj ikonę po chwili
          setTimeout(() => {
            icon.style.opacity = "0";
            icon.style.transform = "scale(0.9)";

            // Po ostatniej ikonie pokaż final text
            if (i === icons.length - 1) {
              setTimeout(() => {
                finalText.classList.remove("hidden");
                finalText.style.opacity = "1";
                finalText.style.transform = "translateY(0)";

                // Pokaż przyciski
                setTimeout(showCloseButton, 1500);
              }, 400);
            }
          }, 900);
        }
      }, i * 1100);
    });

    // Animuj progress text
    const progressMessages = [
      "Initializing resources...",
      "Connecting strategy modules...",
      "Optimizing creative assets...",
      "Preparing experience...",
    ];

    let msgIndex = 0;
    const progressInterval = setInterval(() => {
      msgIndex = (msgIndex + 1) % progressMessages.length;
      if (progressText) {
        progressText.textContent = progressMessages[msgIndex];
      }
    }, 800);

    setTimeout(() => {
      clearInterval(progressInterval);
    }, 4000);
  }

  function showCloseButton() {
    // Pokaż główny przycisk Enter Website
    const enterWebsiteBtn = document.getElementById("enter-website-overlay");
    if (enterWebsiteBtn) {
      enterWebsiteBtn.style.display = "block";
      setTimeout(() => {
        enterWebsiteBtn.style.opacity = "1";
        enterWebsiteBtn.style.transform = "translateY(0)";
      }, 100);
    }

    // Pokaż przycisk Close po zakończeniu animacji
    const closeBtn = document.getElementById("close-overlay");
    if (closeBtn) {
      closeBtn.style.display = "block";
      setTimeout(() => {
        closeBtn.style.opacity = "1";
        closeBtn.style.transform = "translateY(0)";
      }, 200);
    }
  }

  // Funkcja zamknięcia overlay
  function closeOverlay() {
    overlay.classList.add("closing");

    // Google Tag delay + fade out
    setTimeout(function () {
      setTimeout(function () {
        overlay.style.display = "none";
        document.body.classList.add("content-visible");

        // Ustaw cookie żeby nie pokazywać ponownie
        document.cookie = "loading_overlay_seen=1; path=/; max-age=3600";
      }, 500);
    }, 100);
  }

  // Event listenery dla przycisków
  const closeOverlayBtn = document.getElementById("close-overlay");
  const enterWebsiteBtn = document.getElementById("enter-website-overlay");
  const overlayBackground = document.querySelector(".overlay-background");

  if (closeOverlayBtn) {
    closeOverlayBtn.addEventListener("click", closeOverlay);
  }

  if (enterWebsiteBtn) {
    enterWebsiteBtn.addEventListener("click", closeOverlay);
  }

  if (overlayBackground) {
    overlayBackground.addEventListener("click", closeOverlay);
  }

  // Zamknij overlay po naciśnięciu ESC
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
      closeOverlay();
    }
  });
});
