
<?php /** @var LoginForm $model */ ?>

<?php
use app\core\form\Form;
use app\models\LoginForm;

$form = new Form("", "post", $model);
?>


<h1>Log in</h1>

<?php
$form->begin();
?>
<?php echo $form->field("email"); ?>
<?php echo $form->field("password")->password(); ?>
<button type="submit">Log in</button>
<?php $form->end(); ?>
