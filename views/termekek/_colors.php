<div class="clearfix"></div>

<?php

use app\models\TermekekSearch;
use yii\widgets\ListView;

$dataProvider = (new TermekekSearch())->search([]);
$dataProvider->query->andWhere(['t.termeknev' => $model->termeknev]);
$dataProvider->query->andWhere(['t.markaid' => $model->markaid]);
//$dataProvider->query->andWhere(['!=', 'id_termek', $model->id]);
$dataProvider->pagination = false;

if ($dataProvider->getCount() > 1):
    ?>

    <p class="text-uppercase font-weight-bold mt-3">MÉG TÖBB <?= $model->marka->markanev ?> <?= $model->termeknev ?></p>

    <?= ListView::widget([
    'dataProvider' => $dataProvider,
    'options' => ['class' => 'list-view row'],
    'itemOptions' => ['class' => 'item text-center w-25 p-2'],
    'itemView' => '_color',
    'viewParams' => ['parentModel' => $model],
    'summary' => '',
]); ?>

<?php
endif;
?>