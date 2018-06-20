<?php

use yii\widgets\ListView;

?>

<!-- Brands -->
<section class="white-bg pt-3 product-list-container">
    <div class="container">
        <div id="productList">
            <!--            <div class="carousel-inner row w-100 mx-auto" role="listbox">-->
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'options' => ['class' => 'slider2 row carousel-inner'],
                'itemOptions' => function ($model, $key, $index, $widget) {
                    return ['class' => 'item text-center' . ($key == 0 ? '' : '')];
                },
                'itemView' => '_item',
                'summary' => '',
            ]); ?>
           
        </div>
    </div>
</section>
<!-- //brands -->
