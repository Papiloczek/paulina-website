window.onload = function () {
  let codeElement = document.getElementById("code");
  let terminal = document.getElementById("terminal");
  let cursor = document.querySelector(".cursor");
  let executeBtn = document.getElementById("execute-btn");
  let finalTextElement = document.getElementById("final-text");
  let enterWebsiteBtn = document.getElementById("enter-website");
  let loadingEl = document.getElementById("loading");
  let loadingBarEl = document.getElementById("loading-bar");
  let loadingGlowEl = document.getElementById("loading-glow");
  let progressTextEl = document.getElementById("progress-text");
  let skipButton = document.getElementById("skip-button");

  // Nowy format kodu w jednym string
  const codeText = `<span class="prompt">$</span> <span class="command-line">python launch_creative_strategy.py</span>

<span class="comment"># Initializing creative framework...</span>
<span class="keyword">import</span> <span class="variable">innovation</span>
<span class="keyword">from</span> <span class="function">strategy</span> <span class="keyword">import</span> <span class="variable">creativity</span>

<span class="keyword">def</span> <span class="function">launch_creative_engine</span>():
    <span class="comment"># Initialize digital strategy components</span>
    <span class="variable">tools</span> = [<span class="string">"Research"</span>, <span class="string">"Strategy"</span>, <span class="string">"AI"</span>, <span class="string">"Development"</span>]
    <span class="variable">engine</span> = <span class="function">CreativeEngine</span>(power=<span class="number">100</span>)
    <span class="keyword">return</span> <span class="variable">engine</span>.<span class="function">activate</span>(<span class="variable">tools</span>)

<span class="prompt">$</span> <span class="function">execute_strategy</span>() {
    <span class="variable">status</span>: <span class="string">"ready"</span>,
    <span class="variable">mode</span>: <span class="string">"creative"</span>
}`;

  let highlightLine = document.createElement("div");
  highlightLine.className = "highlight-line";
  terminal.appendChild(highlightLine);

  // Add floating particles
  function createParticles() {
    for (let i = 0; i < 10; i++) {
      let particle = document.createElement("div");
      particle.className = "particle";
      particle.style.left = Math.random() * 600 + "px";
      particle.style.top = Math.random() * 200 + 50 + "px";
      particle.style.animationDelay = Math.random() * 5 + "s";
      terminal.appendChild(particle);
    }
  }

  createParticles();

  // Skip intro and go directly to enter button
  skipButton.addEventListener("click", function () {
    // Hide all animation elements
    document.querySelectorAll(".icon").forEach((icon) => {
      icon.style.opacity = "0";
    });

    executeBtn.style.display = "none";
    skipButton.style.display = "none";
    loadingEl.style.display = "none";
    progressTextEl.style.display = "none";
    cursor.style.display = "none";
    highlightLine.style.opacity = "0";

    // Show enter website button immediately
    showEnterButton();
  });

  // Display skip button after a short delay
  setTimeout(() => {
    skipButton.style.display = "block";
  }, 1500);

  // Apply a subtle 3D tilt effect to the terminal
  terminal.addEventListener("mousemove", function (e) {
    const xAxis = (window.innerWidth / 2 - e.pageX) / 30;
    const yAxis = (window.innerHeight / 2 - e.pageY) / 30;
    terminal.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
  });

  terminal.addEventListener("mouseleave", function () {
    terminal.style.transform = "rotateY(0deg) rotateX(0deg)";
  });

  // Typewriter effect dla nowego formatu z inteligentnym auto-scroll
  let i = 0;
  const speed = window.innerWidth <= 768 ? 30 : 50; // Szybsze na mobile

  function typeWriter() {
    if (i < codeText.length) {
      codeElement.innerHTML = codeText.slice(0, i + 1);

      // Auto-scroll tylko gdy kod jest wystarczająco długi
      const terminalContent = document.querySelector(".terminal-content");
      if (terminalContent) {
        const contentHeight = codeElement.scrollHeight;
        const containerHeight = terminalContent.clientHeight;

        // Scroll tylko gdy zawartość przekracza wysokość kontenera
        if (contentHeight > containerHeight) {
          // Sprawdź czy jesteśmy w dolnej części - scroll tylko wtedy
          const currentScroll = terminalContent.scrollTop;
          const maxScroll =
            terminalContent.scrollHeight - terminalContent.clientHeight;

          // Scroll tylko gdy jesteśmy blisko dołu (ostatnie 50px) lub na początku
          if (currentScroll === 0 || maxScroll - currentScroll < 50) {
            terminalContent.scrollTop = terminalContent.scrollHeight;
          }
        }
      }

      i++;
      setTimeout(typeWriter, speed);
    } else {
      // After typing is done, show execute button
      cursor.style.display = "none";
      highlightLine.style.opacity = "0";

      setTimeout(function () {
        executeBtn.classList.remove("hidden");
        // Add button reveal animation
        executeBtn.style.animation = "fadeIn 0.5s forwards";
      }, 800);
    }
  }

  // Handle execute button click
  executeBtn.addEventListener("click", function () {
    executeBtn.disabled = true;
    executeBtn.style.opacity = 0.6;
    executeBtn.style.transform = "scale(0.95)";

    showIconsSequentially();

    // Show loading bar with glow effect
    loadingEl.style.display = "block";
    progressTextEl.style.display = "block";

    // Animate loading bar
    setTimeout(() => {
      loadingBarEl.style.width = "100%";
      loadingGlowEl.style.opacity = "1";

      // Update progress text during loading
      const progressMessages = [
        "Initializing resources...",
        "Connecting strategy modules...",
        "Optimizing creative assets...",
        "Preparing experience...",
      ];

      let msgIndex = 0;
      const progressInterval = setInterval(() => {
        msgIndex = (msgIndex + 1) % progressMessages.length;
        progressTextEl.textContent = progressMessages[msgIndex];
      }, 800);

      // Clear interval after loading completes
      setTimeout(() => {
        clearInterval(progressInterval);
      }, 3000);
    }, 100);
  });

  // Show icons one after another with enhanced transitions
  function showIconsSequentially() {
    const icons = [
      document.getElementById("icon-1"),
      document.getElementById("icon-2"),
      document.getElementById("icon-3"),
      document.getElementById("icon-4"),
    ];

    // Show and hide each icon one after another with scaling animation
    icons.forEach((icon, i) => {
      // Show icon
      setTimeout(() => {
        icon.style.opacity = "1";
        icon.style.transform = "scale(1)";

        // Hide icon after a delay
        setTimeout(() => {
          icon.style.opacity = "0";
          icon.style.transform = "scale(0.9)";

          // After the last icon disappears, show final text
          if (i === icons.length - 1) {
            setTimeout(() => {
              finalTextElement.classList.remove("hidden");
              finalTextElement.style.opacity = 1;
              finalTextElement.style.transform = "translateY(0)";

              // After final text, show enter website button
              setTimeout(showEnterButton, 1500);
            }, 400);
          }
        }, 900);
      }, i * 1100);
    });
  }

  function showEnterButton() {
    enterWebsiteBtn.style.display = "block";
    setTimeout(() => {
      enterWebsiteBtn.style.opacity = 1;
      enterWebsiteBtn.style.transform = "translateY(0)";
    }, 100);
  }

  // Start typing effect after a brief delay
  setTimeout(() => {
    // Aktywuj smooth scroll na początku pisania
    const terminalContent = document.querySelector(".terminal-content");
    if (terminalContent) {
      terminalContent.classList.add("typing");
    }
    typeWriter();
  }, 700);
};

// document.addEventListener("DOMContentLoaded", function () {
//   // Dodaj obsługę przycisku Enter Website
//   const enterWebsiteBtn = document.getElementById("enter-website");
//   if (enterWebsiteBtn) {
//     enterWebsiteBtn.addEventListener("click", function () {
//       window.location.href = "/"; // Przekierowanie do strony głównej
//     });
//   }
// });


// czy dziala z google 
document.addEventListener("DOMContentLoaded", function () {
  const enterWebsiteBtn = document.getElementById("enter-website");
  const overlay = document.getElementById("loading-screen-overlay");
  
  if (enterWebsiteBtn && overlay) {
    enterWebsiteBtn.addEventListener("click", function(e) {
      e.preventDefault();
      
      // Poczekaj na Google Tag
      setTimeout(function() {
        overlay.classList.add("fade-out");
        
        setTimeout(function() {
          overlay.style.display = "none";
          document.body.classList.add("content-visible");
        }, 500);
      }, 100);
    });
  }
});