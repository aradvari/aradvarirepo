<?php

use app\models\TermekekSearch;
use yii\widgets\ListView;

$dataProvider = (new TermekekSearch())->search([]);
$dataProvider->pagination = false;
$dataProvider->query->andWhere(['t.id' => $history]);
$dataProvider->query->limit(5);
$dataProvider->query->orderBy('rand()');

?>

<div class="content-right-headline" style="clear:both;">Legutóbb megtekintett termékek</div>

<div class="ajanlo-container">

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_item',
        'summary' => '',
    ]); ?>
    <div style="clear: both"></div>
</div>
