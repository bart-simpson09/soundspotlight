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
    <script src="/public/js/adminScripts.js" defer></script>
    <script src="/public/js/tabs.js" defer></script>

    <title>Admin console</title>
</head>

<body>
<nav>
    <a href="/"><img src="/public/assets/logo.svg" alt="SoundSpotlight Logo"></a>
    <div class="menuArea flexRow">
        <div class="menuOptions flexRow columnGap32">
            <a href="dashboard">Home</a>
            <a href="topAlbums">Top albums</a>
            <a href="yourFavorites">Your favorites</a>
            <?php if ($isAdmin == "admin"): ?>
                <a class="active" href="adminConsole">Admin console</a>
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

<div class="globalPageContainer flexColumn rowGap32 narrowPageContainer">
    <h1>Admin console</h1>
    <div class="flexColumn rowGap24">
        <div class="flexRow columnGap16 rowGap8 mobileWrapped">
            <button class="tabItem flexRow columnGap8" onclick="openTab(event, 'pendingReviews')" id="defaultTab">
                <i class="iconoir-notes"></i>
                Pending reviews
            </button>
            <button class="tabItem flexRow columnGap8" onclick="openTab(event, 'pendingAlbums')">
                <i class="iconoir-album"></i>
                Pending albums
            </button>
            <button class="tabItem flexRow columnGap8" onclick="openTab(event, 'manageUsers')">
                <i class="iconoir-user"></i>
                Manage users
            </button>
        </div>
        <div>
            <div id="pendingReviews" class="tabContent flexColumn rowGap16">
                <?php if (!empty($pendingReviews)): ?>
                    <?php foreach ($pendingReviews as $pendingReview): ?>
                        <div class="yourProfileItem flexColumn rowGap16">
                            <div class="flexRow yourProfileItemHeader">
                                <div class="flexColumn rowGap4">
                                    <h4><?= $pendingReview['albumname'] ?></h4>
                                    <h5><?= $pendingReview['albumauthorname'] ?></h5>
                                </div>
                                <div class="flexRow columnGap16">
                                    <div class="flexRow columnGap8 opinionRate">
                                        <i class="iconoir-star-solid"></i>
                                        <?= $pendingReview['rate'] . "/5" ?>
                                    </div>
                                    <div class="flexRow columnGap8">
                                        <button class="buttonOutlined positiveAction"
                                                onclick="reviewOpinion('Approve', <?= $pendingReview['id'] ?>)">Approve
                                        </button>
                                        <button class="buttonOutlined importantAction"
                                                onclick="reviewOpinion('Decline', <?= $pendingReview['id'] ?>)">Decline
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <p><?= $pendingReview['content'] ?></p>
                            <span class="pendingDivider"></span>
                            <div class="flexRow columnGap8">
                                <h5>Added by:</h5>
                                <p><?= $pendingReview['authorfirstname'] . " " . $pendingReview['authorlastname'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>There are no pending reviews at the moment.</p>
                <?php endif; ?>

            </div>
            <div id="pendingAlbums" class="tabContent flexColumn rowGap16">
                <?php if (!empty($pendingAlbums)): ?>
                    <?php foreach ($pendingAlbums as $pendingAlbum): ?>
                        <div class="yourProfileItem flexRow columnGap16">
                            <img src="/public/assets/imgs/covers/<?= $pendingAlbum['cover'] ?>" class="albumSmallCover"
                                 alt="">
                            <div class="flexColumn rowGap16" style="width: 100%;">
                                <div class="flexRow yourProfileItemHeader">
                                    <div class="flexColumn rowGap4">
                                        <h4><?= $pendingAlbum['albumtitle'] ?></h4>
                                        <h5><?= $pendingAlbum['authorname'] ?></h5>
                                    </div>
                                    <div class="flexRow columnGap8">
                                        <button class="buttonOutlined positiveAction"
                                                onclick="reviewAlbum('Approve', <?= $pendingAlbum['id'] ?>)">Approve
                                        </button>
                                        <button class="buttonOutlined importantAction"
                                                onclick="reviewAlbum('Decline', <?= $pendingAlbum['id'] ?>)">Decline
                                        </button>
                                    </div>
                                </div>
                                <span class="dividerHorizon40"></span>
                                <div class="flexColumn rowGap8">
                                    <div class="flexRow columnGap32 flexWrap">
                                        <div class="flexRow columnGap8">
                                            <h5>Category:</h5>
                                            <p><?= $pendingAlbum['categoryname'] ?></p>
                                        </div>
                                        <div class="flexRow columnGap8">
                                            <h5>Language:</h5>
                                            <p><?= $pendingAlbum['languagename'] ?></p>
                                        </div>
                                        <div class="flexRow columnGap8">
                                            <h5>Release date:</h5>
                                            <p><?= $pendingAlbum['releasedate'] ?></p>
                                        </div>
                                    </div>
                                    <p class="shortAlbumDescription"><?= $pendingAlbum['description'] ?></p>
                                    <span class="pendingDivider"></span>
                                    <div class="flexRow columnGap8">
                                        <h5>Added by:</h5>
                                        <p><?= $pendingAlbum['userfirstname'] . " " . $pendingAlbum['userlastname'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>There are no pending albums at the moment.</p>
                <?php endif; ?>
            </div>
            <div id="manageUsers" class="tabContent flexColumn rowGap16">
                <?php foreach ($allUsers as $user): ?>
                    <div class="yourProfileItem flexRow yourProfileItemHeader">
                        <div class="flexRow columnGap16">
                            <img class="standardAvatar" src="/public/assets/imgs/avatars/<?= $user['avatar'] ?>" alt="">
                            <div class="flexColumn">
                                <div class="flexRow columnGap4" id="userNameSection">
                                    <h4><?= $user['firstname'] . " " . $user['lastname'] ?></h4>
                                    <?php if ($user['role'] == 'admin'): ?>
                                        <i class="iconoir-user-crown"></i>
                                    <?php endif; ?>
                                </div>
                                <h5><?= $user['email'] ?></h5>
                            </div>
                        </div>
                        <div class="flexRow columnGap8">
                            <?php if ($loggedUserId != $user['id']): ?>
                                <?php if ($user['role'] == 'admin'): ?>
                                    <button class="buttonOutlined"
                                            onclick="manageUser('removeAdmin', <?= $user['id'] ?>, <?= $loggedUserId ?>)">
                                        Revoke admin role
                                    </button>
                                <?php else: ?>
                                    <button class="buttonOutlined"
                                            onclick="manageUser('addAdmin', <?= $user['id'] ?>, <?= $loggedUserId ?>)">
                                        Grant admin role
                                    </button>
                                <?php endif; ?>
                                <button class="buttonOutlined importantAction"
                                        onclick="manageUser('deleteUser', <?= $user['id'] ?>, <?= $loggedUserId ?>)">
                                    Remove user
                                </button>
                            <?php else: ?>
                                <h5>This is your account</h5>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
</body>

<template id="reviewTemplate">
    <div class="yourProfileItem flexColumn rowGap16">
        <div class="flexRow yourProfileItemHeader">
            <div class="flexColumn rowGap4">
                <h4 id="rAlbumName">Album name</h4>
                <h5 id="rAlbumAuthorName">Album author name</h5>
            </div>
            <div class="flexRow columnGap16">
                <div class="flexRow columnGap8 opinionRate" id="rOpinionRate">
                    <i class="iconoir-star-solid"></i>
                    4/5
                </div>
                <div class="flexRow columnGap8" id="rActionButtons">
                    <button class="buttonOutlined positiveAction">Approve
                    </button>
                    <button class="buttonOutlined importantAction">Decline
                    </button>
                </div>
            </div>
        </div>
        <p id="rContent">Review content</p>
        <span class="pendingDivider"></span>
        <div class="flexRow columnGap8">
            <h5>Added by:</h5>
            <p id="rAuthorName">Marry Smith</p>
        </div>
    </div>
</template>

<template id="albumTemplate">
    <div class="yourProfileItem flexRow columnGap16">
        <img src="" class="albumSmallCover"
             alt="">
        <div class="flexColumn rowGap16" style="width: 100%;">
            <div class="flexRow yourProfileItemHeader">
                <div class="flexColumn rowGap4">
                    <h4 id="aAlbumName">Album Name</h4>
                    <h5 id="aAlbumAuthorName">Album Author Name</h5>
                </div>
                <div class="flexRow columnGap8" id="aActionButtons">
                    <button class="buttonOutlined positiveAction">Approve
                    </button>
                    <button class="buttonOutlined importantAction">Decline
                    </button>
                </div>
            </div>
            <span class="dividerHorizon40"></span>
            <div class="flexColumn rowGap8">
                <div class="flexRow columnGap32 flexWrap">
                    <div class="flexRow columnGap8">
                        <h5>Category:</h5>
                        <p id="aCategoryName">Category name</p>
                    </div>
                    <div class="flexRow columnGap8">
                        <h5>Language:</h5>
                        <p id="aLanguage"></p>
                    </div>
                    <div class="flexRow columnGap8">
                        <h5>Release date:</h5>
                        <p id="aReleaseDate">Release date</p>
                    </div>
                </div>
                <p class="shortAlbumDescription">Album description</p>
                <span class="pendingDivider"></span>
                <div class="flexRow columnGap8">
                    <h5>Added by:</h5>
                    <p id="aAuthorName">Marry Smith</p>
                </div>
            </div>
        </div>
    </div>
</template>

<template id="userTemplate">
    <div class="yourProfileItem flexRow yourProfileItemHeader">
        <div class="flexRow columnGap16">
            <img class="standardAvatar" src="" alt="">
            <div class="flexColumn">
                <div class="flexRow columnGap4" id="userNameSection">
                    <h4 id="uUserName">Marry Smith</h4>
                </div>
                <h5 id="userEmail">marry.smith@example.com</h5>
            </div>
        </div>
        <div class="flexRow columnGap8" id="userActions">
            Content
        </div>
    </div>
</template>

</html>