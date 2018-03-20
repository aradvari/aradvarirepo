<?php

use app\assets\OrderAsset;
use app\models\Helyseg;
use app\models\Kozterulet;
use app\models\Megyek;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
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