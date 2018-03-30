<?php
/* @var $felhasznaloModel app\models\Felhasznalok */

use app\assets\OrderAsset;
use app\models\FizetesiMod;
use app\models\Kozterulet;
use app\models\SzallitasiMod;
use app\widgets\gls\GlsWidget;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use luya\bootstrap4\ActiveForm;
use yii\helpers\Html;

OrderAsset::register($this);

?>
<div class="pre-login-container">
    <?php
    if (Yii::$app->user->isGuest)
        echo $this->render('/user/_login', ['model' => $model])
    ?>
</div>


<div class="order-container">

    <?php

    $form = ActiveForm::begin([
        'id' => 'reg-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'validateOnBlur' => true,
        'validateOnChange' => true,
        'validateOnSubmit' => false,
    ]);

    ?>

    <div class="row">
        <div class="col-md-6">

            <h2>Számlázási adatok</h2>

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

            <?= $form->field($felhasznaloModel, 'emelet')->textInput(['placeholder' => '']) ?>

            <?= $form->field($felhasznaloModel, 'email')->textInput(['placeholder' => '', 'readonly' => !Yii::$app->user->isGuest]) ?>

            <?= $form->field($felhasznaloModel, 'telefonszam1')->textInput() ?>

            <?= $form->field($felhasznaloModel, 'telefonszam2')->textInput() ?>

            <?php
            if (Yii::$app->user->isGuest)
                echo $form->field($felhasznaloModel, 'create_user')->checkbox()
            ?>

        </div>
        <div class="col-md-6">

            <h2>Szállítási adatok</h2>

            <?= $form->field($megrendelesModel, 'eltero_szallitasi_adatok')->radioList([
                '' => 'A szállítási cím megegyezik a számlázási címmel',
                '1' => 'Másik címre kérem a szállítást',
            ], ['class' => 'form-control'])->label(false) ?>

            <!--            --><? //= $form->field($megrendelesModel, 'eltero_szallitasi_adatok')->checkbox() ?>

            <div class="szallitas-container" style="display:none">

                <?= $form->field($megrendelesModel, 'szallitasi_nev')->textInput(['placeholder' => '']) ?>

                <?= $form->field($megrendelesModel, 'szallitasi_irszam')->textInput(['placeholder' => '']) ?>

                <div id="<?= Html::getInputId($megrendelesModel, 'szallitasi_varos') ?>-container">
                    <?= $form->field($megrendelesModel, 'szallitasi_varos')->textInput(); ?>
                </div>

                <div id="<?= Html::getInputId($megrendelesModel, 'szallitasi_id_varos') ?>-container"
                     style="display: none">
                    <?= $form->field($megrendelesModel, 'szallitasi_id_varos')->dropDownList([]) ?>
                </div>

                <?= $form->field($megrendelesModel, 'szallitasi_utcanev')->textInput(['placeholder' => '']) ?>

                <?= $form->field($megrendelesModel, 'szallitasi_emelet')->textInput(['placeholder' => ''])->label('Emelet, ajtó, egyéb...') ?>

                <?= $form->field($megrendelesModel, 'gls_kod')->hiddenInput()->label('') ?>

            </div>

        </div>
    </div>
    <div class="row">
        <div class="col">

            <h4>Kosarad tartalma</h4>
            <div class="cart-container no-cash"></div>

            <?= $form->field($megrendelesModel, 'id_szallitasi_mod')->radioList(SzallitasiMod::getData(), ['class' => 'form-control']) ?>

            <div class="gls-container" style="display: none">
                <?php
                echo GlsWidget::widget();
                ?>
            </div>

            <?= $form->field($megrendelesModel, 'id_fizetesi_mod')->radioList(FizetesiMod::getData(), ['class' => 'form-control']) ?>

            <?= $form->field($megrendelesModel, 'megjegyzes')->textarea(['placeholder' => '']) ?>

            <?= $form->field($felhasznaloModel, 'hirlevel')->checkbox() ?>

            <?= $form->field($felhasznaloModel, 'contract')->checkbox(['class' => '']) ?>

        </div>
    </div>

    <?= Html::submitButton('Megrendelés', ['class' => 'arrow_box', 'name' => 'order-button']) ?>

    <?php ActiveForm::end(); ?>

</div>