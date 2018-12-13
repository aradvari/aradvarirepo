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
    <div class="container">

        <?php
        if (Yii::$app->user->isGuest)
            echo $this->render('/user/_login', ['model' => $model])
        ?>
    </div>


    <div class="order-container container p-4">

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

        <div class="row mt-5">
            <div class="col-md-6 font-weight-bold">

                <h2 class="text-left">Számlázási adatok</h2>

                <div class="row">
                    <div class="col">
                        <?= $form->field($felhasznaloModel, 'vezeteknev')->textInput(['placeholder' => '']) ?>
                    </div>
                    <div class="col">
                        <?= $form->field($felhasznaloModel, 'keresztnev')->textInput(['placeholder' => '']) ?>
                    </div>
                </div>

                <?= $form->field($felhasznaloModel, 'cegnev')->textInput(['placeholder' => '']) ?>

                <div class="row">
                    <div class="col">
                        <?= $form->field($felhasznaloModel, 'irszam')->textInput(['placeholder' => '']) ?>
                    </div>
                    <div class="col">
                        <div id="<?= Html::getInputId($felhasznaloModel, 'varos_nev') ?>-container">
                            <?= $form->field($felhasznaloModel, 'varos_nev')->textInput(); ?>
                        </div>
                        <div id="<?= Html::getInputId($felhasznaloModel, 'id_varos') ?>-container"
                             style="display: none">
                            <?= $form->field($felhasznaloModel, 'id_varos')->dropDownList([]) ?>
                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-12 col-md">
                        <?= $form->field($felhasznaloModel, 'utcanev')->textInput(['placeholder' => '']) ?>
                    </div>
                    <div class="col">
                        <?= $form->field($felhasznaloModel, 'id_kozterulet')->dropDownList(ArrayHelper::map(Kozterulet::find()->all(), 'id_kozterulet', 'megnevezes'), ['prompt' => 'Válassz...']) ?>
                    </div>
                    <div class="col">
                        <?= $form->field($felhasznaloModel, 'hazszam')->textInput(['placeholder' => '']) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <?= $form->field($felhasznaloModel, 'emelet')->textInput(['placeholder' => '']) ?>
                    </div>
                </div>


                <?= $form->field($felhasznaloModel, 'email')->textInput(['placeholder' => '', 'readonly' => !Yii::$app->user->isGuest]) ?>

                <div class="row">
                    <div class="col">
                        <?= $form->field($felhasznaloModel, 'telefonszam1')->textInput() ?>
                    </div>
                    <div class="col">
                        <?= $form->field($felhasznaloModel, 'telefonszam2')->textInput() ?>
                    </div>
                </div>

                <?php
                if (Yii::$app->user->isGuest)
                    echo $form->field($felhasznaloModel, 'create_user')->checkbox()
                ?>

            </div>
            <div class="col-md-6 radio-container">

                <h2 class="text-left" style="margin-bottom: 1.89em">Szállítási adatok</h2>

                <!--<?= $form->field($megrendelesModel, 'eltero_szallitasi_adatok')->radioList([
                    '' => 'A szállítási cím megegyezik a számlázási címmel',
                    '1' => 'Másik címre kérem a szállítást',
                ])->label(false) ?>-->

                <ul>
                    <li>
                        <input type="radio" id="111" name="MegrendelesFej[eltero_szallitasi_adatok]" value checked>
                        <label for="111">A szállítási cím megegyezik a számlázási címmel</label>
                        <div class="check"></div>
                    </li>

                    <li>
                        <input type="radio" id="222" name="MegrendelesFej[eltero_szallitasi_adatok]" value="1">
                        <label for="222">Másik címre kérem a szállítást</label>
                        <div class="check">
                            <div class="inside"></div>
                    </li>

                </ul>


                <!--            --><? //= $form->field($megrendelesModel, 'eltero_szallitasi_adatok')->checkbox() ?>

                <div class="szallitas-container font-weight-bold" style="display:none">
                    <label>Szállítási cím </label>
                    <?= $form->field($megrendelesModel, 'szallitasi_nev')->textInput(['placeholder' => '']) ?>
                    <div class="row">
                        <div class="col">
                            <?= $form->field($megrendelesModel, 'szallitasi_irszam')->textInput(['placeholder' => '']) ?>
                        </div>
                        <div class="col">
                            <div id="<?= Html::getInputId($megrendelesModel, 'szallitasi_varos') ?>-container">
                                <?= $form->field($megrendelesModel, 'szallitasi_varos')->textInput(); ?>
                            </div>

                            <div id="<?= Html::getInputId($megrendelesModel, 'szallitasi_id_varos') ?>-container"
                                 style="display: none">
                                <?= $form->field($megrendelesModel, 'szallitasi_id_varos')->dropDownList([]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md">
                            <?= $form->field($megrendelesModel, 'szallitasi_utcanev')->textInput(['placeholder' => '']) ?>
                        </div>
                        <div class="col-12 col-md">
                            <?= $form->field($megrendelesModel, 'szallitasi_emelet')->textInput(['placeholder' => ''])->label('Emelet, ajtó, egyéb...') ?>
                        </div>
                    </div>


                    <?= $form->field($megrendelesModel, 'gls_kod')->hiddenInput()->label('') ?>
                    <?= $form->field($megrendelesModel, 'gls_adatok')->hiddenInput()->label('') ?>

                </div>

            </div>


            <div class="col-md-6 radio-container" id="transfer-type">
                <!-- <?= $form->field($megrendelesModel, 'id_szallitasi_mod')->radioList(SzallitasiMod::getData()) ?>  -->
                <ul>
                    <li>
                        <input type="radio" id="1" name="MegrendelesFej[id_szallitasi_mod]" value="1" checked="">
                        <label for="1">Csomagküldő szolgálattal</label>
                        <div class="check"></div>
                    </li>

                    <li>
                        <input type="radio" id="2" name="MegrendelesFej[id_szallitasi_mod]" value="3">
                        <label for="2">GLS csomagpontba</label>
                        <div class="check">
                            <div class="inside"></div>
                    </li>

                    <li>
                        <input type="radio" id="3" name="MegrendelesFej[id_szallitasi_mod]" value="2">
                        <label for="3">Személyes átvétel irodánkban</label>
                        <div class="check">
                            <div class="inside"></div>
                    </li>
                </ul>
            </div>

            <div class="col-md-6 radio-container">
                <ul>
                    <li>
                        <input type="radio" id="11" name="MegrendelesFej[id_fizetesi_mod]" value="1" checked="">
                        <label for="11"> Átvételkor készpénzben vagy bankkártyával</label>
                        <div class="check"></div>
                    </li>

                    <li>
                        <input type="radio" id="22" name="MegrendelesFej[id_fizetesi_mod]" value="2">
                        <label for="22">Bankártya (CIB)</label>
                        <div class="check">
                            <div class="inside"></div>
                    </li>

                </ul>
                <!--<?= $form->field($megrendelesModel, 'id_fizetesi_mod')->radioList(FizetesiMod::getData()) ?> -->
            </div>
        </div>
        <div class="gls-container" style="display: none;">
            <?php
            echo GlsWidget::widget();
            ?>
        </div>

        <div class="row align-items-end">
            <div class="col-12 col-md">
                <?= $form->field($megrendelesModel, 'megjegyzes')->textarea(['placeholder' => '']) ?>
            </div>
            <div class="col-12 col-md">
                <!-- <?= $form->field($felhasznaloModel, 'hirlevel')->checkbox() ?> -->
                <!--<div class="form-group field-felhasznalok-hirlevel required validating">

                <input type="hidden" name="Felhasznalok[hirlevel]" value="0"><label><input type="checkbox" id="felhasznalok-hirlevel" name="Felhasznalok[hirlevel]" value="1" aria-required="true" aria-invalid="false" class="is-valid"> Feliratkozom a hírlevélre</label>

                <div class="invalid-feedback"></div>
                </div>-->

                <label class="checkbox-container"> Feliratkozom a hírlevélre
                    <input type="hidden" name="Felhasznalok[hirlevel]" value="0">
                    <input type="checkbox" id="felhasznalok-hirlevel" name="Felhasznalok[hirlevel]" value="1"
                           aria-required="true" aria-invalid="false" class="is-valid">
                    <span class="checkmark"></span>
                </label>

                <label class="checkbox-container"> Elfogadom az általános szerződési feltételeket
                    <input type="hidden" name="Felhasznalok[contract]" value="0">
                    <input type="checkbox" id="felhasznalok-contract" class="" name="Felhasznalok[contract]" value="1"
                           checked="" aria-required="true">
                    <span class="checkmark"></span>
                </label>

                <!--<div class="form-group field-felhasznalok-contract required">

                <input type="hidden" name="Felhasznalok[contract]" value="0"><label><input type="checkbox" id="felhasznalok-contract" class="" name="Felhasznalok[contract]" value="1" checked="" aria-required="true"> Elfogadom az általános szerződési feltételeket</label>

                <div class="invalid-feedback"></div>
                </div>-->
                <!--<?= $form->field($felhasznaloModel, 'contract')->checkbox(['class' => '']) ?>-->

                <?= Html::submitButton('Megrendelés elküldése', ['class' => 'arrow_box', 'name' => 'order-button', 'id' => 'send-order-button']) ?>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col">
                <h1>Kosarad tartalma</h1>
                <div class="cart-container no-cash"></div>
            </div>
        </div>


    </div>


<?php ActiveForm::end(); ?>

    </div>

<?php
$this->registerJS(<<<JS
fbq('track', 'InitiateCheckout');
JS
);