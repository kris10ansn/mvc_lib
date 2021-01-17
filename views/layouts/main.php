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
        <ul>
            <a href="/register">Register</a>
        </ul>
        <ul>
            <a href="/login">Log in</a>
        </ul>
        <ul>
            <a href="/">Home</a>
        </ul>
        <ul>
            <a href="/contact">Contact</a>
        </ul>
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

    {{content}}

</body>

</html>