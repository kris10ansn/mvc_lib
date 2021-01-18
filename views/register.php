
<?php
/** @var User $model */
/** @var View $this */

use app\core\form\Form;
use app\models\User;
use app\core\View;

$this->title = "Home";
$form = new Form("", "post", $model);
?>


<h1>Register</h1>

<?php
$form->begin();
?>
    <?php echo $form->inputField("email"); ?>
    <?php echo $form->inputField("username"); ?>
    <?php echo $form->inputField("password")->password(); ?>
    <button type="submit">Register</button>
<?php $form->end(); ?>
