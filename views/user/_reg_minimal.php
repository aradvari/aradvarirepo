<?php

use luya\bootstrap4\ActiveForm;
use yii\helpers\Html;

?>

<div class="registration py-3">

    <h1>Regisztráció</h1>

    <?php

    $form = ActiveForm::begin([
        'id' => 'reg-form',
    ]);

    ?>

    <div class="row justify-content-between">
        <?= $form->field($model, 'vezeteknev', ['options' => ['class' => 'form-group register-input']])->textInput()?> 
        <?= $form->field($model, 'keresztnev', ['options' => ['class' => 'form-group register-input mr-3']])->textInput()?>
    </div>
    
    <div class="row">
        <?= $form->field($model, 'email', ['options' => ['class' => 'form-group register-email-input mr-3']])->textInput() ?>
    </div>

    <div class="row">
        <?= Html::submitButton('Regisztráció', ['class' => 'arrow_box btn btn-primary', 'name' => 'reg-button']) ?>
    </div>
    

    <?php ActiveForm::end(); ?>

</div>
