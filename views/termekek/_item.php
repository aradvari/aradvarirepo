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
]);

?>
<div class="post product-thumb">
    <div class="product-opcio-container">
        <span class="uj"><?= Html::encode($model['opcio']) ?></span>
    </div>
    <a href="<?=$termekUrl?>">
        <img src="https://coreshop.hu/pictures/termekek/<?= implode('/', str_split($model['id'])) ?>/1_small.jpg"
             alt="<?= Html::encode($model['markanev']) ?> - <?= Html::encode($model['termeknev']) ?>">
    </a>
    <div class="product-info">
        <a href="javascript:alert('Fejlesztés alatt!')">
            <h2><?= Html::encode($model['markanev']) ?> <?= Html::encode($model['termeknev']) ?></h2>
        </a>
        <a href="javascript:alert('Fejlesztés alatt!')"><?= Html::encode($model['szin']) ?></a>
        <div class="products-prise-container">
            <?php
            if ((int)$model['akcios_kisker_ar'] > 0):
                ?>
                <span class="products-thumb-originalprice">
                    <del><?= \Yii::$app->formatter->asDecimal($model['kisker_ar']) ?></del>
                    Ft</span>
                <br>
                <span class="products-thumb-saleprise"><?= \Yii::$app->formatter->asDecimal($model['akcios_kisker_ar']) ?>
                    Ft</span>
            <?php
            endif;
            ?>

            <?php
            if (!$model['akcios_kisker_ar']):
                ?>
                <span><?= \Yii::$app->formatter->asDecimal($model['kisker_ar']) ?> Ft</span>
            <?php
            endif;
            ?>
        </div>
    </div>
</div>