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
        'options' => ['class' => 'list-view row'],
        'itemOptions' => ['class' => 'item col-xl-2 col-lg-3 col-md-3 col-sm-3 col-6 text-center'],
        'itemView' => '_item',
        'summary' => '',
    ]); ?>
    <div style="clear: both"></div>
</div>
