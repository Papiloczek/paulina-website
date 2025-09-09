document.addEventListener("DOMContentLoaded", () => {
  const words = document.querySelectorAll(
    ".main_page_description_w .word, .main_page_description_w .word1, .main_page_description_w .word2"
  );

  // Sprawdź czy słowa istnieją przed użyciem
  if (words.length > 0) {
    // Ustawiamy początkowo, żeby tylko pierwsze słowo było widoczne
    words[0].classList.add("active");

    window.addEventListener("scroll", () => {
      const triggerHeight = window.innerHeight * 0.2; // Moment, kiedy słowo staje się widoczne

      words.forEach((word, index) => {
        // Kiedy przewiniemy wystarczająco dużo, kolejne słowo się pojawia
        if (
          window.scrollY > index * triggerHeight &&
          window.scrollY < (index + 1) * triggerHeight
        ) {
          word.classList.add("active");
        } else {
          word.classList.remove("active");
        }
      });
    });
  }

  // Menu items - jedna deklaracja z sprawdzeniem
  const menuItems = document.querySelectorAll("nav ul li");

  if (menuItems.length > 0) {
    menuItems.forEach((item) => {
      item.addEventListener("click", function (e) {
        const subMenu = this.querySelector(".sub-menu");

        if (subMenu) {
          // Ukrywamy inne podmenu
          document.querySelectorAll(".sub-menu").forEach((menu) => {
            if (menu !== subMenu) {
              menu.classList.remove("active");
            }
          });
          // Toggle (przełączenie) widoczności bieżącego podmenu
          subMenu.classList.toggle("active");

          e.stopPropagation();
        }
      });
    });
  }

  // Mobile menu items
  const mobileMenuItems = document.querySelectorAll(
    ".fullscreen-menu .menu-item-has-children > a"
  );

  if (mobileMenuItems.length > 0) {
    mobileMenuItems.forEach((item) => {
      item.addEventListener("click", function (e) {
        e.preventDefault();
        this.parentNode.classList.toggle("open");
      });
    });
  }

  // Kursor animacja - sprawdź czy element istnieje
  const cursor = document.querySelector(".custom-cursor");

  if (cursor) {
    document.addEventListener("mousemove", (e) => {
      cursor.style.left = `${e.clientX}px`;
      cursor.style.top = `${e.clientY}px`;
    });

    // Najechanie na element
    document.querySelectorAll("a, button, .interactive").forEach((element) => {
      element.addEventListener("mouseenter", () => {
        cursor.classList.add("cursor-hover");
      });

      element.addEventListener("mouseleave", () => {
        cursor.classList.remove("cursor-hover");
      });
    });
  }

  // Scroll to top - sprawdź czy przycisk istnieje
  const scrollToTopBtn = document.getElementById("scroll-to-top");

  if (scrollToTopBtn) {
    window.addEventListener("scroll", function () {
      if (window.pageYOffset > 300) {
        scrollToTopBtn.classList.add("visible");
      } else {
        scrollToTopBtn.classList.remove("visible");
      }
    });

    scrollToTopBtn.addEventListener("click", function (event) {
      // nie klika w linki
      event.preventDefault();
      event.stopPropagation();

      window.scrollTo({
        top: 0,
        behavior: "smooth",
      });
    });
  }

  // Dodatkowy scroll button
  const scrollBtn = document.getElementById("scrollTop");
  if (scrollBtn) {
    scrollBtn.addEventListener("click", () => {
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }

  // Animacje - inicjalizacja
  initAnimations();
  initSmoothScroll();
  initializeMainAnimations();
});

// Funkcja toggle fullscreen menu
function toggleFullScreenMenu() {
  const menu = document.querySelector(".fullscreen-menu");
  const body = document.body;

  if (menu) {
    // Przełączanie widoczności menu pełnoekranowego
    menu.classList.toggle("active");

    // Ukrywanie / pokazywanie głównej zawartości strony
    if (menu.classList.contains("active")) {
      body.classList.add("fullscreen-active");
    } else {
      body.classList.remove("fullscreen-active");
    }
  }
}

// Animacja front page
function initAnimations() {
  const animateElements = document.querySelectorAll(
    ".intro-text, .fade-left, .fade-right, .scale-up, .stagger-item"
  );

  if (animateElements.length > 0) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("animate");
          }
        });
      },
      {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px",
      }
    );

    animateElements.forEach((el) => observer.observe(el));
  }
}

// Smooth scroll dla linków
function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      const target = document.querySelector(link.getAttribute("href"));
      if (target) {
        target.scrollIntoView({ behavior: "smooth" });
      }
    });
  });
}

