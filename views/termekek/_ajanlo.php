<?php

use app\models\TermekekSearch;
use yii\widgets\ListView;

$dataProvider = (new TermekekSearch())->search(['q' => $model->termeknev, 'subCategory'=>$model->defaultSubCategory->url_segment]);
$dataProvider->pagination = false;
$dataProvider->query->andWhere(['!=', 'id_termek', $model->id]);
$dataProvider->query->limit(10);
$dataProvider->query->orderBy('rand()');

if ($dataProvider->getCount() < 1)
    return false;
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
