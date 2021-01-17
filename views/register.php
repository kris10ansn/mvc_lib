
<?php /** @var Model $model */ ?>

<?php
use app\core\form\Form;
use app\core\Model;

$form = new Form("", "post", $model);
?>


<h1>Register</h1>

<?php
$form->begin();
?>
    <?php echo $form->field("email"); ?>
    <?php echo $form->field("username"); ?>
    <?php echo $form->field("password")->password(); ?>
    <button type="submit">Register</button>
<?php $form->end(); ?>
