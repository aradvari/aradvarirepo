<?php

use yii\widgets\ListView;

?>

<!-- Brands -->
<section class="container-fluid product-list-container">
    <div id="productList" class="carousel slide row alice-blue-bg" data-ride="carousel" data-interval="9000">
        <!--            <div class="carousel-inner row w-100 mx-auto" role="listbox">-->
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'options' => ['class' => 'carousel-inner row w-100 mx-auto', 'role' => 'listbox'],
            'itemOptions' => function ($model, $key, $index, $widget) {
                return ['class' => 'carousel-item col-md-3 text-center ' . ($key == 0 ? 'active' : '')];
            },
            'itemView' => '_item',
            'summary' => '',
        ]); ?>
        <a class="carousel-control-prev" href="#productList" role="button" data-slide="prev">
            <i class="fa fa-chevron-left fa-lg text-muted"></i>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next text-faded" href="#productList" role="button" data-slide="next">
            <i class="fa fa-chevron-right fa-lg text-muted"></i>
            <span class="sr-only">Next</span>
        </a>
    </div>
</section>
<!-- //brands -->
