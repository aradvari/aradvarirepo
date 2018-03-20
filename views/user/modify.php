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
    'id' => 'modify-form',
]);

?>

<?= $form->field($felhasznaloModel, 'vezeteknev')->textInput(['placeholder' => '']) ?>

<?= $form->field($felhasznaloModel, 'keresztnev')->textInput(['placeholder' => '']) ?>

<?= $form->field($felhasznaloModel, 'cegnev')->textInput(['placeholder' => '']) ?>

<?= $form->field($felhasznaloModel, 'irszam')->textInput(['placeholder' => '']) ?>

    <div id="<?= Html::getInputId($felhasznaloModel, 'varos_nev') ?>-container">
        <?= $form->field($felhasznaloModel, 'varos_nev')->textInput(); ?>
    </div>

    <div id="<?= Html::getInputId($felhasznaloModel, 'id_varos') ?>-container" style="display: none">
        <?= $form->field($felhasznaloModel, 'id_varos')->dropDownList([]) ?>
    </div>

<?= $form->field($felhasznaloModel, 'utcanev')->textInput(['placeholder' => '']) ?>

<?= $form->field($felhasznaloModel, 'id_kozterulet')->dropDownList(ArrayHelper::map(Kozterulet::find()->all(), 'id_kozterulet', 'megnevezes'), ['prompt' => 'Válassz...']) ?>

<?= $form->field($felhasznaloModel, 'hazszam')->textInput(['placeholder' => '']) ?>

<?= $form->field($felhasznaloModel, 'emelet')->textInput(['placeholder' => 'Emelet, ajtó, egyéb']) ?>

<?= $form->field($felhasznaloModel, 'email')->textInput(['placeholder' => '']) ?>

<?= $form->field($felhasznaloModel, 'telefonszam1')->textInput() ?>
<?= $form->field($felhasznaloModel, 'telefonszam2')->textInput() ?>

<?= $form->field($felhasznaloModel, 'hirlevel', ['template' => '{error}{hint}{input} Feliratkozom a Coreshop hirlevelére'])->checkbox([], '') ?>

<?= Html::submitButton('Adatok módosítása', ['class' => 'arrow_box', 'name' => 'reg-button']) ?>

<?php ActiveForm::end(); ?>