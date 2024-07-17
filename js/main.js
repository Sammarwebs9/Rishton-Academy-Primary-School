
document.addEventListener('DOMContentLoaded', (event) => {
    const navbarToggler = document.getElementById('navbar-toggler');
    const navbarNav = document.getElementById('navbar-nav');

    navbarToggler.addEventListener('click', () => {
        navbarNav.classList.toggle('active');
    });
});


// -----------Index-----------------------------




    // Smooth scroll for anchor links
    const links = document.querySelectorAll('a[href^="#"]');
    for (const link of links) {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            target.scrollIntoView({
                behavior: 'smooth'
            });
        });
    }




// ----------------------------------------------------------------