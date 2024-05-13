<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:slnt,wght@-10..0,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/iconoir-icons/iconoir@main/css/iconoir.css"/>

    <link rel="stylesheet" type="text/css" href="public/css/reset.css">
    <link rel="stylesheet" type="text/css" href="public/css/fonts.css">
    <link rel="stylesheet" type="text/css" href="public/css/colors.css">
    <link rel="stylesheet" type="text/css" href="public/css/flex.css">
    <link rel="stylesheet" type="text/css" href="public/css/global.css">
    <link rel="stylesheet" type="text/css" href="public/css/components.css">
    <link rel="stylesheet" type="text/css" href="public/css/responsive.css">

    <script src="public/js/scripts.js" defer></script>
    <script src="public/js/userProfile.js" defer></script>

    <title>My profile</title>
</head>

<body>
<nav>
    <a href="/"><img src="/public/assets/logo.svg" alt="SoundSpotlight Logo"></a>
    <div class="menuArea flexRow">
        <div class="menuOptions flexRow columnGap32">
            <a href="dashboard">Home</a>
            <a href="topAlbums">Top albums</a>
            <a href="yourFavorites">Your favorites</a>
            <a class="active" href="myProfile">My profile</a>
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

<div class="globalPageContainer flexColumn rowGap32 narrowPageContainer">
    <h1>My profile</h1>
    <div class="flexRow columnGap24">
        <img class="myProfileAvatar" src="/public/assets/imgs/avatars/<?= $avatar ?>" alt="">
        <div class="flexRow columnGap16 rowGap8">
            <h1 style="text-wrap: nowrap">Welcome, <?= $firstName ?></h1>
            <form id="changeUserPhotoForm" action="changePhoto" method="POST" enctype="multipart/form-data">
                <input type="file" id="photoInput" name="newPhoto" accept="image/png, image/jpeg">
            </form>

        </div>
    </div>
    <div class="flexColumn rowGap24">
        <div class="flexRow columnGap16">
            <button class="tabItem flexRow columnGap8" onclick="openTab(event, 'yourReviews')" id="defaultTab">
                <i class="iconoir-message"></i>
                Your reviews
            </button>
            <button class="tabItem flexRow columnGap8" onclick="openTab(event, 'addedAlbums')">
                <i class="iconoir-music-double-note"></i>
                Added albums
            </button>
        </div>
        <div>
            <div id="yourReviews" class="tabContent flexColumn rowGap16">
                <div class="yourProfileItem flexColumn rowGap16">
                    <div class="flexRow yourProfileItemHeader">
                        <div class="flexColumn rowGap4">
                            <h4>1-800-Oświecenie</h4>
                            <h5>Taco Hemingway</h5>
                        </div>
                        <div class="flexRow columnGap16">
                            <div class="flexRow columnGap8 opinionRate">
                                <i class="iconoir-star-solid"></i>
                                4.5/5
                            </div>
                            <div class="yourAddedElementStatus statusApproved flexCenter">Approved</div>
                        </div>
                    </div>
                    <p>Boldly experimental yet beautifully cohesive, this album pushes the boundaries of genre with
                        its innovative soundscapes and emotive lyricism. Each track unfolds like a chapter in a
                        captivating narrative, drawing listeners into its immersive sonic world. From the haunting
                        melodies to the intricate layers of instrumentation, every moment is crafted with meticulous
                        attention to detail, leaving a lasting impression that resonates long after the final note
                        fades.</p>
                </div>
                <div class="yourProfileItem flexColumn rowGap16">
                    <div class="flexRow yourProfileItemHeader">
                        <div class="flexColumn rowGap4">
                            <h4>1-800-Oświecenie</h4>
                            <h5>Taco Hemingway</h5>
                        </div>
                        <div class="flexRow columnGap16">
                            <div class="flexRow columnGap8 opinionRate">
                                <i class="iconoir-star-solid"></i>
                                4.5/5
                            </div>
                            <div class="yourAddedElementStatus statusDeclined flexCenter">Declined</div>
                        </div>
                    </div>
                    <p>Boldly experimental yet beautifully cohesive, this album pushes the boundaries of genre with
                        its innovative soundscapes and emotive lyricism. Each track unfolds like a chapter in a
                        captivating narrative, drawing listeners into its immersive sonic world. From the haunting
                        melodies to the intricate layers of instrumentation, every moment is crafted with meticulous
                        attention to detail, leaving a lasting impression that resonates long after the final note
                        fades.</p>
                </div>
            </div>
            <div id="addedAlbums" class="tabContent flexColumn rowGap16">
                <div class="yourProfileItem flexRow columnGap16">
                    <img src="/public/assets/imgs/covers/1-800-oswiecenie.png" class="albumSmallCover" alt="">
                    <div class="flexColumn rowGap16">
                        <div class="flexRow yourProfileItemHeader">
                            <div class="flexColumn rowGap4">
                                <h4>1-800-Oświecenie</h4>
                                <h5>Taco Hemingway</h5>
                            </div>
                            <div class="yourAddedElementStatus statusDeclined flexCenter">Declined</div>
                        </div>
                        <span class="dividerHorizon40"></span>
                        <div class="flexColumn rowGap8">
                            <div class="flexRow columnGap32 flexWrap">
                                <div class="flexRow columnGap8">
                                    <h5>Number of songs:</h5>
                                    <p>11</p>
                                </div>
                                <div class="flexRow columnGap8">
                                    <h5>Language:</h5>
                                    <p>Polish</p>
                                </div>
                                <div class="flexRow columnGap8">
                                    <h5>Release date:</h5>
                                    <p>01.01.2023</p>
                                </div>
                            </div>
                            <p class="shortAlbumDescription">Boldly experimental yet beautifully cohesive, this
                                album pushes the boundaries of
                                genre
                                with
                                its innovative soundscapes and emotive lyricism. Each track unfolds like a chapter
                                in a
                                captivating narrative, drawing listeners into its immersive sonic world. From the
                                haunting
                                melodies to the intricate layers of instrumentation, every moment is crafted with
                                meticulous
                                attention to detail, leaving a lasting impression that resonates long after the
                                final
                                note
                                fades.</p>
                        </div>
                    </div>
                </div>
                <div class="yourProfileItem flexRow columnGap16">
                    <img src="/public/assets/imgs/covers/1-800-oswiecenie.png" class="albumSmallCover" alt="">
                    <div class="flexColumn rowGap16">
                        <div class="flexRow yourProfileItemHeader">
                            <div class="flexColumn rowGap4">
                                <h4>1-800-Oświecenie</h4>
                                <h5>Taco Hemingway</h5>
                            </div>
                            <div class="yourAddedElementStatus statusApproved flexCenter">Approved</div>
                        </div>
                        <span class="dividerHorizon40"></span>
                        <div class="flexColumn rowGap8">
                            <div class="flexRow columnGap32 flexWrap">
                                <div class="flexRow columnGap8">
                                    <h5>Number of songs:</h5>
                                    <p>11</p>
                                </div>
                                <div class="flexRow columnGap8">
                                    <h5>Language:</h5>
                                    <p>Polish</p>
                                </div>
                                <div class="flexRow columnGap8">
                                    <h5>Release date:</h5>
                                    <p>01.01.2023</p>
                                </div>
                            </div>
                            <p class="shortAlbumDescription">Boldly experimental yet beautifully cohesive, this
                                album pushes the boundaries of
                                genre
                                with
                                its innovative soundscapes and emotive lyricism. Each track unfolds like a chapter
                                in a
                                captivating narrative, drawing listeners into its immersive sonic world. From the
                                haunting
                                melodies to the intricate layers of instrumentation, every moment is crafted with
                                meticulous
                                attention to detail, leaving a lasting impression that resonates long after the
                                final
                                note
                                fades.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>