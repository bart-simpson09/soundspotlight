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

    <script src="/public/js/navigation.js" defer></script>
    <script src="/public/js/toggleFavorite.js" defer></script>

    <title>Your favorite albums</title>
</head>

<body>
<nav>
    <a href="/"><img src="/public/assets/logo.svg" alt="SoundSpotlight Logo"></a>
    <div class="menuArea flexRow">
        <div class="menuOptions flexRow columnGap32">
            <a href="dashboard">Home</a>
            <a href="topAlbums">Top albums</a>
            <a class="active" href="yourFavorites">Your favorites</a>
            <?php if ($isAdmin == "admin"): ?>
                <a href="adminConsole">Admin console</a>
            <?php endif; ?>
        </div>
        <div class="userSide flexRow columnGap24">
            <button class="flexRow columnGap8">
                <span class="iconBox flexCenter"><i class="iconoir-music-double-note"></i></span>
                <a href="addAlbum">Add album</a>
            </button>
            <span class="menuDivider"></span>
            <form class="userInfo flexRow columnGap16" action="logout" method="POST">
                <a href="myProfile" class="profile flexRow columnGap8">
                    <img class="standardAvatar" src="/public/assets/imgs/avatars/<?= $avatar ?>"
                         alt="<?= $firstName . ' ' . $lastName . ' avatar' ?>">
                    <p class="fontMedium"><?= $firstName . ' ' . $lastName ?></p>
                </a>
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
        <h1>Your favorite albums</h1>


    </div>
    <div class="albumsList">
        <?php if (empty($favoriteAlbums)): ?>
            <p>No favorite albums found.</p>
        <?php else: ?>
            <?php foreach ($favoriteAlbums as $album): ?>
                <div class="albumItemContainer">
                    <a href="/albumDetails/<?= $album['id'] ?>" class="albumItem flexColumn rowGap24">
                        <div class="albumItemCoverArea">
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
                                    <p class="albumItemDetailText"><?= $album['averagerate'] != 0 ? $album['averagerate'] . "/5" : '-' ?></p>
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
                    <div class="favouriteButtonDefault flexCenter favoriteButton"
                         onclick="toggleFavorite(<?= $album['id'] ?>, this)">
                        <?php
                        $heartClass = $album['isfavorite'] ? 'iconoir-heart-solid' : 'iconoir-heart';
                        ?>
                        <i class="<?= $heartClass ?>"></i>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
</body>

<template id="albumTemplate">
    <div class="albumItemContainer">
        <a href="/albumDetails/<?= $album['id'] ?>" class="albumItem flexColumn rowGap24">
            <div class="albumItemCoverArea">
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
        </a>
        <div class="favouriteButtonDefault flexCenter favoriteButton" id="favoriteButton"
             onclick="toggleFavorite(<?= $album['id'] ?>, this)">
            <i class="iconoir-heart"></i>
        </div>
    </div>
</template>

</html>