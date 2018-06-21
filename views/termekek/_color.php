<?php

use yii\helpers\Html;
use yii\helpers\Url;

$termekUrl = Url::to(['termekek/view',
    'mainCategory' => $model['main_category_url_segment'],
    'subCategory' => $model['sub_category_url_segment'],
    'brand' => $model['marka_url_segment'],
    'termek' => $model['url_segment'],
]);

?>

<a href="<?= $termekUrl ?>" data-slug="<?= $model['url_segment'] ?>" data-url="<?= $termekUrl ?>">
    <img src="https://coreshop.hu/pictures/termekek/<?= implode('/', str_split($model['id'])) ?>/1_small.jpg"
         alt="<?= Html::encode($model['markanev']) ?> - <?= Html::encode($model['termeknev']) ?>"
         class="w-100 img-fluid color-img <?= $parentModel->getPrimaryKey() == $model['id'] ? 'active' : '' ?>">
</a>