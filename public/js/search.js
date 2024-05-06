const albumTitle = document.querySelector("#albumTitle");

const searchButton = document.querySelector("#searchButton");

const albumsContainer = document.querySelector(".albumsList");


searchButton.addEventListener("click", function (event) {
    const data = {search: albumTitle.value};

    fetch("/searchAlbum", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (albums) {
        albumsContainer.innerHTML = "";
        loadAlbums(albums);
    })
})

function loadAlbums(albums) {
    albums.forEach(album => {
        console.log(album);
        createAlbum(album);
    });
}

function createAlbum(album) {
    const template = document.querySelector("#albumTemplate");

    const clone = template.content.cloneNode(true);

    const cover = clone.querySelector("img");
    cover.src = `/public/assets/imgs/covers/${album.cover}`;

    const title = clone.querySelector("#albumTitle");
    title.innerHTML = album.albumtitle;

    const author = clone.querySelector("#albumAuthor");
    author.innerHTML = album.authorid;

    const releaseDate = clone.querySelector("#albumReleaseDate");
    releaseDate.innerHTML = album.releasedate;

    const rate = clone.querySelector("#albumRate");
    rate.innerHTML = album.averagerate;

    const category = clone.querySelector("#albumCategory");
    category.innerHTML = album.categoryid;

    const language = clone.querySelector("#albumLanguage");
    language.innerHTML = album.languageid;

    albumsContainer.appendChild(clone);
}