
<?php use \app\core\Application; ?>

<h1>Hello, <?php echo Application::$app->user->getDisplayName() ?></h1>
