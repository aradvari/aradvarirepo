<?php

use app\assets\OrderAsset;
use app\models\Helyseg;
use app\models\Kozterulet;
use app\models\Megyek;
use yii\helpers\ArrayHelper;
use luya\bootstrap4\ActiveForm;
use yii\helpers\Html;

OrderAsset::register($this);

?>

<div class="login_once">

    <p>Új regisztráció</p>

    <?php

    $form = ActiveForm::begin([
        'id' => 'reg-form',
    ]);

    ?>

    <?= $form->field($felhasznaloModel, 'vezeteknev')->textInput(['placeholder' => 'Vezetéknév'])->label(false) ?>

    <?= $form->field($felhasznaloModel, 'keresztnev')->textInput(['placeholder' => 'Keresztnév'])->label(false) ?>

    <?= $form->field($felhasznaloModel, 'cegnev')->textInput(['placeholder' => 'Cégnév'])->label(false) ?>

    <p>Szállítási cím</p>

    <?= $form->field($felhasznaloModel, 'irszam')->textInput(['placeholder' => 'Irányítószám'])->label(false) ?>

    <?= $form->field($felhasznaloModel, 'id_megye')->dropDownList(ArrayHelper::map(Megyek::find()->all(), 'ID_MEGYE', 'MEGYE_NEV'), ['prompt' => 'Válassz...'])->label(false) ?>

    <?= $form->field($felhasznaloModel, 'id_varos')->dropDownList(ArrayHelper::map(Helyseg::findAll(['ID_MEGYE' => $felhasznaloModel->id_megye]), 'ID_HELYSEG', 'HELYSEG_NEV'), ['style' => 'display:none'])->label(false) ?>

    <?= $form->field($felhasznaloModel, 'utcanev')->textInput(['placeholder' => 'Utcanév'])->label(false) ?>

    <?= $form->field($felhasznaloModel, 'id_kozterulet')->dropDownList(ArrayHelper::map(Kozterulet::find()->all(), 'id_kozterulet', 'megnevezes'), ['prompt' => 'Válassz...'])->label(false) ?>

    <?= $form->field($felhasznaloModel, 'hazszam')->textInput(['placeholder' => 'Házszám'])->label(false) ?>

    <?= $form->field($felhasznaloModel, 'emelet')->textInput(['placeholder' => 'Emelet, ajtó, egyéb'])->label(false) ?>

    <p>Elérhetőség</p>

    <?= $form->field($felhasznaloModel, 'email')->textInput(['placeholder' => 'E-mail cím'])->label(false) ?>

    <?= $form->field($felhasznaloModel, 'tel1_1')->textInput()->label(false) ?>
    <?= $form->field($felhasznaloModel, 'tel1_2')->textInput()->label(false) ?>
    <?= $form->field($felhasznaloModel, 'tel1_3')->textInput()->label(false) ?>
    <div style="clear:both"></div>

    <?= $form->field($felhasznaloModel, 'tel2_1')->textInput()->label(false) ?>
    <?= $form->field($felhasznaloModel, 'tel2_2')->textInput()->label(false) ?>
    <?= $form->field($felhasznaloModel, 'tel2_3')->textInput()->label(false) ?>
    <div style="clear:both"></div>

    <?= $form->field($felhasznaloModel, 'jelszo')->passwordInput(['placeholder' => 'Jelszó'])->label(false) ?>
    <?= $form->field($felhasznaloModel, 'jelszo_ismetles')->passwordInput(['placeholder' => 'Jelszó ismétlése'])->label(false) ?>

    <?= $form->field($felhasznaloModel, 'hirlevel', ['template' => '{error}{hint}{input} Feliratkozom a Coreshop hirlevelére'])->checkbox([], '') ?>

    <?= $form->field($felhasznaloModel, 'contract', ['template' => '{error}{hint}{input} Elfogadom az <a href="/hu/altalanos-szerzodesi-feltetelek" target="_blank">Általános szerződési feltételeket</a> (<a href="/coreshop_aszf.pdf" target="_blank">⇓ PDF</a>)'])->checkbox([], false) ?>

    <?= Html::submitButton('Regisztráció', ['class' => 'arrow_box', 'name' => 'reg-button']) ?>

    <?php ActiveForm::end(); ?>

</div>