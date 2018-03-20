<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?= $this->render('_sub_menu') ?>

<h4>Amennyiben véglegesen törölni szeretnéd fiókodat, kattints az alábbi gombra:</h4>

<?php

$form = ActiveForm::begin([
    'id' => 'modify-form',
]);

?>

<?= $form->field($felhasznaloModel, 'contract')->checkbox() ?>

<?= Html::submitButton('Végleges törlése', ['class' => 'btn btn-large btn-danger', 'name' => 'reg-button']) ?>

<?php ActiveForm::end(); ?>
