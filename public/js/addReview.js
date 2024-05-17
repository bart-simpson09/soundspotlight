const reviewsContainer = document.querySelector(".reviewsList");

function openModal(modalID, albumId) {
    let modal = document.getElementById(modalID);
    let closeButton = document.getElementById("addReviewClose");
    let stars = [...modal.querySelectorAll(".stars i")];

    const reviewContent = document.querySelector("#reviewContent");
    let reviewRate = 0;

    const addReviewButton = document.querySelector("#addReviewButton");

    const newReviewHandler = function (event) {
        event.preventDefault();

        console.log(reviewContent.value)
        console.log(reviewRate)

        if (reviewContent.value !== "" && reviewRate !== 0) {
            const data = {
                reviewContent: reviewContent.value,
                reviewRate: reviewRate,
                albumId: albumId
            };

            fetch("/addReview", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(function (response) {
                return response.json();
            }).then(function (reviews) {
                if (reviews) {
                    modal.style.display = "none";
                    reviewContent.value = "";
                    stars.map((star, index) => {
                        for (let i = 0; i < stars.length; ++i) {
                            stars[i].className = "ratingStar iconoir-star";
                        }
                    })
                    reviewsContainer.innerHTML = "";
                    loadReviews(reviews);
                    launchToast("Opinion added! Now our team must review it.");
                } else {
                    alert("Error occurred while adding a review!");
                }
            })
        } else {
            alert("Fill all required fields!");
        }
    };

    addReviewButton.removeEventListener("click", addReviewButton._handler);
    addReviewButton.addEventListener("click", newReviewHandler);
    addReviewButton._handler = newReviewHandler;

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
            reviewRate = index + 1;
        };
    });
}

function loadReviews(reviews) {
    reviews.forEach(review => {
        createReview(review);
    });
}

function createReview(review) {
    const template = document.querySelector("#reviewTemplate");

    const clone = template.content.cloneNode(true);

    const userAvatar = clone.querySelector("img");
    if (userAvatar) {
        userAvatar.src = `/public/assets/imgs/avatars/${review.authoravatar}`;
    } else {
        console.error("User avatar element not found");
    }

    const userName = clone.querySelector(".opinionAuthor");
    if (userName) {
        userName.innerHTML = review.authorfirstname + " " + review.authorlastname;
    } else {
        console.error("User name element not found");
    }

    const creationDate = clone.querySelector("#creationDate");
    if (creationDate) {
        creationDate.innerHTML = review.createddate;
    } else {
        console.error("Creation date element not found");
    }

    const rate = clone.querySelector(".opinionRate");
    if (rate) {
        rate.innerHTML = review.rate + "/5";
        rate.innerHTML += `<i class="iconoir-star-solid"></i>`;
    } else {
        console.error("Rate element not found");
    }

    const opinionDescription = clone.querySelector(".opinionDescription");
    if (opinionDescription) {
        opinionDescription.innerHTML = review.content;
    } else {
        console.error("Opinion description element not found");
    }

    reviewsContainer.appendChild(clone);
}

function launchToast(description) {
    const toast = document.createElement("div");
    toast.id = "toast";

    const toastIconArea = document.createElement("div");
    toastIconArea.id = "toastIconArea";

    const iconCircle = document.createElement("div");
    iconCircle.id = "iconCircle";

    const icon = document.createElement("i");
    icon.className = "ratingStar iconoir-check";

    iconCircle.appendChild(icon);
    toastIconArea.appendChild(iconCircle);

    const toastDescription = document.createElement("div");
    toastDescription.id = "toastDescription";
    toastDescription.innerHTML = description;

    toast.appendChild(toastIconArea);
    toast.appendChild(toastDescription);
    
    document.body.appendChild(toast);

    toast.className = "show";
    setTimeout(function () {
        toast.className = toast.className.replace("show", "");
        document.body.removeChild(toast);
    }, 5000);
}