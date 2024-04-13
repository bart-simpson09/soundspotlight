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

    document.getElementById("defaultTab").click();
});

function openTab(event, tabName) {
    var i, tabContent, tabItem;

    tabContent = document.getElementsByClassName("tabContent");
    for (i = 0; i < tabContent.length; i++) {
        tabContent[i].style.display = "none";
    }

    tabItem = document.getElementsByClassName("tabItem");
    for (i = 0; i < tabItem.length; i++) {
        tabItem[i].className = tabItem[i].className.replace(" active", "");
    }

    document.getElementById(tabName).style.display = "block";
    event.currentTarget.className += " active";
}