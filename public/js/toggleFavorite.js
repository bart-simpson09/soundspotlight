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
    }).then(response => response.json())
        .then(data => {
            const heartIcon = element.querySelector('i');
            if (data.isfavorite) {
                heartIcon.classList.remove('iconoir-heart-solid');
                heartIcon.classList.add('iconoir-heart');
            } else {
                heartIcon.classList.remove('iconoir-heart');
                heartIcon.classList.add('iconoir-heart-solid');
            }

            const url = window.location.href;
            const parts = url.split('/');
            const currentView = parts[parts.length - 1];

            if (currentView === "yourFavorites") {
                const albumsContainer = document.querySelector(".albumsList");
                albumsContainer.innerHTML = "";
                loadAlbums(data.favoriteAlbums);
            }
        })
}

function loadAlbums(albums) {
    albums.forEach(album => {
        createAlbum(album);
    });
}

function createAlbum(album) {
    const template = document.querySelector("#albumTemplate");

    const clone = template.content.cloneNode(true);

    const favoriteButton = clone.querySelector("#favoriteButton");
    if (album.isfavorite) {
        favoriteButton.innerHTML = '<i class="iconoir-heart-solid"></i>';
    } else {
        favoriteButton.innerHTML = '<i class="iconoir-heart"></i>';
    }

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
    if (album.averagerate != 0) {
        rate.innerHTML = album.averagerate + "/5";
    } else {
        rate.innerHTML = "-";
    }

    const category = clone.querySelector("#albumCategory");
    category.innerHTML = album.categoryname;

    const language = clone.querySelector("#albumLanguage");
    language.innerHTML = album.languagename;

    const albumsContainer = document.querySelector(".albumsList");
    albumsContainer.appendChild(clone);
}