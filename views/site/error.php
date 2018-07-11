<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
$this->title = "404";
$message = "A keresett oldal nem található!";
?>
<div class="site-error">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <div class="alert alert-danger" style="text-align:center;margin-top:10px">
	<img src="../images/404-sad.png" alt="A keresett oldal nem található :(" style="max-width:100px;"; />
	<h1 style="background:none; margin:0;"><?= Html::encode($this->title) ?></h1>
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        ‹ <a href="/">Vissza a kezdőoldalra</a>
    </p>

</div>
