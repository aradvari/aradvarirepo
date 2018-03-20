<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
?>

<div class="row">

    <div class="col-md-6">
        <?= $this->render('/user/_login', ['model' => $model]) ?>
    </div>

    <div class="col-md-6">
        <?= $this->render('/user/_reg_minimal', ['model' => $felhasznaloModel]) ?>
    </div>

</div>