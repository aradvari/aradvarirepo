<?php

use app\models\TermekekSearch;
use yii\widgets\ListView;

$dataProvider = (new TermekekSearch())->search([]);
$dataProvider->pagination = false;
$dataProvider->query->andWhere(['t.id' => $history]);
if ($model)
    $dataProvider->query->andWhere(['!=', 't.id', $model->getPrimaryKey()]);
$dataProvider->query->limit(10);
//$dataProvider->query->orderBy('FIELD(t.id, 3, 11, 7, 1)');

if ($dataProvider->getCount()):
    ?>

    <h2 class="text-center margin-top-20">Legutóbb megtekintett <span class="blue">termékek</span></h2>

    <section class="white-bg pt-3 product-list-container">
        <div class="container">
            <div id="productList">
                <!--            <div class="carousel-inner row w-100 mx-auto" role="listbox">-->
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'options' => ['class' => 'slider row carousel-inner'],
                    'itemOptions' => function ($model, $key, $index, $widget) {
                        return ['class' => 'item text-center ' . ($key == 0 ? '' : '')];
                    },
                    'itemView' => '_item',
                    'summary' => '',
                ]); ?>

            </div>
        </div>
    </section>
<?php
endif;
?>
