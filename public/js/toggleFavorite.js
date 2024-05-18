function toggleFavorite(albumId, element) {
    const data = {
        albumid: albumId
    };

    fetch("/toggleFavorite", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(data => {
            updateHeartIcon(element, data.isfavorite);

            if (isCurrentViewFavorites()) {
                refreshFavoriteAlbums(data.favoriteAlbums);
            }
        })
        .catch(error => {
            console.error('Error toggling favorite:', error);
        });
}

function updateHeartIcon(element, isFavorite) {
    const heartIcon = element.querySelector('i');
    heartIcon.classList.toggle('iconoir-heart-solid', !isFavorite);
    heartIcon.classList.toggle('iconoir-heart', isFavorite);
}

function isCurrentViewFavorites() {
    const currentView = window.location.href.split('/').pop();
    return currentView === "yourFavorites";
}

function refreshFavoriteAlbums(albums) {
    const albumsContainer = document.querySelector(".albumsList");
    albumsContainer.innerHTML = "";
    loadAlbums(albums);
}

function loadAlbums(albums) {
    albums.forEach(album => createAlbum(album));
}

function createAlbum(album) {
    const template = document.querySelector("#albumTemplate");
    const clone = template.content.cloneNode(true);

    setupFavoriteButton(clone, album);
    setupAlbumDetails(clone, album);

    document.querySelector(".albumsList").appendChild(clone);
}

function setupFavoriteButton(clone, album) {
    const favoriteButton = clone.querySelector("#favoriteButton");
    favoriteButton.innerHTML = `<i class="${album.isfavorite ? 'iconoir-heart-solid' : 'iconoir-heart'}"></i>`;
    favoriteButton.setAttribute("onclick", `toggleFavorite(${album.id}, this)`);
}

function setupAlbumDetails(clone, album) {
    clone.querySelector("a").href = `/albumDetails/${album.id}`;
    clone.querySelector("img").src = `/public/assets/imgs/covers/${album.cover}`;
    clone.querySelector("#albumTitle").textContent = `${album.albumtitle} ID: ${album.id}`;
    clone.querySelector("#albumAuthor").textContent = album.authorname;
    clone.querySelector("#albumReleaseDate").textContent = album.releasedate;
    clone.querySelector("#albumRate").textContent = album.averagerate ? `${album.averagerate}/5` : '-';
    clone.querySelector("#albumCategory").textContent = album.categoryname;
    clone.querySelector("#albumLanguage").textContent = album.languagename;
}
