<?php
use app\core\Application;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/layouts/main.css">
</head>

<body>
    <nav>
        <div class="right">
            <a href="/">Home</a>
            <a href="/contact">Contact</a>
        </div>

        <div class="left">
            <?php if (!Application::$app->user): ?>
                <a href="/register">Register</a>
                <a href="/login">Log in</a>
            <?php else: ?>
                <p>👨‍💻 <a href="/profile"><?php echo Application::$app->user->getDisplayName() ?></a></p>

                <form action="/logout" method="post">
                    <button type="submit">Log out</button>
                </form>
            <?php endif; ?>
        </div>
    </nav>

    <?php
    $successMessage = Application::$app->session->getFlash("success") ?? false;
    if($successMessage): ?>
        <div class="flash success">
            <p>
                <?php echo $successMessage; ?>
            </p>
        </div>
    <?php endif; ?>

    <div id="content">
        {{content}}
    </div>
</body>

</html>