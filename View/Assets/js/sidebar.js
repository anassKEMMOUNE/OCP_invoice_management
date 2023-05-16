

  document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav__link');
  
    navLinks.forEach(function(link) {
      link.addEventListener('click', function(event) {
        navLinks.forEach(function(navLink) {
          navLink.classList.remove('active');
        });
  
        link.classList.add('active');
  
        localStorage.setItem('activeLink', link.getAttribute('href'));
      });
    });
  
    const activeLink = localStorage.getItem('activeLink');
    if (activeLink) {
      const link = document.querySelector(`.nav__link[href="${activeLink}"]`);
      if (link) {
        link.classList.add('active');
      }
    }
  });
  

        {
            const collapsedClass = "nav--collapsed";
            const lsKey = true;
            const nav = document.querySelector(".nav");
            const navBorder = nav.querySelector(".nav__border");
            if (localStorage.getItem(lsKey) === "true") {
              nav.classList.add(collapsedClass);
            }
            navBorder.addEventListener("click", () => {
              nav.classList.toggle(collapsedClass);
              localStorage.setItem(lsKey, nav.classList.contains(collapsedClass));
            });
    
    
      

          }