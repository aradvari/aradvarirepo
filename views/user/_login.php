<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<div class="login">

    <h2>Bejelentkezés</h2>

    <?php

    $form = ActiveForm::begin([
        'id' => 'login-form',
    ]); ?>

    <?= $form->field($model, 'username')->textInput() ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'rememberMe')->checkbox() ?>

    <?= Html::submitButton('Login', ['class' => 'arrow_box', 'name' => 'login-button']) ?>

    <?php ActiveForm::end(); ?>

</div>

<a href="<?= Url::to(['/site/lost-password']) ?>">Elfelejtetted a jelszavadat?</a>

<div class="media-login-container">
    <p>Bejelentkezés Facebook vagy Google segítségével:</p>
    <?= yii\authclient\widgets\AuthChoice::widget([
        'baseAuthUrl' => ['site/auth'],
        'popupMode' => false,
    ]) ?>
</div>