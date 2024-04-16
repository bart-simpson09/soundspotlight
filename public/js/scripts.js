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

    var defaultTab = document.getElementById("defaultTab");
    if (defaultTab != null) {
        defaultTab.click();
    }
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

    document.getElementById(tabName).style.display = "flex";
    event.currentTarget.className += " active";
}

function openModal(modalID) {
    var modal = document.getElementById(modalID);
    var closeButton = document.getElementById("addReviewClose");

    modal.style.display = "flex";

    closeButton.onclick = function () { modal.style.display = "none" }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}