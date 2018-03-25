<?php

use kop\y2sp\ScrollPager;
use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TermekekSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<?php
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

<!--<div class="container">
    <h1><?= $subCategoryModel->megnevezes ?></h1>
</div>-->
<div class="container-fluid termekek-index">
    <div class="row">
        <div class="col">
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
        </div> <!-- //left col -->
        <div class="col-9">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'options' => ['class' => 'list-view row'],
        'itemOptions' => ['class' => 'item col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6 text-center'],
        'itemView' => '_item',
        'viewParams' => ['params' => $params],
        'pager' => [
            'class' => ScrollPager::className(),
            'triggerOffset' => 10,
            'noneLeftText' => '',
            'spinnerTemplate' => '<div class="more-products-text col-12 text-center p-3"><img src="{src}"/> További termékek betöltése...</div>',
        ],
        'summary' => '',
    ]); ?>
        </div> <!-- //right col -->
    </div> <!-- //row-->
</div> <!-- //container -->