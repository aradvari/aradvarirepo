<?php

use yii\helpers\Url;

?>
<p>Szia!</p>

<p>A Coreshop.hu on-line áruházunkban a hírlevél leiratkozási igényedet sikeresen teljesítettük.</p>

<p>Amennyiben meggondolnád magad, az alábbi linkre kattintva újra aktíválhatod szolgáltatásunkat:</p>

<a href="https://coreshop.hu<?= Url::to(['/user/subscribe', 'email' => $model->email, 'code' => $model->aktivacios_kod]) ?>">Újra
    szeretnék Coreshop-hu hírleveleket kapni!</a>