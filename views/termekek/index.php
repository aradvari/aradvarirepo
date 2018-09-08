<?php

use kop\y2sp\ScrollPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use app\widgets\Seo;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TermekekSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = ucfirst(strtolower(trim(
        ($brandModel->markanev ? ' ' . $brandModel->markanev : null) .
        ($subCategoryModel->megnevezes ? ' ' . $subCategoryModel->megnevezes : ' ' . $mainCategoryModel->megnevezes) .
        ($sizeModel->megnevezes ? ' ' . $sizeModel->megnevezes . ' méret' : null) .
        ($colorModel->szinszuro ? ' ' . ($colorModel->szinszuro) . ' szín' : null) .
        ($tipusModel->tipus ? ' ' . ($tipusModel->tipus) . ' típus' : null) .
        ($params['q'] ? ', ' . $params['q'] : null), ', '))) . ' - Coreshop.hu';

$h1Options = (($sizeModel->megnevezes || $colorModel->szinszuro || $tipusModel->tipus || $params['q']) &&
    (($brandModel->markanev || $subCategoryModel->megnevezes)) ? ' (' : null) .
    trim(($sizeModel->megnevezes ? ', méret: ' . $sizeModel->megnevezes : null) .
        ($colorModel->szinszuro ? ', szín: ' . ($colorModel->szinszuro) : null) .
        ($tipusModel->tipus ? ', típus: ' . ($tipusModel->tipus) : null) .
        ($params['q'] ? ', egyedi keresés: ' . $params['q'] : null), ', ') .
    (($sizeModel->megnevezes || $colorModel->szinszuro || $tipusModel->tipus || $params['q']) &&
    (($brandModel->markanev || $subCategoryModel->megnevezes)) ? ')' : null);

$h1 = ucfirst(trim(
        strtolower($mainCategoryModel->megnevezes ? ' ' . $mainCategoryModel->megnevezes . ':' : null) .
        ($brandModel->markanev ? ' ' . $brandModel->markanev : null) .
        strtolower($subCategoryModel->megnevezes ? ' ' . $subCategoryModel->megnevezes : null)
    )) . $h1Options;

$description = 'Termékek listája az alábbiak szerint: ' . trim(
        ($mainCategoryModel->megnevezes ? ', főkategória: ' . $mainCategoryModel->megnevezes : null) .
        ($subCategoryModel->megnevezes ? ', alkategória: ' . $subCategoryModel->megnevezes : null) .
        ($brandModel->markanev ? ', gyártó: ' . $brandModel->markanev : null) .
        ($sizeModel->megnevezes ? ', méret: ' . $sizeModel->megnevezes : null) .
        ($colorModel->szinszuro ? ', szín: ' . $colorModel->szinszuro : null) .
        ($tipusModel->tipus ? ', típus: ' . $tipusModel->tipus : null) .
        ($params['q'] ? ', egyxedi szűrés: ' . $params['q'] : null), ', ');
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
Yii::$app->seo->registerMetaTag(['property' => 'og:type', 'content' => 'product']);
Yii::$app->seo->registerMetaTag(['property' => 'og:url', 'content' => Url::current([], true)]);
Yii::$app->seo->registerMetaTag(['property' => 'og:image', 'content' => $image]);
Yii::$app->seo->registerMetaTag(['property' => 'og:description', 'content' => $description]);
Yii::$app->seo->registerMetaTag(['property' => 'og:site_name', 'content' => 'Coreshop.hu']);
Yii::$app->seo->registerMetaTag(['property' => 'fb:app_id', 'content' => '550827275293006']);

?>

<? if ($this->title) {
	echo '<div class="container">
		<h1 id="title">' . Html::encode($h1) . '</h1>
	</div>';
} ?>


<!--<script type="text/javascript">
// Changing the h1 title second word color to blue if it has more than 2 word
    var titleElement = document.getElementById('title');
    var title = document.getElementById('title').innerText;
    var titleArray = title.split(' ');
    if (titleArray.length > 1) {
        titleElement.innerHTML = `${titleArray[0]} <span style=\"color:#2A87E4\"> ${titleArray[1]} </span>`;
    }

