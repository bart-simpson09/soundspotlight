function openModal(modalID, albumId) {
    let modal = document.getElementById(modalID);
    let closeButton = document.getElementById("addReviewClose");
    let stars = [...modal.querySelectorAll(".stars i")];

    const reviewContent = document.querySelector("#reviewContent");
    let reviewRate = 0;

    const addReviewButton = document.querySelector("#addReviewButton");

    addReviewButton.addEventListener("click", function (event) {
        event.preventDefault();

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
            }).then(function (isAdded) {
                if (isAdded) {
                    modal.style.display = "none";
                    reviewContent.value = "";
                    reviewRate = 0;
                    stars.map((star, index) => {
                        for (let i = 0; i < stars.length; ++i) {
                            stars[i].className = "ratingStar iconoir-star";
                        }
                    })
                    alert("Opinion added! Now our team must review it.");
                } else {
                    alert("Error occurred while adding a review!");
                }
            })
        } else {
            alert("Fill all required fields!");
        }


    })

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

            reviewRate = rate;
        };
    });
}