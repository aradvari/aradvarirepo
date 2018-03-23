<?php

use app\assets\OrderAsset;
use luya\bootstrap4\ActiveForm;
use yii\helpers\Html;

OrderAsset::register($this);

?>

<?= $this->render('_sub_menu') ?>

<?php

$form = ActiveForm::begin([
    'id' => 'password-form',
]);

?>

<?= $form->field($felhasznaloModel, 'regi_jelszo')->passwordInput() ?>
<?= $form->field($felhasznaloModel, 'jelszo')->passwordInput() ?>
<?= $form->field($felhasznaloModel, 'jelszo_ismetles')->passwordInput() ?>

<?= Html::submitButton('Jelszó módosítása', ['class' => 'arrow_box', 'name' => 'pw-button']) ?>

<?php ActiveForm::end(); ?>