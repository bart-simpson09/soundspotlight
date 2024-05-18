const pendingReviewsContainer = document.querySelector("#pendingReviews");
const pendingAlbumsContainer = document.querySelector("#pendingAlbums");
const manageUsersContainer = document.querySelector("#manageUsers");

const postRequest = (url, data) => {
    return fetch(url, {
        method: "POST",
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    }).then(response => response.json());
}

const updateContainer = (container, data, loadFunction, emptyMessage) => {
    container.innerHTML = data.length > 0 ? '' : `<p>${emptyMessage}</p>`;
    data.forEach(item => loadFunction(item));
}

function reviewOpinion(decision, reviewId) {
    const data = {decision, reviewId};
    postRequest("/changeReviewStatus", data)
        .then(reviews => updateContainer(pendingReviewsContainer, reviews, createReview, "There are no pending reviews at the moment."));
}

function reviewAlbum(decision, albumId) {
    const data = {decision, albumId};
    postRequest("/changeAlbumStatus", data)
        .then(albums => updateContainer(pendingAlbumsContainer, albums, createAlbum, "There are no pending albums at the moment."));
}

function manageUser(decision, userId, loggedUserId) {
    const data = {decision, userId};
    postRequest("/manageUser", data)
        .then(users => updateContainer(manageUsersContainer, users, user => createUser(user, loggedUserId), ""));
}

const createReview = review => {
    const template = document.querySelector("#reviewTemplate");
    const clone = template.content.cloneNode(true);

    setTextContent(clone, "#rAlbumName", review.albumname);
    setTextContent(clone, "#rAlbumAuthorName", review.albumauthorname);
    setInnerHTML(clone, "#rOpinionRate", `${review.rate}/5 <i class="iconoir-star-solid"></i>`);
    setTextContent(clone, "#rContent", review.content);
    setTextContent(clone, "#rAuthorName", `${review.authorfirstname} ${review.authorlastname}`);

    setInnerHTML(clone, "#rActionButtons", `
        <button class="buttonOutlined positiveAction" onclick="reviewOpinion('Approve', ${review.id})">Approve</button>
        <button class="buttonOutlined importantAction" onclick="reviewOpinion('Decline', ${review.id})">Decline</button>
    `);

    pendingReviewsContainer.appendChild(clone);
}

const createAlbum = album => {
    const template = document.querySelector("#albumTemplate");
    const clone = template.content.cloneNode(true);

    setSrc(clone, "img", `/public/assets/imgs/covers/${album.cover}`);
    setTextContent(clone, "#aAlbumName", album.albumtitle);
    setTextContent(clone, "#aAlbumAuthorName", album.authorname);
    setTextContent(clone, "#aCategoryName", album.categoryname);
    setTextContent(clone, "#aLanguage", album.languagename);
    setTextContent(clone, "#aReleaseDate", album.releasedate);
    setTextContent(clone, ".shortAlbumDescription", album.description);
    setTextContent(clone, "#aAuthorName", `${album.userfirstname} ${album.userlastname}`);

    setInnerHTML(clone, "#aActionButtons", `
        <button class="buttonOutlined positiveAction" onclick="reviewAlbum('Approve', ${album.id})">Approve</button>
        <button class="buttonOutlined importantAction" onclick="reviewAlbum('Decline', ${album.id})">Decline</button>
    `);

    pendingAlbumsContainer.appendChild(clone);
}

const createUser = (user, loggedUserId) => {
    const template = document.querySelector("#userTemplate");
    const clone = template.content.cloneNode(true);

    setSrc(clone, "img", `/public/assets/imgs/avatars/${user.avatar}`);
    setTextContent(clone, "#uUserName", `${user.firstname} ${user.lastname}`);
    setTextContent(clone, "#userEmail", user.email);

    const userNameSection = clone.querySelector("#userNameSection");
    userNameSection.innerHTML = `${user.firstname} ${user.lastname}`;
    if (user.role === "admin") {
        userNameSection.innerHTML += ` <i class="iconoir-user-crown"></i>`;
    }

    const userActions = clone.querySelector("#userActions");
    if (user.id !== loggedUserId) {
        userActions.innerHTML = `
            <button class="buttonOutlined" onclick="manageUser('${user.role === "admin" ? 'removeAdmin' : 'addAdmin'}', ${user.id}, ${loggedUserId})">
                ${user.role === "admin" ? 'Revoke admin role' : 'Grant admin role'}
            </button>
            <button class="buttonOutlined importantAction" onclick="manageUser('deleteUser', ${user.id}, ${loggedUserId})">Remove user</button>
        `;
    } else {
        userActions.innerHTML = `<h5>This is your account</h5>`;
    }

    manageUsersContainer.appendChild(clone);
}

const setSrc = (clone, selector, src) => {
    const element = clone.querySelector(selector);
    if (element) element.src = src;
    else console.error(`${selector} element not found`);
}

const setTextContent = (clone, selector, text) => {
    const element = clone.querySelector(selector);
    if (element) element.textContent = text;
    else console.error(`${selector} element not found`);
}

const setInnerHTML = (clone, selector, html) => {
    const element = clone.querySelector(selector);
    if (element) element.innerHTML = html;
    else console.error(`${selector} element not found`);
}
