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

    <script src="/public/js/scripts.js"></script>

    <title>Dashboard</title>
</head>

<body>
<nav>
    <a href="/"><img src="/public/assets/logo.svg" alt="SoundSpotlight Logo"></a>
    <div class="menuArea flexRow">
        <div class="menuOptions flexRow columnGap32">
            <a class="active" href="dashboard">Home</a>
            <a href="">Top albums</a>
            <a href="">Your favourites</a>
            <a href="">My profile</a>
            <?php if ($isAdmin == "admin"): ?>
                <a href="">Admin console</a>
            <?php endif; ?>
        </div>
        <div class="userSide flexRow columnGap24">
            <button class="flexRow columnGap8">
                <span class="iconBox flexCenter"><i class="iconoir-music-double-note"></i></span>
                <a href="">Add album</a>
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

        <form class="flexRow searchBar columnGap16" action="searchAlbum" method="POST">

            <div class="inputArea flexColumn rowGap8">
                <label for="albumTitle">Album title</label>
                <div class="inputWithIcon">
                    <input type="text" name="" id="albumTitle" placeholder="Type album title">
                    <i class="iconoir-compact-disc"></i>
                </div>
            </div>

            <div class="inputArea flexColumn rowGap8">
                <label for="artistName">Artist name</label>
                <div class="inputWithIcon">
                    <input type="text" name="" id="artistName" placeholder="Type artist name">
                    <i class="iconoir-user"></i>
                </div>
            </div>

            <div class="inputArea flexColumn rowGap8">
                <label for="releaseYear">Release year</label>
                <div class="inputWithIcon">
                    <div class="customSelect">
                        <select id="releaseYear">
                            <option value="">All years</option>
                            <option value="">2024</option>
                            <option value="">2023</option>
                            <option value="">2022</option>
                            <option value="">2021</option>
                            <option value="">2020</option>
                            <option value="">2019</option>
                            <option value="">2018</option>
                            <option value="">2017</option>
                            <option value="">2016</option>
                            <option value="">2015</option>
                            <option value="">2014</option>
                            <option value="">2013</option>
                            <option value="">2012</option>
                            <option value="">2011</option>
                            <option value="">2010</option>
                        </select>
                    </div>
                    <i class="iconoir-calendar"></i>
                </div>
            </div>

            <div class="inputArea flexColumn rowGap8">
                <label for="rate">Rate</label>
                <div class="inputWithIcon">
                    <div class="customSelect">
                        <select id="rate">
                            <option value="">All rate ranges</option>
                            <option value="">5.0 - 4.5</option>
                            <option value="">4.5 - 4.0</option>
                            <option value="">4.0 - 3.5</option>
                            <option value="">3.5 - 3.0</option>
                            <option value="">3.0 - 2.5</option>
                            <option value="">2.5 - 2.0</option>
                            <option value="">2.0 or less</option>
                        </select>
                    </div>
                    <i class="iconoir-star"></i>
                </div>
            </div>

            <button class="buttonPrimary">Search albums</button>
        </form>
    </div>
    <div class="albumsList">
        <?php foreach ($shortenAlbums as $album): ?>
            <div class="albumItem flexColumn rowGap24">
                <div class="albumItemCoverArea">
                    <div class="favouriteButtonDefault flexCenter">
                        <i class="iconoir-heart"></i>
                    </div>
                    <img class="albumItemCover" src="/public/assets/imgs/covers/<?= $album['cover'] ?>"
                         alt="1-800-Oświecenie-Album-Cover">
                </div>
                <div class="albumItemContent flexColumn rowGap24">
                    <div class="flexColumn rowGap8">
                        <h3><?= $album['name'] ?></h3>
                        <p><?= $album['author'] ?></p>
                    </div>
                    <div class="flexColumn rowGap8">
                        <div class="flexRow columnGap8">
                            <p class="albumItemDetailLabel">Release date</p>
                            <p class="albumItemDetailText"><?= $album['releaseDate'] ?></p>
                        </div>
                        <div class="flexRow columnGap8">
                            <p class="albumItemDetailLabel">Rate</p>
                            <p class="albumItemDetailText"><?= $album['rate'] !== null ? $album['rate'] : '-' ?></p>
                        </div>
                        <div class="flexRow columnGap8">
                            <p class="albumItemDetailLabel">Category</p>
                            <p class="albumItemDetailText"><?= $album['category'] ?></p>
                        </div>
                        <div class="flexRow columnGap8">
                            <p class="albumItemDetailLabel">Language</p>
                            <p class="albumItemDetailText"><?= $album['language'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>

</html>