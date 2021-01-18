
<?php use \app\core\Application; ?>

<h1>Home</h1>

<?php if (Application::$app->user): ?>
    <h2>Welcome, <?php echo Application::$app->user->getDisplayName() ?></h2>
<?php endif; ?>