// Główna funkcja animacji sekcji about me i blog
function initializeMainAnimations() {
  // Intersection Observer do obsługi animacji przy scrollowaniu
  const observerOptions = {
    threshold: 0.15,
    rootMargin: "0px 0px -50px 0px",
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("animate");
      }
    });
  }, observerOptions);

  // Funkcja do dodawania klas animacji tylko do sekcji "about-me" i niżej
  function initializeAnimations() {
    // Sprawdź czy sekcja about-me istnieje
    const aboutSection = document.querySelector("#about-me");
    if (!aboutSection) return;

    // Dodaj floating elements do sekcji about-me
    if (!aboutSection.querySelector(".floating-elements")) {
      const floatingContainer = document.createElement("div");
      floatingContainer.className = "floating-elements";

      for (let i = 0; i < 5; i++) {
        const element = document.createElement("div");
        element.className = "floating-element";
        floatingContainer.appendChild(element);
      }

      aboutSection.appendChild(floatingContainer);
    }

    // SEKCJA ABOUT-ME - dodaj klasy animacji
    const aboutTitle = aboutSection.querySelector(".heading-large, h2");
    if (aboutTitle && !aboutTitle.classList.contains("animate-on-scroll")) {
      aboutTitle.classList.add("animate-on-scroll", "fade-in-up");
    }

    const profileImage = aboutSection.querySelector(".profile-image");
    if (profileImage && !profileImage.classList.contains("animate-on-scroll")) {
      profileImage.classList.add("animate-on-scroll", "fade-in-left");
      profileImage.style.transitionDelay = "0.2s";
    }

    const introText = aboutSection.querySelector(".intro-text");
    if (introText && !introText.classList.contains("animate-on-scroll")) {
      introText.classList.add("animate-on-scroll", "fade-in-right");
      introText.style.transitionDelay = "0.3s";
    }

    const subheadings = aboutSection.querySelectorAll(".subheading");
    subheadings.forEach((heading, index) => {
      if (!heading.classList.contains("animate-on-scroll")) {
        heading.classList.add("animate-on-scroll", "fade-in-up");
        heading.style.transitionDelay = `${0.4 + index * 0.5}s`;
      }
    });

    const skillsItems = aboutSection.querySelectorAll(".skills-list li");
    skillsItems.forEach((item, index) => {
      if (!item.classList.contains("animate-on-scroll")) {
        item.classList.add("animate-on-scroll", "stagger-item");
        item.style.transitionDelay = `${0.5 + index * 0.1}s`;
      }
    });

    const experienceText = aboutSection.querySelector(
      ".text-content > p:last-of-type"
    );
    if (
      experienceText &&
      !experienceText.classList.contains("animate-on-scroll")
    ) {
      experienceText.classList.add("animate-on-scroll", "fade-in-up");
      experienceText.style.transitionDelay = "1s";
    }

    const ctaContainer = aboutSection.querySelector(".cta-container");
    if (ctaContainer && !ctaContainer.classList.contains("animate-on-scroll")) {
      ctaContainer.classList.add("animate-on-scroll", "fade-in-scale");
      ctaContainer.style.transitionDelay = "1.1s";
    }

    // SEKCJA BLOG - dodaj klasy animacji
    const blogSection = document.querySelector("#blog");
    if (blogSection) {
      const blogTitle = blogSection.querySelector(".article");
      if (blogTitle && !blogTitle.classList.contains("animate-on-scroll")) {
        blogTitle.classList.add("animate-on-scroll", "fade-in-up");
      }

      const postItems = blogSection.querySelectorAll(".last_post_item_w");
      postItems.forEach((item, index) => {
        if (!item.classList.contains("animate-on-scroll")) {
          item.classList.add("animate-on-scroll");
          item.style.transitionDelay = `${0.2 + index * 0.2}s`;
        }
      });
    }

    // SEKCJA NEWSLETTER (jeśli istnieje)
    const newsletterSection = document.querySelector(".blog-newsletter");
    if (newsletterSection) {
      const newsletterContent = newsletterSection.querySelector(
        ".newsletter-content"
      );
      if (
        newsletterContent &&
        !newsletterContent.classList.contains("animate-on-scroll")
      ) {
        newsletterContent.classList.add("animate-on-scroll", "fade-in-scale");
      }
    }

    // INNE SEKCJE PO ABOUT-ME
    const sectionsAfterAbout = document.querySelectorAll("#about-me ~ section");
    sectionsAfterAbout.forEach((section) => {
      const headings = section.querySelectorAll("h2, h3, h4");
      headings.forEach((heading) => {
        if (!heading.classList.contains("animate-on-scroll")) {
          heading.classList.add("animate-on-scroll", "fade-in-up");
        }
      });

      const paragraphs = section.querySelectorAll("p");
      paragraphs.forEach((p, index) => {
        if (!p.classList.contains("animate-on-scroll")) {
          p.classList.add("animate-on-scroll", "fade-in-up");
          p.style.transitionDelay = `${index * 0.1}s`;
        }
      });
    });
  }

  // Zainicjalizuj animacje
  initializeAnimations();

  // Obserwuj wszystkie elementy z klasą animate-on-scroll
  document.querySelectorAll(".animate-on-scroll").forEach((el) => {
    observer.observe(el);
  });

  // Parallax efekt dla floating elements (tylko w sekcji about-me)
  let ticking = false;

  function updateParallax() {
    const scrolled = window.pageYOffset;
    const parallaxElements = document.querySelectorAll(
      "#about-me .floating-element"
    );

    parallaxElements.forEach((element, index) => {
      const speed = 0.3 + index * 0.1;
      const yPos = -(scrolled * speed);
      const rotation = scrolled * 0.05 * (index + 1);

      element.style.transform = `translateY(${yPos}px) rotate(${rotation}deg)`;
    });

    ticking = false;
  }

  function requestParallaxUpdate() {
    if (!ticking) {
      requestAnimationFrame(updateParallax);
      ticking = true;
    }
  }

  // Performance optimization - tylko na desktop
  function handleResize() {
    const isMobile = window.innerWidth <= 768;

    if (isMobile) {
      window.removeEventListener("scroll", requestParallaxUpdate);
    } else {
      window.addEventListener("scroll", requestParallaxUpdate);
    }
  }

  window.addEventListener("resize", handleResize);
  handleResize();
}
