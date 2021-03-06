<?php

use app\models\Kozterulet;
use app\models\Megyek;
use yii\helpers\ArrayHelper;
use luya\bootstrap4\ActiveForm;
use yii\helpers\Html;

?>

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

        <?= $form->field($felhasznaloModel, 'contract', ['template' => '{error}{hint}{input} Elfogadom az <a href="/altalanos-szerzodesi-feltetelek" target="_blank">Általános szerződési feltételeket</a> (<a href="/coreshop_aszf.pdf" target="_blank">⇓ PDF</a>)'])->checkbox([], false) ?>

        <?= Html::submitButton('Tovább a megrendeléshez', ['class' => 'arrow_box', 'name' => 'reg-button']) ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>
