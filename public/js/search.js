// Cache DOM elements
const albumTitle = document.querySelector("#albumTitle");
const artistName = document.querySelector("#artistName");
const category = document.querySelector("#category");
const language = document.querySelector("#language");
const searchButton = document.querySelector("#searchButton");
const albumsContainer = document.querySelector(".albumsList");

// Add event listener for search button
searchButton.addEventListener("click", handleSearch);

// Handle search event
function handleSearch(event) {
    event.preventDefault();

    const data = {
        title: albumTitle.value,
        artist: artistName.value,
        category: category.value,
        language: language.value
    };

    fetchAlbums(data);
}

// Fetch albums based on search criteria
function fetchAlbums(data) {
    fetch("/searchAlbum", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(albums => {
            albumsContainer.innerHTML = "";
            loadAlbums(albums);
        });
}

// Load albums into the container
function loadAlbums(albums) {
    albums.forEach(album => createAlbum(album));
}

// Create album element
function createAlbum(album) {
    const template = document.querySelector("#albumTemplate");
    const clone = template.content.cloneNode(true);

    const favoriteButton = clone.querySelector("#favoriteButton");
    favoriteButton.innerHTML = album.isfavorite ? '<i class="iconoir-heart-solid"></i>' : '<i class="iconoir-heart"></i>';
    favoriteButton.setAttribute("onclick", `toggleFavorite(${album.id}, this)`);

    const id = clone.querySelector("a");
    id.href = `/albumDetails/${album.id}`;

    const cover = clone.querySelector("img");
    cover.src = `/public/assets/imgs/covers/${album.cover}`;

    const title = clone.querySelector("#albumTitle");
    title.innerHTML = album.albumtitle;

    const author = clone.querySelector("#albumAuthor");
    author.innerHTML = album.authorname;

    const releaseDate = clone.querySelector("#albumReleaseDate");
    releaseDate.innerHTML = album.releasedate;

    const rate = clone.querySelector("#albumRate");
    rate.innerHTML = album.averagerate != 0 ? `${album.averagerate}/5` : "-";

    const category = clone.querySelector("#albumCategory");
    category.innerHTML = album.categoryname;

    const language = clone.querySelector("#albumLanguage");
    language.innerHTML = album.languagename;

    albumsContainer.appendChild(clone);
}
