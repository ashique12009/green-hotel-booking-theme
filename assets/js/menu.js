document.addEventListener('DOMContentLoaded', function () {
    const menuBtn = document.querySelector('.mobile-menu-btn');
    const navMenu = document.querySelector('.nav-links');

    if (menuBtn && navMenu) {
        menuBtn.addEventListener('click', function () {
            navMenu.classList.toggle('active');
        });
    }
});