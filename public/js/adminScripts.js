const pendingReviewsContainer = document.querySelector("#pendingReviews");
const pendingAlbumsContainer = document.querySelector("#pendingAlbums");
const manageUsersContainer = document.querySelector("#manageUsers");

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

function reviewAlbum(decision, albumId) {
    const data = {
        decision: decision,
        albumId: albumId
    };

    fetch("/changeAlbumStatus", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (albums) {
        pendingAlbumsContainer.innerHTML = "";
        loadAlbums(albums);
    })
}

function loadAlbums(albums) {
    if (albums.length > 0) {
        albums.forEach(album => {
            createAlbum(album);
        });
    } else {
        pendingAlbumsContainer.innerHTML = `<p>There are no pending albums at the moment.</p>`;
    }
}

function createAlbum(album) {
    const template = document.querySelector("#albumTemplate");

    const clone = template.content.cloneNode(true);

    const albumCover = clone.querySelector("img");
    albumCover.src = `/public/assets/imgs/covers/${album.cover}`;

    const albumName = clone.querySelector("#aAlbumName");
    albumName.innerHTML = album.albumtitle;

    const albumAuthorName = clone.querySelector("#aAlbumAuthorName");
    albumAuthorName.innerHTML = album.authorname;

    const actionButtons = clone.querySelector("#aActionButtons");
    actionButtons.innerHTML = `<button class="buttonOutlined positiveAction"
                            onclick="reviewAlbum('Approve', ${album.id})">Approve
                    </button>`;
    actionButtons.innerHTML += `<button class="buttonOutlined importantAction"
                            onclick="reviewAlbum('Decline', ${album.id})">Decline
                    </button>`;

    const category = clone.querySelector("#aCategoryName");
    category.innerHTML = album.categoryname;

    const language = clone.querySelector("#aLanguage");
    language.innerHTML = album.languagename;

    const releaseDate = clone.querySelector("#aReleaseDate");
    releaseDate.innerHTML = album.releasedate;

    const albumDescription = clone.querySelector(".shortAlbumDescription");
    albumDescription.innerHTML = album.description;

    const authorName = clone.querySelector("#aAuthorName");
    authorName.innerHTML = album.userfirstname + " " + album.userlastname;

    pendingAlbumsContainer.appendChild(clone);
}

function manageUser(decision, userId, loggedUserId) {
    const data = {
        decision: decision,
        userId: userId
    };

    fetch("/manageUser", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (users) {
        manageUsersContainer.innerHTML = "";
        loadUsers(users, loggedUserId);
    })
}

function loadUsers(users, loggedUserId) {
    users.forEach(user => {
        createUser(user, loggedUserId);
    });
}

function createUser(user, loggedUserId) {
    const template = document.querySelector("#userTemplate");

    const clone = template.content.cloneNode(true);

    const userAvatar = clone.querySelector("img");
    userAvatar.src = `/public/assets/imgs/avatars/${user.avatar}`;

    const userName = clone.querySelector("#uUserName");
    userName.innerHTML = user.firstname + " " + user.lastname;

    if (user.role === "admin") {
        const userNameSection = clone.querySelector("#userNameSection");
        userNameSection.innerHTML += `<i class="iconoir-user-crown"></i>`;
    }

    const userEmail = clone.querySelector("#userEmail");
    userEmail.innerHTML = user.email;

    const userActions = clone.querySelector("#userActions");
    if (user.id !== loggedUserId) {
        if (user.role === "admin") {
            userActions.innerHTML = `<button class="buttonOutlined"
                                            onclick="manageUser('removeAdmin', ${user.id}, ${loggedUserId})">
                                        Revoke admin role
                                    </button>`;
        } else {
            userActions.innerHTML = `<button class="buttonOutlined" onclick="manageUser('addAdmin', ${user.id}, ${loggedUserId})"> Grant admin role</button>`;

        }
        userActions.innerHTML += `<button class="buttonOutlined importantAction" onclick="manageUser('deleteUser', ${user.id}, ${loggedUserId})">Remove user</button>`;
    } else {
        userActions.innerHTML = `<h5>This is your account</h5>`;
    }

    manageUsersContainer.appendChild(clone);
}