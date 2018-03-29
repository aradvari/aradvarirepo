<?php

use kop\y2sp\ScrollPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TermekekSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $mainCategoryModel->megnevezes . ' ' . $subCategoryModel->megnevezes . ' ' . $brandModel->markanev . ' ' . $sizeModel->megnevezes . ' ' . $colorModel->szinszuro . ' ' . $tipusModel->tipus;
$description = $this->title;
$keywords = $this->title;
$image = Url::to('/images/coreshop-logo-social.png', true);

//SEO DEFAULT
Yii::$app->seo->registerMetaTag(['name' => 'description', 'content' => $description]);
Yii::$app->seo->registerMetaTag(['name' => 'keywords', 'content' => $keywords]);
Yii::$app->seo->registerMetaTag(['itemprop' => 'name', 'content' => $this->title]);
Yii::$app->seo->registerMetaTag(['itemprop' => 'description', 'content' => $description]);
Yii::$app->seo->registerMetaTag(['itemprop' => 'image', 'content' => $image]);
//SEO OPEN GRAPH
Yii::$app->seo->registerMetaTag(['property' => 'og:title', 'content' => $this->title]);
Yii::$app->seo->registerMetaTag(['property' => 'og:type', 'content' => 'article']);
Yii::$app->seo->registerMetaTag(['property' => 'og:url', 'content' => Url::current([], true)]);
Yii::$app->seo->registerMetaTag(['property' => 'og:image', 'content' => $image]);
Yii::$app->seo->registerMetaTag(['property' => 'og:description', 'content' => $description]);
Yii::$app->seo->registerMetaTag(['property' => 'og:site_name', 'content' => 'Coreshop']);
Yii::$app->seo->registerMetaTag(['property' => 'article:section', 'content' => 'fashion']);
Yii::$app->seo->registerMetaTag(['property' => 'article:tag', 'content' => $keywords]);
Yii::$app->seo->registerMetaTag(['property' => 'fb:app_id', 'content' => '550827275293006']);

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
            case "tipus":
                $label = $tipusModel->tipus;
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
                'typeDataProvider' => $typeDataProvider,
                'params' => $params,
            ]); ?>
        </div> <!-- //left col -->
        <div class="col-9">
            <?= ListView::widget([
                'id' => 'product-list',
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