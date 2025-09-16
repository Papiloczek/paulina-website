
    
    // // ---------- MOBILE MENU FUNCTIONALITY ----------
    // // Toggle fullscreen mobile menu
    // window.toggleFullScreenMenu = function() {
    //   const menu = document.querySelector('.fullscreen-menu');
    //   const body = document.body;
      
    //   menu.classList.toggle('active');
      
    //   // Add/remove body class for additional styling
    //   if (menu.classList.contains('active')) {
    //     body.classList.add('fullscreen-active');
    //   } else {
    //     body.classList.remove('fullscreen-active');
    //   }
    // };
    
    // // Toggle submenu in mobile view
    // const mobileMenuItems = document.querySelectorAll('.fullscreen-menu .menu-item-has-children > a');
    
    // mobileMenuItems.forEach(item => {
    //   item.addEventListener('click', function(e) {
    //     e.preventDefault();
    //     this.parentNode.classList.toggle('open');
    //   });
    // });
    
    // // ---------- DESKTOP SUBMENU FUNCTIONALITY ----------
    // // For desktop dropdown menus (optional, as CSS :hover can handle this)
    // const desktopMenuItems = document.querySelectorAll('.desktop-menu .menu-item-has-children');
    
    // desktopMenuItems.forEach(item => {
    //   item.addEventListener('mouseenter', function() {
    //     const subMenu = this.querySelector('.sub-menu');
    //     if (subMenu) {
    //       subMenu.classList.add('active');
    //     }
    //   });
      
    //   item.addEventListener('mouseleave', function() {
    //     const subMenu = this.querySelector('.sub-menu');
    //     if (subMenu) {
    //       subMenu.classList.remove('active');
    //     }
    //   });
    // });
