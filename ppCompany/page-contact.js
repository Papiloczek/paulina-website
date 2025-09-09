document.addEventListener("DOMContentLoaded", function () {
  const contactForm = document.getElementById("contact-form");
  const submitBtn = document.getElementById("submit-btn");
  const messageTextarea = document.getElementById("contact-message");
  const charCount = document.getElementById("char-count");

  // Licznik znaków w textarea
  if (messageTextarea && charCount) {
    function updateCharCount() {
      const currentLength = messageTextarea.value.length;
      const maxLength = 1000;

      charCount.textContent = currentLength;

      // Zmiana koloru gdy zbliżamy się do limitu
      if (currentLength > maxLength * 0.9) {
        charCount.style.color = "var(--error-color)";
      } else if (currentLength > maxLength * 0.8) {
        charCount.style.color = "var(--warning-color)";
      } else {
        charCount.style.color = "var(--text-color-dim)";
      }

      // Blokada gdy przekroczono limit
      if (currentLength > maxLength) {
        messageTextarea.value = messageTextarea.value.substring(0, maxLength);
        charCount.textContent = maxLength;
      }
    }

    messageTextarea.addEventListener("input", updateCharCount);
    messageTextarea.addEventListener("keyup", updateCharCount);

    // Inicjalne liczenie
    updateCharCount();
  }

  // Walidacja formularza w czasie rzeczywistym
  const formInputs = document.querySelectorAll(
    ".form-input, .form-select, .form-textarea"
  );

  formInputs.forEach((input) => {
    input.addEventListener("blur", function () {
      validateField(this);
    });

    input.addEventListener("input", function () {
      // Usuń błąd gdy użytkownik zaczyna pisać
      clearFieldError(this);
    });
  });

  function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.name;
    let isValid = true;
    let errorMessage = "";

    // Walidacja wymaganych pól
    if (field.hasAttribute("required") && !value) {
      isValid = false;
      errorMessage = "To pole jest wymagane";
    }

    // Walidacja email
    if (fieldName === "contact_email" && value) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(value)) {
        isValid = false;
        errorMessage = "Podaj prawidłowy adres email";
      }
    }

    // Walidacja długości wiadomości
    if (fieldName === "contact_message" && value && value.length < 10) {
      isValid = false;
      errorMessage = "Wiadomość powinna mieć co najmniej 10 znaków";
    }

    if (!isValid) {
      showFieldError(field, errorMessage);
    } else {
      clearFieldError(field);
    }

    return isValid;
  }

  function showFieldError(field, message) {
    clearFieldError(field);

    field.style.borderColor = "var(--error-color)";
    field.style.backgroundColor = "rgba(255, 71, 87, 0.1)";

    const errorDiv = document.createElement("div");
    errorDiv.className = "field-error";
    errorDiv.style.cssText = `
            color: var(--error-color);
            font-size: 0.8rem;
            margin-top: 0.3rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        `;
    errorDiv.innerHTML = `<span>⚠️</span><span>${message}</span>`;

    field.parentNode.appendChild(errorDiv);
  }

  function clearFieldError(field) {
    field.style.borderColor = "";
    field.style.backgroundColor = "";

    const existingError = field.parentNode.querySelector(".field-error");
    if (existingError) {
      existingError.remove();
    }
  }

  // Obsługa wysyłania formularza
  if (contactForm) {
    contactForm.addEventListener("submit", function (e) {
      e.preventDefault();

      // Walidacja wszystkich pól
      let isFormValid = true;
      formInputs.forEach((input) => {
        if (!validateField(input)) {
          isFormValid = false;
        }
      });

      // Sprawdzenie checkboxa prywatności
      const privacyCheckbox = document.querySelector(
        'input[name="contact_privacy"]'
      );
      if (!privacyCheckbox.checked) {
        isFormValid = false;
        showNotification("Musisz zaakceptować politykę prywatności", "error");
      }

      if (!isFormValid) {
        showNotification("Proszę poprawić błędy w formularzu", "error");
        return;
      }

      // Wyślij formularz
      submitForm();
    });
  }

  function submitForm() {
    // Zmień stan przycisku
    submitBtn.classList.add("loading");
    submitBtn.disabled = true;

    // Symulacja wysyłania (zastąp prawdziwym AJAX jeśli potrzebne)
    setTimeout(() => {
      // Tutaj normalnie byłby AJAX lub pozwól formularza na naturalne wysłanie
      contactForm.submit();
    }, 1000);
  }

  // System powiadomień
  function showNotification(message, type = "info") {
    // Usuń istniejące powiadomienia
    const existingNotifications = document.querySelectorAll(".notification");
    existingNotifications.forEach((notification) => notification.remove());

    const notification = document.createElement("div");
    notification.className = `notification notification-${type}`;

    const icons = {
      success: "✅",
      error: "❌",
      warning: "⚠️",
      info: "ℹ️",
    };

    notification.innerHTML = `
            <div class="notification-content">
                <span class="notification-icon">${
                  icons[type] || icons.info
                }</span>
                <span class="notification-message">${message}</span>
                <button class="notification-close" onclick="this.parentElement.parentElement.remove()">×</button>
            </div>
        `;

    notification.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 10000;
            max-width: 400px;
            background: var(--background-card);
            border: 1px solid var(--accent-color);
            border-radius: 8px;
            padding: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transform: translateX(100%);
            transition: transform 0.3s ease;
        `;

    const notificationContent = notification.querySelector(
      ".notification-content"
    );
    notificationContent.style.cssText = `
            display: flex;
            align-items: center;
            gap: 0.8rem;
            color: var(--text-color);
        `;

    const closeBtn = notification.querySelector(".notification-close");
    closeBtn.style.cssText = `
            background: none;
            border: none;
            color: var(--text-color-dim);
            cursor: pointer;
            font-size: 1.2rem;
            margin-left: auto;
        `;

    document.body.appendChild(notification);

    // Animacja wejścia
    setTimeout(() => {
      notification.style.transform = "translateX(0)";
    }, 100);

    // Automatyczne usunięcie po 5 sekundach
    setTimeout(() => {
      if (notification.parentNode) {
        notification.style.transform = "translateX(100%)";
        setTimeout(() => {
          if (notification.parentNode) {
            notification.remove();
          }
        }, 300);
      }
    }, 5000);
  }

  // Animacja elementów przy scrollu
  const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
  };

  const observer = new IntersectionObserver(function (entries) {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = "1";
        entry.target.style.transform = "translateY(0)";
      }
    });
  }, observerOptions);

  // Obserwuj elementy do animacji
  const animatedElements = document.querySelectorAll(
    ".contact-method, .faq-item, .contact-form, .contact-info-section"
  );
  animatedElements.forEach((element, index) => {
    element.style.opacity = "0";
    element.style.transform = "translateY(30px)";
    element.style.transition = `opacity 0.6s ease ${
      index * 0.1
    }s, transform 0.6s ease ${index * 0.1}s`;
    observer.observe(element);
  });

  // Smooth scroll dla linków kotwicznych
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute("href"));
      if (target) {
        target.scrollIntoView({
          behavior: "smooth",
          block: "start",
        });
      }
    });
  });

  // Auto-resize textarea
  if (messageTextarea) {
    messageTextarea.addEventListener("input", function () {
      this.style.height = "auto";
      this.style.height = Math.min(this.scrollHeight, 200) + "px";
    });
  }

  // Efekt pisania w placeholderze (opcjonalnie)
  const inputs = document.querySelectorAll(".form-input[placeholder]");
  inputs.forEach((input) => {
    const originalPlaceholder = input.placeholder;

    input.addEventListener("focus", function () {
      if (this.value === "") {
        typewriterEffect(this, originalPlaceholder);
      }
    });

    input.addEventListener("blur", function () {
      this.placeholder = originalPlaceholder;
    });
  });

  function typewriterEffect(element, text) {
    element.placeholder = "";
    let i = 0;

    function typeChar() {
      if (i < text.length && document.activeElement === element) {
        element.placeholder += text.charAt(i);
        i++;
        setTimeout(typeChar, 50);
      }
    }

    typeChar();
  }

  // Inicjalizacja tooltipów (jeśli są)
  const tooltipTriggers = document.querySelectorAll("[data-tooltip]");
  tooltipTriggers.forEach((trigger) => {
    trigger.addEventListener("mouseenter", showTooltip);
    trigger.addEventListener("mouseleave", hideTooltip);
  });

  function showTooltip(e) {
    const text = e.target.getAttribute("data-tooltip");
    // Implementacja tooltipa...
  }

  function hideTooltip(e) {
    // Usunięcie tooltipa...
  }

  console.log("Strona kontaktowa załadowana pomyślnie! 🚀");
});

<button id="scroll-to-top" aria-label="Przewiń na górę">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="18 15 12 9 6 15"></polyline>
    </svg>
</button>
