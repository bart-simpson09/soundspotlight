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
    <script src="/public/js/addAlbumValidation.js" defer></script>

    <title>Add album</title>
</head>

<body>
<nav>
    <a href="/"><img src="/public/assets/logo.svg" alt="SoundSpotlight Logo"></a>
    <div class="menuArea flexRow">
        <div class="menuOptions flexRow columnGap32">
            <a href="dashboard">Home</a>
            <a href="topAlbums">Top albums</a>
            <a href="yourFavorites">Your favorites</a>
            <a href="myProfile">My profile</a>
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

<div class="globalPageContainer flexColumn rowGap32 narrowPageContainer">
    <h1>Add new album</h1>
    <form id="addAlbumForm" action="addAlbum" class="flexColumn rowGap32" method="POST" enctype="multipart/form-data">
        <div class="flexRow columnGap24">
            <img id="uploadedCoverPreview" class="myProfileAvatar" src="/public/assets/imgs/covers/default-cover.png"
                 alt="">
            <input type="file" id="photoInput" name="albumCover" accept="image/png, image/jpeg" required>
        </div>
        <div class="flexColumn rowGap16">
            <div class="flexRow columnGap16 rowGap16 mobileWrapped">
                <div class="inputArea flexColumn rowGap8">
                    <label for="albumTitle">Album title</label>
                    <input type="text" name="albumTitle" id="albumTitle" placeholder="Type album title" required>
                </div>
                <div class="inputArea flexColumn rowGap8">
                    <label for="authorName">Author name</label>
                    <input type="text" name="authorName" id="authorName" placeholder="Type author name" required>
                </div>
            </div>
            <div class="flexRow columnGap16 rowGap16 mobileWrapped">
                <div class="inputArea flexColumn rowGap8">
                    <label for="language">Language</label>
                    <div class="customSelect">
                        <select id="language" name="language" required>
                            <option value="" disabled="disabled" selected="true">Select language</option>
                            <?php foreach ($languages as $language): ?>
                                <option value="<?= $language->getLanguageId() ?>"><?= $language->getLanguageName() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="inputArea flexColumn rowGap8">
                    <label for="category">Category</label>
                    <div class="customSelect">
                        <select id="category" name="category" required>
                            <option value="" disabled="disabled" selected="true">Select category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->getCategoryId() ?>"><?= $category->getCategoryName() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="flexRow columnGap16 rowGap16 mobileWrapped">
                <div class="inputArea flexColumn rowGap8">
                    <label for="releaseDate">Release date</label>
                    <input type="date" name="releaseDate" id="releaseDate" required>
                </div>
                <div class="inputArea flexColumn rowGap8">
                    <label for="songsNumber">Number of songs</label>
                    <input type="number" name="songsNumber" id="songsNumber" placeholder="Type number of songs"
                           required>
                </div>
            </div>
            <div class="inputArea flexColumn rowGap8">
                <label for="description">Description</label>
                <textarea name="description" id="description" cols="30" rows="10"
                          placeholder="Type album description" required></textarea>
            </div>
        </div>
        <button type="submit" class="buttonPrimary" id="submitButton">Add new album</button>
        <div class="errorMessageContainer">
            <?php
            if (isset($errorMessage)) {
                echo $errorMessage;
            }
            ?>
        </div>
    </form>
</div>
</body>

</html>