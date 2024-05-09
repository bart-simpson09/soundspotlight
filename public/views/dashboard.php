<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:slnt,wght@-10..0,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/iconoir-icons/iconoir@main/css/iconoir.css"/>

    <link rel="stylesheet" type="text/css" href="/public/css/reset.css">
    <link rel="stylesheet" type="text/css" href="/public/css/fonts.css">
    <link rel="stylesheet" type="text/css" href="/public/css/colors.css">
    <link rel="stylesheet" type="text/css" href="/public/css/flex.css">
    <link rel="stylesheet" type="text/css" href="/public/css/global.css">
    <link rel="stylesheet" type="text/css" href="/public/css/components.css">
    <link rel="stylesheet" type="text/css" href="/public/css/responsive.css">

    <script src="/public/js/scripts.js" defer></script>
    <script src="/public/js/search.js" defer></script>

    <title>Dashboard</title>
</head>

<body>
<nav>
    <a href="/"><img src="/public/assets/logo.svg" alt="SoundSpotlight Logo"></a>
    <div class="menuArea flexRow">
        <div class="menuOptions flexRow columnGap32">
            <a class="active" href="dashboard">Home</a>
            <a href="topAlbums">Top albums</a>
            <a href="yourFavorite">Your favorites</a>
            <a href="myProfile">My profile</a>
            <?php if ($isAdmin == "admin"): ?>
                <a href="">Admin console</a>
            <?php endif; ?>
        </div>
        <div class="userSide flexRow columnGap24">
            <button class="flexRow columnGap8">
                <span class="iconBox flexCenter"><i class="iconoir-music-double-note"></i></span>
                <a href="addAlbum">Add album</a>
            </button>
            <span class="menuDivider"></span>
            <form class="userInfo flexRow columnGap16" action="logout" method="POST">
                <div class="profile flexRow columnGap8">
                    <img class="standardAvatar" src="/public/assets/imgs/avatars/<?= $avatar ?>"
                         alt="<?= $firstName . ' ' . $lastName . ' avatar' ?>">
                    <p class="fontMedium"><?= $firstName . ' ' . $lastName ?></p>
                </div>
                <button class="flexRow" type="submit">
                    <i class="iconoir-log-out" style="font-size: 24px; color: #70758F;"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="hamburgerMenu">
        <span class="hamburgerBar"></span>
        <span class="hamburgerBar"></span>
        <span class="hamburgerBar"></span>
    </div>
</nav>

<div class="globalPageContainer flexColumn">
    <div class="flexColumn rowGap24">
        <h1>Albums in our library</h1>

        <div class="flexRow searchBar columnGap16">

            <div class="inputArea flexColumn rowGap8">
                <label for="albumTitle">Album title</label>
                <div class="inputWithIcon">
                    <input type="text" name="albumTitle" id="albumTitle" placeholder="Type album title">
                    <i class="iconoir-compact-disc"></i>
                </div>
            </div>

            <div class="inputArea flexColumn rowGap8">
                <label for="artistName">Artist name</label>
                <div class="inputWithIcon">
                    <input type="text" name="artistName" id="artistName" placeholder="Type artist name">
                    <i class="iconoir-user"></i>
                </div>
            </div>

            <div class="inputArea flexColumn rowGap8">
                <label for="category">Category</label>
                <div class="inputWithIcon">
                    <div class="customSelect">
                        <select name="category" id="category">
                            <option value="0">All categories</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->getCategoryId() ?>"><?= $category->getCategoryName() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <i class="iconoir-album-list"></i>
                </div>
            </div>

            <div class="inputArea flexColumn rowGap8">
                <label for="language">Language</label>
                <div class="inputWithIcon">
                    <div class="customSelect">
                        <select name="language" id="language">
                            <option value="0">All languages</option>
                            <?php foreach ($languages as $language): ?>
                                <option value="<?= $language->getLanguageId() ?>"><?= $language->getLanguageName() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <i class="iconoir-language"></i>
                </div>
            </div>

            <button class="buttonPrimary" id="searchButton">Search albums</button>
        </div>
    </div>
    <div class="albumsList">
        <?php foreach ($allAlbums as $album): ?>
            <a href="/albumDetails/<?= $album['id'] ?>" class="albumItem flexColumn rowGap24">
                <div class="albumItemCoverArea">
                    <div class="favouriteButtonDefault flexCenter">
                        <?php
                        $heartClass = $album['isfavorite'] ? 'iconoir-heart-solid' : 'iconoir-heart';
                        ?>
                        <i class="<?= $heartClass ?>"></i>
                    </div>
                    <img class="albumItemCover" src="/public/assets/imgs/covers/<?= $album['cover'] ?>"
                         alt="<?= $album['name'] ?>-Album-Cover">
                </div>
                <div class="albumItemContent flexColumn rowGap24">
                    <div class="flexColumn rowGap4">
                        <h3><?= $album['albumtitle'] ?></h3>
                        <p><?= $album['authorname'] ?></p>
                    </div>
                    <div class="flexColumn rowGap8">
                        <div class="flexRow columnGap8">
                            <p class="albumItemDetailLabel">Release date</p>
                            <p class="albumItemDetailText"><?= $album['releasedate'] ?></p>
                        </div>
                        <div class="flexRow columnGap8">
                            <p class="albumItemDetailLabel">Rate</p>
                            <p class="albumItemDetailText"><?= $album['averagerate'] != 0 ? $album['averagerate'] : '-' ?></p>
                        </div>
                        <div class="flexRow columnGap8">
                            <p class="albumItemDetailLabel">Category</p>
                            <p class="albumItemDetailText"><?= $album['categoryname'] ?></p>
                        </div>
                        <div class="flexRow columnGap8">
                            <p class="albumItemDetailLabel">Language</p>
                            <p class="albumItemDetailText"><?= $album['languagename'] ?></p>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
</body>

<template id="albumTemplate">
    <div class="albumItem flexColumn rowGap24">
        <div class="albumItemCoverArea">
            <div class="favouriteButtonDefault flexCenter" id="favoriteButton">
                <i class="iconoir-heart"></i>
            </div>
            <img class="albumItemCover" src=""
                 alt="Album-Cover">
        </div>
        <div class="albumItemContent flexColumn rowGap24">
            <div class="flexColumn rowGap8">
                <h3 id="albumTitle">Album title</h3>
                <p id="albumAuthor">Author</p>
            </div>
            <div class="flexColumn rowGap8">
                <div class="flexRow columnGap8">
                    <p class="albumItemDetailLabel">Release date</p>
                    <p class="albumItemDetailText" id="albumReleaseDate">Release date</p>
                </div>
                <div class="flexRow columnGap8">
                    <p class="albumItemDetailLabel">Rate</p>
                    <p class="albumItemDetailText" id="albumRate">Rate</p>
                </div>
                <div class="flexRow columnGap8">
                    <p class="albumItemDetailLabel">Category</p>
                    <p class="albumItemDetailText" id="albumCategory">Category</p>
                </div>
                <div class="flexRow columnGap8">
                    <p class="albumItemDetailLabel">Language</p>
                    <p class="albumItemDetailText" id="albumLanguage">Language</p>
                </div>
            </div>
        </div>
    </div>
</template>

</html>