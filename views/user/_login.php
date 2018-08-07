<?php

use yii\helpers\Url;
use luya\bootstrap4\ActiveForm;
use yii\helpers\Html;

?>
<!--<div class="row row-eq-height">
    <div class="login align-self-center col-6 alice-blue-bg padding-20">

        <h2 class="text-left">Bejelentkezés</h2>

        <div class="">
            <div class="row justify-content-center">
                <div class="col-8">
                    <?php

                    $form = ActiveForm::begin([
                        'id' => 'login-form',
                    ]); ?>

                    <?= $form->field($model, 'username')->textInput() ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <?= $form->field($model, 'rememberMe')->checkbox() ?>
                    <a href="<?= Url::to(['/site/lost-password']) ?>">Elfelejtetted a jelszavadat?</a>
                    <?= Html::submitButton('Login', ['class' => 'arrow_box btn btn-primary float-right', 'name' => 'login-button']) ?>

                    <?php ActiveForm::end(); ?>
                    <div class="clearfix"></div>
                    <hr>
                    <p class="text-center font-weight-bold margin-top-20 ">Bejelentkezés Facebook vagy Google segítségével:</p>
                    <?= yii\authclient\widgets\AuthChoice::widget([
                        'baseAuthUrl' => ['site/auth'],
                        'popupMode' => false,
                    ]) ?>

                </div>
            </div>

        </div>
    </div>
    <div class="col-6">
        <img src="/images/photos/vans_color.jpg" class="img-fluid" alt="Bejelentkezés">
    </div>
</div>-->

<div class="alice-blue-bg mt-3 p-4">
    <div class="login">

        <h2 class="text-left">Bejelentkezés</h2>
            <?php
            $form = ActiveForm::begin([
                'id' => 'login-form',
            ]); ?>
            <div class="row  align-items-center">
                <div class="col-6 col-md-3">
                     <?= $form->field($model, 'username')->textInput() ?>
                </div>

                <div class="col-6 col-md-3">
                    <?= $form->field($model, 'password')->passwordInput() ?>
                </div>

                <div class="col-6 col-md-3">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-login', 'name' => 'login-button']) ?>
                </div>
                <div class="col-6 col-md-3 align-self-center">
                    <?= $form->field($model, 'rememberMe')->checkbox() ?>
                    <a href="<?= Url::to(['/site/lost-password']) ?>">Elfelejtetted a jelszavadat?</a>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
            <div class="clearfix"></div>
            <div class="row justify-content-start align-items-center">
            </div>
    </div> 
</div>

