<?php
/** @var $this View */
/** @var Model $model */

use app\core\form\Form;
use app\core\Model;
use app\core\View;

$this->title = "Contact";

$form = new Form("", "post", $model);
?>

<h1>Contact</h1>

<?php
$form->begin();
?>
<?php echo $form->field("subject"); ?>
<?php echo $form->field("email") ?>
<?php echo $form->field("body") ?>
    <button type="submit">Submit</button>
<?php $form->end(); ?>