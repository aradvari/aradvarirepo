<?php

use luya\bootstrap4\ActiveForm;
use yii\helpers\Html;

?>

<div class="registration">

    <h2>Regisztráció</h2>

    <?php

    $form = ActiveForm::begin([
        'id' => 'reg-form',
    ]);

    ?>

    <?= $form->field($model, 'vezeteknev')->textInput()?>
    <?= $form->field($model, 'keresztnev')->textInput()?>

    <?= $form->field($model, 'email')->textInput() ?>

    <?= Html::submitButton('Regisztráció', ['class' => 'arrow_box', 'name' => 'reg-button']) ?>

    <?php ActiveForm::end(); ?>

</div>
