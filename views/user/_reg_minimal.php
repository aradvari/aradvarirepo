<?php

use app\assets\OrderAsset;
use app\models\Kozterulet;
use app\models\Megyek;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
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
