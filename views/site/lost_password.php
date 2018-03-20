<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<div class="login">

    <h2>Elfelejtett jelszó</h2>

    <p>Add meg a lenti űrlapon az e-mail címedet, mi meg kiküldünk neked egy új jelszót!</p>

    <?php

    $form = ActiveForm::begin([
        'id' => 'login-form',
    ]); ?>

    <?= $form->field($model, 'username')->textInput() ?>

    <?= Html::submitButton('Küldés', ['class' => 'arrow_box', 'name' => 'login-button']) ?>

    <?php ActiveForm::end(); ?>

</div>