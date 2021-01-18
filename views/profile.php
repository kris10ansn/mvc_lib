<?php
/** @var $this View */

use \app\core\Application;
use app\core\View;

$this->title = "Home";
?>

<h1>Hello, <?php echo Application::$app->user->getDisplayName() ?></h1>
