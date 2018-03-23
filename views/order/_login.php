<?php

use app\assets\OrderAsset;
use app\models\Kozterulet;
use app\models\Megyek;
use yii\helpers\ArrayHelper;
use luya\bootstrap4\ActiveForm;
use yii\helpers\Html;

OrderAsset::register($this);

?>
<div class="textbox">
    <!-- div login -->
    <div class="login_once">

        <p>Megrendelés regisztrációval</p>

        <?php

        $form = ActiveForm::begin([
            'id' => 'login-form',
        ]); ?>

        <?= $form->field($model, 'username')->textInput(['placeholder' => 'E-mail cím'])->label(false) ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Jelszó'])->label(false) ?>

        <?= Html::submitButton('Login', ['class' => 'arrow_box', 'name' => 'login-button']) ?>

        <?= $form->field($model, 'rememberMe')->checkbox() ?>

        <?= $form->field($model, 'contract', ['template' => '{error}{hint}{input} Elfogadom az <a href="/hu/altalanos-szerzodesi-feltetelek" target="_blank">Általános szerződési feltételeket</a> (<a href="/coreshop_aszf.pdf" target="_blank">⇓ PDF</a>)'])->checkbox([], false) ?>

        <?php ActiveForm::end(); ?>

        <div>Nincs még felhasználói azonosítód?&nbsp;&nbsp;&nbsp;&nbsp;<a href="/hu/regisztracio">Regisztráció</a></div>

        <img src="/images/cxs-logo.png" style="width:40%; margin:100px 0 20px 0; opacity:0.8; padding:0 30%;">
        <img src="/images/gls-small.png" style="margin:0 10px 0px 0;">Kiszállítás: <font style="color:#2a87e4;">xxxx
    </div>
    <!-- endof div login -->
</div>

<div class="textbox">
    <!-- login_once -->
    <div class="login_once">

        <p>Megrendelés regisztráció nélkül</p>

        <?php

        $form = ActiveForm::begin([
            'id' => 'reg-form',
        ]);

        ?>

        <?= $form->field($felhasznaloModel, 'teljes_nev')->textInput(['placeholder' => 'Teljes név (vezetéknév, keresztnév)'])->label(false) ?>

        <p>Szállítási cím</p>

        <?= $form->field($felhasznaloModel, 'irszam')->textInput(['placeholder' => 'Irányítószám'])->label(false) ?>

        <?= $form->field($felhasznaloModel, 'id_megye')->dropDownList(ArrayHelper::map(Megyek::find()->all(), 'ID_MEGYE', 'MEGYE_NEV'), ['prompt'=>'Válassz...'])->label(false) ?>

        <?= $form->field($felhasznaloModel, 'id_varos')->dropDownList([],['style'=>'display:none'])->label(false) ?>

        <?= $form->field($felhasznaloModel, 'utcanev')->textInput(['placeholder' => 'Utcanév'])->label(false) ?>

        <?= $form->field($felhasznaloModel, 'id_kozterulet')->dropDownList(ArrayHelper::map(Kozterulet::find()->all(), 'id_kozterulet', 'megnevezes'), ['prompt'=>'Válassz...'])->label(false) ?>

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

        <?= $form->field($felhasznaloModel, 'hirlevel', ['template' => '{error}{hint}{input} Feliratkozom a Coreshop hirlevelére'])->checkbox([], '') ?>

        <?= $form->field($felhasznaloModel, 'contract', ['template' => '{error}{hint}{input} Elfogadom az <a href="/hu/altalanos-szerzodesi-feltetelek" target="_blank">Általános szerződési feltételeket</a> (<a href="/coreshop_aszf.pdf" target="_blank">⇓ PDF</a>)'])->checkbox([], false) ?>

        <?= Html::submitButton('Tovább a megrendeléshez', ['class' => 'arrow_box', 'name' => 'reg-button']) ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>