// Temporary solution - changing h1 with breadcrumbs
    var h1 = document.getElementById('title');
    var tempHeader = document.getElementById('temp-header');
    tempHeader.appendChild(h1);
</script>-->

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
            default:
                $label = null;

        }

        $bc[$key] = $param;

        if ($label)
            $this->params['breadcrumbs'][] = ['label' => $label, 'url' => $bc];

    }
}
?>
<div class="col-12 hidden-md-up">
    <p class="text-left charcoal"><span class="blue"><?= $dataProvider->getTotalCount() ?></span> termék</p>
</div>

<?php
if ($brandLayout)
    echo $this->render('_brand', ['brandModel' => $brandModel]);
?>

<div class="container termekek-index" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="row">
        <div class="col-lg-3 col-md-4 col-12">
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

        <div class="col-lg-9 col-md-8 col-12 product-list">

            <?php

            $dependency = [
                'class' => '\yii\caching\FileDependency',
                'fileName' => Yii::$app->getBasePath() . '/views/termekek/texts/' . $fileName . '.php',
            ];

            if ($this->beginCache($id, ['dependency' => $dependency])) {

                try {
                    $fileName = str_replace(['/', '-'], ['_', '_'], trim(Yii::$app->request->url, '/'));
                    echo $this->render('/termekek/texts/_' . $fileName);
                } catch (Exception $e) {

                }

                $this->endCache();
            }

            ?>
            <? // szezonalis banner, pl sulikezdesre
			/*
            <!-- banner listview desktop -->
            <div class="col-md-12 col-12 banner-listview-desktop">
                <a href="/kiegeszito/taska">
                    <img src="/images/banner-listview/2018/20180808-vans-taskak-desk.jpg"
                         style="width:100%;" alt="Vans táskák a sulikezdésre"/>
                </a>
            </div>

            <!-- banner listview mobile -->
            <div class="col-md-12 col-12 banner-listview-mobile">
                <a href="/kiegeszito/taska">
                    <img src="/images/banner-listview/2018/20180808-vans-taskak-mobile.jpg"
                         style="width:100%;" alt="Vans táskák a sulikezdésre"/>
                </a>
            </div> */ ?>

            <form class="clearfix" method="get" id="order-form"
                  action="<?= Url::to([
                      'termekek/index',
                      'mainCategory' => $params['mainCategory'],
                      'subCategory' => $params['subCategory'],
                      'brand' => $params['brand'],
                      'meret' => $params['meret'],
                      'szin' => $params['szin'],
                  ]) ?>">
                <?php
                if (ArrayHelper::getValue($params, 'q'))
                    echo Html::hiddenInput('q', $params[q]);
                ?>
                <div class="filter-topnav row justify-content-around  hidden-md-down">
                    <div class="col-md-5 col-12">
                        <p class="text-left charcoal"><span class="blue" itemprop="numberOfItems"><?= $dataProvider->getTotalCount() ?></span> termék</p>
                    </div>
                    <div class="col-3 offset-3">
                        <select name="s" class="form-control custom-select">
                            <option value="leguljabb-elol" <?= $params['s'] == 'leguljabb-elol' ? 'selected' : '' ?>>Újdonságok</option>
                            <option value="ar-szerint-csokkeno" <?= $params['s'] == 'ar-szerint-csokkeno' ? 'selected' : '' ?>>Ár szerint csökkenő</option>
                            <option value="ar-szerint-novekvo" <?= $params['s'] == 'ar-szerint-novekvo' ? 'selected' : '' ?>>Ár szerint növekvő</option>
                        </select>
                    </div>


                </div>
            </form>

            <?= ListView::widget([
                'id' => 'product-list',
                'dataProvider' => $dataProvider,
                'options' => ['class' => 'list-view row', 'itemscope' => '', 'itemtype' => 'http://schema.org/ItemList'],
                'itemOptions' => ['class' => 'item col-xl-4 col-lg-4 col-md-6 col-sm-6  col-6 text-center'],
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