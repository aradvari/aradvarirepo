<?php

use luya\bootstrap4\ActiveForm;
use yii\helpers\Html;

?>

<h1>Leiratkozás hírlevélről</h1>

<?php

$form = ActiveForm::begin([
    'id' => 'unsubscribe-form',
]);

?>

<div class="row m-1">
    <?= $form->field($model, 'email', ['options' => ['class' => 'form-group']])->textInput() ?>
</div>

<?= Html::submitButton('Leiratkozás', ['class' => 'arrow_box', 'name' => 'unsubscribe-button']) ?>

<?php ActiveForm::end(); ?>

