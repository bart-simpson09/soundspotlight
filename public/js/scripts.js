const hamburgerMenu = document.querySelector(".hamburgerMenu");
const menuArea = document.querySelector(".menuArea");
const nav = document.querySelector("nav");

hamburgerMenu.addEventListener("click", mobileMenu);

function mobileMenu() {
    hamburgerMenu.classList.toggle("active");
    menuArea.classList.toggle("active");
    nav.classList.toggle("active");
}

let defaultTab = document.getElementById("defaultTab");
if (defaultTab != null) {
    defaultTab.click();
}

function openTab(event, tabName) {
    let i, tabContent, tabItem;

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
    let modal = document.getElementById(modalID);
    let closeButton = document.getElementById("addReviewClose");
    let stars = [...modal.querySelectorAll(".stars i")];

    modal.style.display = "flex";

    closeButton.onclick = function () {
        modal.style.display = "none"
    }

    window.onclick = function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }

    stars.map((star, index) => {
        star.onclick = () => {

            for (let i = 0; i < stars.length; ++i) {
                if (i <= index) {
                    stars[i].className = "ratingStar iconoir-star-solid";
                } else {
                    stars[i].className = "ratingStar iconoir-star";
                }
            }

            const rate = index + 1;

            handleRate(rate, "test");
        };
    });
}

document.querySelector(".goBackButton").addEventListener("click", () => {
    history.back();
})


function handleRate(rate, album) {
    console.log(rate)
}