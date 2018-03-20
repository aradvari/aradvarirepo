<?php

use app\models\TermekekSearch;
use yii\widgets\ListView;

$dataProvider = (new TermekekSearch())->search(['subCategory' => $subCategory]);
$dataProvider->pagination = false;
$dataProvider->query->limit(5);
$dataProvider->query->orderBy('rand()');

?>

<div class="content-right-headline" style="clear:both;">Termékajánló</div>

<div class="ajanlo-container">

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_item',
        'summary' => '',
    ]); ?>
    <div style="clear: both"></div>
</div>
