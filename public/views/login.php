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

    <title>Login</title>
</head>

<body class="singleFormBody">
<div class="singleFormContainer flexColumn rowGap32">
    <div class="flexColumn rowGap16">
        <div class="flexColumn rowGap8">
            <h1>Welcome back</h1>
            <p>Please provide your details to enter the world.</p>
        </div>
        <span class="singleFormDivider"></span>
    </div>
    <form class="flexColumn rowGap32" action="login" method="POST">
        <div class="flexColumn rowGap16">
            <div class="inputArea flexColumn rowGap8">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your email">
            </div>
            <div class="inputArea flexColumn rowGap8">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password">
            </div>
            <div class="errorMessageContainer">
                <?php
                if (isset($messages)) {
                    foreach ($messages as $message) {
                        echo $message;
                    }

                }
                ?>
            </div>
        </div>
        <button class="buttonPrimary" type="submit">Sign in</button>
    </form>
    <div class="flexRow columnGap4 flexCenter formFooter">
        <p>Don’t have an account? </p>
        <a href="">Sign up</a>
    </div>
</div>
</body>

</html>