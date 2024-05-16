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
    <script src="/public/js/addReview.js" defer></script>
    <script src="/public/js/toggleFavorite.js" defer></script>

    <title>Album details</title>
</head>

<body>
<nav>
    <a href="/"><img src="/public/assets/logo.svg" alt="SoundSpotlight Logo"></a>
    <div class="menuArea flexRow">
        <div class="menuOptions flexRow columnGap32">
            <a href="../dashboard">Home</a>
            <a href="../topAlbums">Top albums</a>
            <a href="../yourFavorites">Your favorites</a>
            <a href="../myProfile">My profile</a>
            <?php if ($isAdmin == "admin"): ?>
                <a href="../adminConsole">Admin console</a>
            <?php endif; ?>
        </div>
        <div class="userSide flexRow columnGap24">
            <button class="flexRow columnGap8">
                <span class="iconBox flexCenter"><i class="iconoir-music-double-note"></i></span>
                <a href="../addAlbum">Add album</a>
            </button>
            <span class="menuDivider"></span>
            <form class="userInfo flexRow columnGap16" action="../logout" method="POST">
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
    <div class="flexRow columnGap8 goBackButton">
        <i class="iconoir-arrow-left"></i>Go back to albums
    </div>
    <div class="flexColumn rowGap24 topAlbumSection">
        <div class="flexRow columnGap32 albumDetailsTop">
            <img class="albumDetailsCover" src="/public/assets/imgs/covers/<?= $album['cover'] ?>" alt="">
            <div class="flexColumn rowGap32">
                <div class="flexColumn rowGap16">
                    <div class="flexColumn rowGap8">
                        <div class="flexRow columnGap16">
                            <h1><?= $album['albumtitle'] ?></h1>
                            <div onclick="toggleFavorite(<?= $album['id'] ?>, this)">
                                <?php
                                $heartClass = $album['isfavorite'] ? 'iconoir-heart-solid' : 'iconoir-heart';
                                ?>
                                <i class="<?= $heartClass ?> albumDetailsFavourite favoriteButton"></i>
                            </div>
                        </div>
                        <p><?= $album['authorname'] ?></p>
                    </div>
                    <span class="dividerHorizon40"></span>
                </div>
                <div class="flexRow columnGap24 rowGap16 albumDetailsAttributeList">
                    <div class="flexRow columnGap8 albumDetailsAttribute">
                        <div class="albumDetailsAttributeIcon flexCenter">
                            <i class="iconoir-music-double-note"></i>
                        </div>
                        <p><?= $album['numberofsongs'] . " songs" ?></p>
                    </div>
                    <div class="flexRow columnGap8 albumDetailsAttribute">
                        <div class="albumDetailsAttributeIcon flexCenter">
                            <i class="iconoir-language"></i>
                        </div>
                        <p><?= $album['languagename'] ?></p>
                    </div>
                    <div class="flexRow columnGap8 albumDetailsAttribute">
                        <div class="albumDetailsAttributeIcon flexCenter">
                            <i class="iconoir-calendar"></i>
                        </div>
                        <p><?= $album['releasedate'] ?></p>
                    </div>
                    <div class="flexRow columnGap8 albumDetailsAttribute">
                        <div class="albumDetailsAttributeIcon flexCenter">
                            <i class="iconoir-star"></i>
                        </div>
                        <p><?= $album['averagerate'] != 0 ? $album['averagerate'] . "/5" : '-' ?></p>
                    </div>
                </div>
            </div>
        </div>
        <p class="albumDetailsDescription"><?= $album['description'] ?></p>
    </div>
    <div class="albumDetailsOpinions flexColumn rowGap24">
        <div class="flexRow header">
            <h2>People opinions</h2>
            <button class="buttonPrimary" onclick="openModal('addReviewModal', <?= $album['id'] ?>)">Add your review
            </button>
        </div>
        <?php if (!empty($reviews)): ?>
            <div class="flexColumn rowGap16 reviewsList">
                <?php foreach ($reviews as $review): ?>
                    <div class="albumDetailsOpinionItem flexRow columnGap16">
                        <img class="standardAvatar" src="/public/assets/imgs/avatars/<?= $review['authoravatar'] ?>"
                             alt="">
                        <div class="flexColumn rowGap8 opinionContent">
                            <div class="flexRow opinionHeader">
                                <div class="opinionBasicInfo flexRow columnGap8">
                                    <p class="opinionAuthor"><?= $review['authorfirstname'] . " " . $review['authorlastname'] ?></p>
                                    <span class="opinionItemDivider"></span>
                                    <p id="creationDate"><?= $review['createddate'] ?></p>
                                </div>
                                <div class="flexRow columnGap8 opinionRate">
                                    <?= $review['rate'] . "/5" ?>
                                    <i class="iconoir-star-solid"></i>
                                </div>
                            </div>
                            <p class="opinionDescription"><?= $review['content'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>This album doesn't have any opinions yet. Let's add your review!</p>
        <?php endif; ?>
    </div>
</div>

<div class="modalArea" id="addReviewModal">
    <div class="modal flexColumn rowGap24">
        <div class="flexColumn rowGap8">
            <h2>Add your review</h2>
            <p>Express your feelings about this album in the field below.</p>
        </div>

        <div class="flexColumn rowGap16">
            <textarea name="reviewContent" id="reviewContent" cols="30" rows="10"
                      placeholder="Type your review here"></textarea>
            <div class="flexRow columnGap8 stars">
                <i class="ratingStar iconoir-star"></i>
                <i class="ratingStar iconoir-star"></i>
                <i class="ratingStar iconoir-star"></i>
                <i class="ratingStar iconoir-star"></i>
                <i class="ratingStar iconoir-star"></i>
            </div>
        </div>
        <div class="flexRow columnGap16">
            <button class="buttonOutlined" style="padding: 10.5px 16px;" id="addReviewClose">Cancel</button>
            <button class="buttonPrimary" id="addReviewButton">Add review</button>
        </div>

    </div>
</div>
</body>

<template id="reviewTemplate">
    <div class="albumDetailsOpinionItem flexRow columnGap16">
        <img class="standardAvatar" src="/public/assets/imgs/avatars/<?= $review['authoravatar'] ?>"
             alt="">
        <div class="flexColumn rowGap8 opinionContent">
            <div class="flexRow opinionHeader">
                <div class="opinionBasicInfo flexRow columnGap8">
                    <p class="opinionAuthor"><?= $review['authorfirstname'] . " " . $review['authorlastname'] ?></p>
                    <span class="opinionItemDivider"></span>
                    <p id="creationDate"><?= $review['createddate'] ?></p>
                </div>
                <div class="flexRow columnGap8 opinionRate">
                    <?= $review['rate'] . "/5" ?>
                    <i class="iconoir-star-solid"></i>
                </div>
            </div>
            <p class="opinionDescription"><?= $review['content'] ?></p>
        </div>
    </div>
</template>

</html>