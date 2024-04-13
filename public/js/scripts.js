document.addEventListener('DOMContentLoaded', function () {
    const hamburgerMenu = document.querySelector(".hamburgerMenu");
    const menuArea = document.querySelector(".menuArea");
    const nav = document.querySelector("nav");

    hamburgerMenu.addEventListener("click", mobileMenu);

    function mobileMenu() {
        hamburgerMenu.classList.toggle("active");
        menuArea.classList.toggle("active");
        nav.classList.toggle("active");
    }
});