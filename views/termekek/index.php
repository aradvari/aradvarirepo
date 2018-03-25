<?php

use kop\y2sp\ScrollPager;
use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TermekekSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

foreach ($params as $key => $param) {
    if ($param) {
        switch ($key) {

            case "mainCategory":
                $label = $mainCategoryModel->megnevezes;
                break;
            case "subCategory":
                $label = $subCategoryModel->megnevezes;
                break;
            case "brand":
                $label = $brandModel->markanev;
                break;
            case "meret":
                $label = $sizeModel->megnevezes;
                break;
            case "szin":
                $label = $colorModel->szinszuro;
                break;

        }

        $bc[$key] = $param;
        $this->params['breadcrumbs'][] = ['label' => $label, 'url' => $bc];
    }
}

?>
<div class="termekek-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', [
        'model' => $searchModel,
        'dataProvider' => $dataProvider,
        'mainCategoryDataProvider' => $mainCategoryDataProvider,
        'subCategoryDataProvider' => $subCategoryDataProvider,
        'brandDataProvider' => $brandDataProvider,
        'sizeDataProvider' => $sizeDataProvider,
        'colorDataProvider' => $colorDataProvider,
        'params' => $params,
    ]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'options' => ['class' => 'list-view row'],
        'itemOptions' => ['class' => 'item col-xl-2 col-lg-3 col-md-3 col-sm-3 col-6 text-center'],
        'itemView' => '_item',
        'viewParams' => ['params' => $params],
        'pager' => [
            'class' => ScrollPager::className(),
            'triggerOffset' => 10,
            'noneLeftText' => '',
            'spinnerTemplate' => '<div class="col-12 text-center p-3"><img src="{src}"/> További termékek betöltése...</div>',
        ],
        'summary' => '',
    ]); ?>
</div>