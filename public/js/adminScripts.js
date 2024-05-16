const pendingReviewsContainer = document.querySelector("#pendingReviews");

function reviewOpinion(decision, reviewId) {
    const data = {
        decision: decision,
        reviewId: reviewId
    };

    fetch("/changeReviewStatus", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (reviews) {
        pendingReviewsContainer.innerHTML = "";
        loadReviews(reviews);
    })
}

function loadReviews(reviews) {
    if (reviews.length > 0) {
        reviews.forEach(review => {
            createReview(review);
        });
    } else {
        pendingReviewsContainer.innerHTML = `<p>There are no pending reviews at the moment.</p>`;
    }
}

function createReview(review) {
    const template = document.querySelector("#reviewTemplate");

    const clone = template.content.cloneNode(true);

    const albumName = clone.querySelector("#rAlbumName");
    albumName.innerHTML = review.albumname;

    const albumAuthorName = clone.querySelector("#rAlbumAuthorName");
    albumAuthorName.innerHTML = review.albumauthorname;

    const opinionRate = clone.querySelector("#rOpinionRate");
    opinionRate.innerHTML = review.rate + "/5";
    opinionRate.innerHTML += `<i class="iconoir-star-solid"></i>`;

    const actionButtons = clone.querySelector("#rActionButtons");
    actionButtons.innerHTML = `<button class="buttonOutlined positiveAction"
                            onclick="reviewOpinion('Approve', ${review.id})">Approve
                    </button>`;
    actionButtons.innerHTML += `<button class="buttonOutlined importantAction"
                            onclick="reviewOpinion('Decline', ${review.id})">Decline
                    </button>`;

    const content = clone.querySelector("#rContent");
    content.innerHTML = review.content;

    const authorName = clone.querySelector("#rAuthorName");
    authorName.innerHTML = review.authorfirstname + " " + review.authorlastname;

    pendingReviewsContainer.appendChild(clone);
}