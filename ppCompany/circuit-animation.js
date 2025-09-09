(function() {
  'use strict';
  
  function initCircuitAnimation() {
    const animation = document.querySelector('.processor-animation');
    const centerLight = document.querySelector('.center-light');
    
    // Sprawdź czy elementy istnieją
    if (!animation || !centerLight) {
      console.log('Nie znaleziono elementów animacji');
      return;
    }
    
    // Pobierz wymiary kontenera animacji
    const animationRect = animation.getBoundingClientRect();
    const centerX = animationRect.width / 2;
    const centerY = animationRect.height / 2;
    
    // Funkcja tworzenia gwiazd
    function createStars() {
      // Sprawdź szerokość ekranu i dostosuj liczbę gwiazd
      const screenWidth = window.innerWidth;
      let starCount;
      
      if (screenWidth <= 576) {
        starCount = 8;
      } else if (screenWidth <= 768) {
        starCount = 12;
      } else {
        starCount = 20;
      }
      
      for(let i = 0; i < starCount; i++) {
        const star = document.createElement('div');
        star.className = 'star';
        star.style.left = `${Math.random() * 100}%`;
        star.style.top = `${Math.random() * 100}%`;
        star.style.animationDelay = `${Math.random() * 4000}ms`;
        animation.appendChild(star);
      }
    }
    
    // Rozpocznij animację
    function startAnimation() {
      // Stwórz rozplysk energii z centralnego punktu
      createEnergyBurst();
    }
    
    // Funkcja tworzenia rozplysku energii
    function createEnergyBurst() {
      // Sprawdź szerokość ekranu i dostosuj rozmiary
      const screenWidth = window.innerWidth;
      let burstSize, waveSize;
      
      if (screenWidth <= 576) {
        burstSize = 80;
        waveSize = 25;
      } else if (screenWidth <= 768) {
        burstSize = 120;
        waveSize = 35;
      } else {
        burstSize = 150;
        waveSize = 40;
      }
      
      // Główny rozplysk
      const burst = document.createElement('div');
      burst.className = 'energy-burst';
      burst.style.width = `${burstSize}px`;
      burst.style.height = `${burstSize}px`;
      burst.style.left = `${centerX - burstSize/2}px`;
      burst.style.top = `${centerY - burstSize/2}px`;
      animation.appendChild(burst);
      
      setTimeout(() => {
        burst.classList.add('active');
      }, 200);
      
      // Fale energii
      for(let i = 0; i < 3; i++) {
        setTimeout(() => {
          const wave = document.createElement('div');
          wave.className = 'energy-wave';
          wave.style.width = `${waveSize}px`;
          wave.style.height = `${waveSize}px`;
          wave.style.left = `${centerX - waveSize/2}px`;
          wave.style.top = `${centerY - waveSize/2}px`;
          animation.appendChild(wave);
          
          setTimeout(() => {
            wave.classList.add('active');
          }, 100);
        }, i * 400);
      }
    }
    
    // Inicjalizacja
    createStars();
    
    // Rozpocznij animację po krótkim opóźnieniu
    setTimeout(startAnimation, 1000);
    
    // Powtarzaj animację co 15 sekund
    setInterval(() => {
      // Wyczyść poprzednie elementy animacji
      const oldElements = animation.querySelectorAll('.energy-burst, .energy-wave');
      oldElements.forEach(el => {
        if (el && el.parentNode) {
          el.parentNode.removeChild(el);
        }
      });
      
      // Rozpocznij nową animację
      setTimeout(startAnimation, 500);
    }, 15000);
  }
  
  // Inicjalizuj gdy DOM jest gotowy
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCircuitAnimation);
  } else {
    initCircuitAnimation();
  }
})();