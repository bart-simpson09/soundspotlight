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

    <title>Register</title>
</head>

<body class="singleFormBody">
<div class="singleFormContainer flexColumn rowGap32">
    <div class="flexColumn rowGap16">
        <div class="flexColumn rowGap8">
            <h1>Create an account</h1>
            <p>It takes only a few steps to enter the music world!</p>
        </div>
        <span class="singleFormDivider"></span>
    </div>
    <form class="flexColumn rowGap32" action="register" method="POST">
        <div class="flexColumn rowGap16">
            <div class="inputArea flexColumn rowGap8">
                <label for="firstName">First name</label>
                <input type="text" name="firstName" id="firstName" placeholder="Enter your first name">
            </div>
            <div class="inputArea flexColumn rowGap8">
                <label for="lastName">Last name</label>
                <input type="text" name="lastName" id="lastName" placeholder="Enter your last name">
            </div>
            <div class="inputArea flexColumn rowGap8">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your email">
            </div>
            <div class="inputArea flexColumn rowGap8">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password">
            </div>
            <div class="inputArea flexColumn rowGap8">
                <label for="repeatedPassword">Repeat password</label>
                <input type="password" name="repeatedPassword" id="repeatedPassword"
                       placeholder="Enter your password again">
            </div>
            <div class="errorMessageContainer">
                <?php
                if (isset($messages)) {
                    foreach ($messages as $message) {
                        echo $message . "<br>";
                    }

                }
                ?>
            </div>
        </div>
        <button class="buttonPrimary" type="submit">Sign up</button>
    </form>
    <div class="flexRow columnGap4 flexCenter formFooter">
        <p>Already have an account?</p>
        <a href="login">Sign in</a>
    </div>
</div>
</body>

</html>