<?php

use yii\helpers\Html;
use yii\helpers\Url;

switch ($model['opcio']) {
    case 'AKCIOS':
        $model['opcio'] = 'SALE %';
        break;

    case 'UJ':
        $model['opcio'] = 'NEW ' . date('Y');
        break;
}

$termekUrl = Url::to(['termekek/view',
    'mainCategory' => $model['main_category_url_segment'],
    'subCategory' => $model['sub_category_url_segment'],
    'brand' => $model['marka_url_segment'],
    'termek' => $model['url_segment'],
    'size' => $params['meret'],
]);

?>

<div class="post product-thumb" itemprop="itemListElement" itemscope
     itemtype="http://schema.org/Product">
    <meta itemprop="position" content="<?= ($key + 1) ?>">
    <a href="<?= $termekUrl ?>" itemprop="url">
    <div class="product-thumb-bg">
        <div class="product-thumb-img-container position-relative">
            <img src="https://coreshop.hu/pictures/termekek/<?= implode('/', str_split($model['id'])) ?>/1_small.jpg"
                 alt="<?= Html::encode($model['markanev']) ?> - <?= Html::encode($model['termeknev']) ?>"
                 itemprop="image">
            <div class="overlay">

            </div>
        </div>

        <div class="product-info">
            <p class="uj text-center product-tag <?= $model['opcio'] == 'SALE %' ? Html::encode('red-color') : '' ?>" ><?//= Html::encode($model['opcio']) ?></p>
            <h2 itemprop="name"><?= Html::encode($model['markanev']) ?> <?= Html::encode($model['termeknev']) ?></h2>
            <div class="product-color"><?= Html::encode($model['szin']) ?></div>
            <div class="products-price-container" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                <?php
                if ((int)$model['akcios_kisker_ar'] > 0):
                    ?>
                    <span class="products-thumb-originalprice">
                        <del><?= \Yii::$app->formatter->asDecimal($model['kisker_ar']) ?></del>
                        Ft</span>
                    <br>
                    <span class="products-thumb-saleprise" itemprop="price"
                          content="<?= $model['akcios_kisker_ar'] ?>"><?= \Yii::$app->formatter->asDecimal($model['akcios_kisker_ar']) ?></span>
                    <span itemprop="priceCurrency" content="HUF">Ft</span>
                <?php
                endif;
                ?>

                <?php
                if (!$model['akcios_kisker_ar']):
                    ?>
                    <span itemprop="price"
                          content="<?= $model['kisker_ar'] ?>"><?= \Yii::$app->formatter->asDecimal($model['kisker_ar']) ?></span>
                    <span itemprop="priceCurrency" content="HUF">Ft</span>
                <?php
                endif;
                ?>
            </div>
        </div> <!-- //product-thumb-bg -->
    </div>
    <div class="product-hover-container">
        &nbsp; <!-- <a href="<?= $termekUrl ?>" class="btn btn-primary">Megnézem</a>-->
    </div>
    </a>
</div>