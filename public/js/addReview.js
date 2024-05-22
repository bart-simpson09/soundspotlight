const reviewsContainer = document.querySelector(".reviewsList");

function openModal(modalID, albumId) {
    const modal = document.getElementById(modalID);
    const closeButton = document.getElementById("addReviewClose");
    const stars = [...modal.querySelectorAll(".stars i")];
    const reviewContent = document.querySelector("#reviewContent");
    const addReviewButton = document.querySelector("#addReviewButton");

    let reviewRate = 0;

    const newReviewHandler = function (event) {
        event.preventDefault();
        if (validateReviewForm(reviewContent.value, reviewRate)) {
            submitReview(reviewContent.value, reviewRate, albumId, modal, stars);
        } else {
            alert("Fill all required fields!");
        }
    };

    setupModalEventListeners(modal, closeButton, addReviewButton, stars, newReviewHandler, () => reviewRate, (rate) => reviewRate = rate);
    modal.style.display = "flex";
}

function validateReviewForm(content, rate) {
    return content !== "" && rate !== 0;
}

function submitReview(content, rate, albumId, modal, stars) {
    const data = {reviewContent: content, reviewRate: rate, albumId: albumId};

    fetch("/addReview", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(response => response.json())
        .then(reviews => {
            if (reviews) {
                resetModal(modal, reviewContent, stars);
                reviewsContainer.innerHTML = "";
                loadReviews(reviews);
                launchToast("Opinion added! Now our team must review it.");
            } else {
                alert("Error occurred while adding a review!");
            }
        });
}

function setupModalEventListeners(modal, closeButton, addReviewButton, stars, handler, getReviewRate, setReviewRate) {
    addReviewButton.removeEventListener("click", addReviewButton._handler);
    addReviewButton.addEventListener("click", handler);
    addReviewButton._handler = handler;

    closeButton.onclick = () => modal.style.display = "none";

    window.onclick = event => {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };

    stars.forEach((star, index) => {
        star.onclick = () => {
            updateStarRating(stars, index + 1);
            setReviewRate(index + 1); // Aktualizacja zmiennej reviewRate
        };
    });
}

function resetModal(modal, content, stars) {
    modal.style.display = "none";
    content.value = "";
    stars.forEach(star => star.className = "ratingStar iconoir-star");
}

function updateStarRating(stars, rating) {
    stars.forEach((star, index) => {
        star.className = index < rating ? "ratingStar iconoir-star-solid" : "ratingStar iconoir-star";
    });
}

function loadReviews(reviews) {
    reviews.forEach(review => createReview(review));
}

function createReview(review) {
    const template = document.querySelector("#reviewTemplate");
    const clone = template.content.cloneNode(true);

    setReviewElement(clone, "img", `/public/assets/imgs/avatars/${review.authoravatar}`, "src");
    setReviewElement(clone, ".opinionAuthor", `${review.authorfirstname} ${review.authorlastname}`, "innerHTML");
    setReviewElement(clone, "#creationDate", review.createddate, "innerHTML");
    setReviewElement(clone, ".opinionRate", `${review.rate}/5 <i class="iconoir-star-solid"></i>`, "innerHTML");
    setReviewElement(clone, ".opinionDescription", review.content, "innerHTML");

    reviewsContainer.appendChild(clone);
}

function setReviewElement(clone, selector, value, attribute) {
    const element = clone.querySelector(selector);
    if (element) {
        element[attribute] = value;
    } else {
        console.error(`${selector} element not found`);
    }
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
    setTimeout(() => {
        toast.className = toast.className.replace("show", "");
        document.body.removeChild(toast);
    }, 5000);
}
