<?

use app\assets\TermekAsset;
use app\components\helpers\Coreshop;
use app\models\GlobalisAdatok;
use app\models\TermekekSearch;
use kartik\rating\StarRating;
use yii\bootstrap\Carousel;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

TermekAsset::register($this);

$this->params['breadcrumbs'] = [
    ['label' => ArrayHelper::getValue($model, 'defaultSubCategory.parentCategory.megnevezes'), 'url' => [
        'termekek/index',
        'mainCategory' => ArrayHelper::getValue($model, 'defaultSubCategory.parentCategory.url_segment'),
    ]],
    ['label' => ArrayHelper::getValue($model, 'defaultSubCategory.megnevezes'), 'url' => [
        'termekek/index',
        'mainCategory' => ArrayHelper::getValue($model, 'defaultSubCategory.parentCategory.url_segment'),
        'subCategory' => ArrayHelper::getValue($model, 'defaultSubCategory.url_segment'),
    ]],
    ['label' => ArrayHelper::getValue($model, 'marka.markanev'), 'url' => [
        'termekek/index',
        'mainCategory' => ArrayHelper::getValue($model, 'defaultSubCategory.parentCategory.url_segment'),
        'subCategory' => ArrayHelper::getValue($model, 'defaultSubCategory.url_segment'),
        'brand' => ArrayHelper::getValue($model, 'marka.url_segment'),
    ]],
];
$this->title = $model->marka->markanev . ' ' . $model->termeknev . ' ' . $model->szin;
$description = $model->leiras ? $model->leiras : $this->title;
$keywords = $model->defaultMainCategory->megnevezes . ' ' . $model->defaultSubCategory->megnevezes . ' ' . $model->marka->markanev . ' ' . $model->termeknev . ' ' . $model->szin;
$image = Url::to($model->defaultImage->webUrl, true);

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
Yii::$app->seo->registerMetaTag(['property' => 'og:image:alt', 'content' => $this->title]);
Yii::$app->seo->registerMetaTag(['property' => 'og:image:width', 'content' => $model->defaultImage->sizes[0]]);
Yii::$app->seo->registerMetaTag(['property' => 'og:image:height', 'content' => $model->defaultImage->sizes[0]]);

Yii::$app->seo->registerMetaTag(['property' => 'og:description', 'content' => $description]);
Yii::$app->seo->registerMetaTag(['property' => 'og:site_name', 'content' => 'Coreshop']);

Yii::$app->seo->registerMetaTag(['property' => 'product:price:amount', 'content' => $model->vegleges_ar]);
Yii::$app->seo->registerMetaTag(['property' => 'product:price:currency', 'content' => 'HUF']);
if ($model->keszlet)
    Yii::$app->seo->registerMetaTag(['property' => 'product:availability', 'content' => 'instock']);
else
    Yii::$app->seo->registerMetaTag(['property' => 'product:availability', 'content' => 'out of stock']);
Yii::$app->seo->registerMetaTag(['property' => 'product:condition', 'content' => 'new']);
Yii::$app->seo->registerMetaTag(['property' => 'product:retailer_item_id', $model->id]);
if ($model->szinszuro)
    Yii::$app->seo->registerMetaTag(['property' => 'product:color', $model->szinszuro]);

Yii::$app->seo->registerMetaTag(['property' => 'fb:app_id', 'content' => '550827275293006']);


?>

    <!-- THUMB, MAINIMAGE, INFOBOX container -->
    <div class="product-container container">

        

        <div class="row">
            <div class="col-xl-7">
                <!-- FIRST COLUMN -->
                <div class="product-image-container">
                    <div class="product-image">

                        <!--Carousel Wrapper-->
                        <div id="carousel-thumb" class="carousel slide carousel-fade carousel-thumbnails" data-ride="carousel">

                            <!--Slides-->
                            <div class="carousel-inner" role="listbox">
                                <?php

                                $pictures = $model->getImages('large');
                                if (is_array($pictures)) {

                                    foreach ($pictures as $key => $picture) {

                                        echo Html::beginTag('div', ['id' => 'img-container-' . $key, 'data-high-res-src' => $picture->webUrl, 'data-src' => $picture->webUrl, 'class' => 'carousel-item ' . ($key == 0 ? 'active' : '')]);
                                        echo Html::img($picture->webUrl, ['class' => 'c-img d-block w-100', 'alt' => $model->seo_name, 'title' => $model->seo_name]);
                                        echo Html::endTag('div');

                                        if ($key == 0)
                                            $this->registerJs("ImageViewer('#img-container-{$key}');");

                                    }

                                }

                                $this->registerJS(<<<JS
                                            $('.product-image #carousel-thumb').on('slid.bs.carousel', function () {
                                              ImageViewer('.product-image .carousel-item.active');
                                            })
JS
                        );
                        ?>
                          </div> <!-- //carousel-inner -->

                                                      <!-- carousel indicators -->
                          <div class="justify-content-center mt-3 d-flex">
                            <ol class="carousel-indicators carousel-indicators-mobile">
                                <li data-target="#coreshopCarousel" data-slide-to="0" class="active"></li>

                                <?php
                                    $pictures = $model->getImages('large');
                                    if (is_array($pictures)) {

                                    for ($i = 1; $i < count($pictures); $i++) { ?>
                                        
                                        <li data-target="#coreshopCarousel" data-slide-to=<?php echo $i ?> ></li>

                                    <?php
                                    }}
                                    ?>
                            </ol> 
                             </div>
                            <!-- //carousel-indicators -->
           
           
                         <!-- //carousel-inner -->
                        <!-- SLIDER -->
                        <div class="product-thumbs my-3">

                            <div class="row">
                                    <?php

                                    // THUMBS, ASZTALIN BAL SZELEN
                                    $pictures = $model->getImages('large');
                                    if (is_array($pictures)) {

                                        
                                        foreach ($pictures as $key => $picture) {
                                            // echo Html::img($picture->webUrl, [
                                            //     'alt' => $model->seo_name,
                                            //     'title' => $model->seo_name,
                                            //     'data-target' => '#carousel-thumb',
                                            //     'data-slide-to' => $key,
                                            // ]);

                                            echo Html::beginTag('div', ['class' => 'carousel-thumb']);
                                            echo Html::img($picture->webUrl, [
                                                'alt' => $model->seo_name,
                                                'title' => $model->seo_name,
                                                'data-target' => '#carousel-thumb',
                                                'data-slide-to' => $key,
                                            ]);
                                            echo Html::endTag('div');
                                        }

                                    }

                                    ?>
                            </div> <!-- //row -->
                        </div> <!-- //product-thumbs -->
                    </div> <!-- //carousel-thumb -->
                </div> <!-- //product-image -->
            </div> <!-- //product-image-container -->
        </div> <!-- //col-xl-6 -->
                <!--/.Carousel Wrapper-->

             <!-- //product-image -->

         <!-- //product-image-container -->


                <!-- END OF FIRST COLUMN -->
   
            <div class="col-xl-5">
                        <!-- SECOND COLUMN -->
                            <!-- product-order-desktop -->
        <div class="product-order-desktop">

<div class="product-details-desktop">
    <div class="product-indent">
    
    
    <img src="/markak/<?= $model->markaid ?>.png" alt="<?= $model->seo_name ?>"
     title="<?= $model->seo_name ?>">
    <h1><?= $model->marka->markanev ?> <span class="blue"><?= $model->termeknev ?></span></h1>
    <p class="product-color"><?= $model->szin ?></p>
     <p class="product-number"><?= $model->cikkszam ? 'Cikkszám: ' . $model->cikkszam : '' ?></p>


<div class="rating">
    <?php
    echo StarRating::widget([
        'id' => 'product-rating',
        'name' => 'product-rating',
        'pluginOptions' => [
            'theme' => 'krajee-svg',
            'filledStar' => '<span class="krajee-icon krajee-icon-star"></span>',
            'emptyStar' => '<span class="krajee-icon krajee-icon-star"></span>',
            'size' => 'xs',
            'stroke' => "#FF9900",
            'step' => 1,
            'showClear' => false,
            'showCaption' => false,
        ],
        'value' => $model->ertekelesAVG,
    ]);

    echo $this->registerJs(<<<JS
$('#product-rating').on('rating:change', function (event, value, caption) {

$.ajax({
method: "POST",
url: "/termekek/ajax-rate",
data: {
'id': {$model->id},
'value': value,
}
}).done(function (result) {
if (result.error){
addNotice(result.error);    
$('#product-rating').rating('update', {$model->ertekelesAVG});
}else{
addNotice('Köszönjük az értékelésedet!', '');
$('#product-rating').rating('update', result.value);
}
});

});
JS
    );
    ?>
</div> <!-- //rating -->



<div class="product-prise">

    <?php
    if ($model->vonalkodok) {
        if ($model->isAkcios()) {
            ?>

            <span class="eredeti_ar"><?= \Yii::$app->formatter->asDecimal($model['kisker_ar']) ?> Ft</span>
            <span class="ar"><?= \Yii::$app->formatter->asDecimal($model['akcios_kisker_ar']) ?> Ft</span>

            <?php
        } else {
            ?>

            <span class="ar"><?= \Yii::$app->formatter->asDecimal($model['kisker_ar']) ?> Ft</span>

            <?php
        }
    }
    ?>

</div> <!-- //product-prise -->

<div class="product-description">
     <?= nl2br($model->leiras) ?>
</div>
</div>
</div>
<div class="set-product-details-container alice-blue-bg clearfix">
<?php
if ($model->vonalkodok) {
    ?>

    <div id="termek-meretek-1">

        <?php
        if (count($model->vonalkodok) > 1) {
            ?>
            <p class="filter-name">
            <span>
            Válassz méretet:
            </span>
            
            <?php
                if ($model->kategoria == 94 || $model->kategoria == 95) {
            ?>

                <span>
                    <a class="size-table-container-link" href="#<?= $model->kategoria . '_' . $model->markaid ?>" rel="facebox">
                        <img class="size-table-image mr-2 mb-1" src="/images/icons/size-table.png" alt="Méret táblázat">
                        <span class="size-table-text">Mérettáblázat</span>
                    </a>
                </span>

                <!-- <span>
                    <a href="#<?= $model->kategoria . '_' . $model->markaid ?>" rel="facebox" style="float:right;padding:4px 10px 0 0;">
                        <img src="/images/merettabla.png" style="vertical-align:middle;">
                    </a>
                </span> -->

            <?php
                }
            ?>                
            
            </p>
            <?php
        }
        ?>

        <!-- <?php
        if ($model->kategoria == 94 || $model->kategoria == 95) {
            ?>
            <a href="#<?= $model->kategoria . '_' . $model->markaid ?>" rel="facebox"
               style="float:right;padding:4px 10px 0 0;">
                <img src="/images/merettabla.png" style="vertical-align:middle;">
            </a>
            <?php
        }
        ?> -->

        <?php
        if (count($model->vonalkodok) >= 1) {
            foreach ($model->vonalkodok as $vonalkod) {
                ?>
                <input type="radio"
                       name="meret_radio"
                       style="display:none"
                       id="v_<?= $vonalkod->vonalkod ?>"
                       onclick="selectSize('<?= $vonalkod->vonalkod ?>')"
                />
                <label for="v_<?= $vonalkod->vonalkod ?>"
                       class="product-size" data-toggle="tooltip" data-placement="top"
                       title="<?= $vonalkod->keszlet_1 ?> db raktáron"><?= $vonalkod->megnevezes ?></label>

                <?php
            }
        }

        if (count($model->vonalkodok) == 1) {
            $this->registerJs('$("#v_' . $vonalkod->vonalkod . '").trigger("click")');
        }
        ?>

    </div> <!-- //termek-meretek-1 -->


    <div id="termek-meretek-2">

        <form method="post" class="cart-form">
            <?= Html::dropDownList('meret', null, ArrayHelper::map($model->vonalkodok, 'vonalkod', 'megnevezes'), ['style' => Yii::$app->mobileDetect->isDescktop() ? 'display:none' : '', 'prompt' => count($model->vonalkodok > 1) ? 'Válassz...' : '', 'id' => 'meret']) ?>

               
                <span id="keszlet" style="display: none">
                     <p class="filter-name clearfix pt-3">
                        <span>
                            Add meg a mennyiséget:
                        </span>
                    </p>
                    <select name="mennyiseg" class="form-control number-product"></select>
                </span>
            <div class="clearfix"></div>
            <button type="submit" class="btn btn-primary mt-4" disabled>Válassz méretet</button>
        </form>



    </div> <!-- //termek-meretek-2 -->


    <?php
} else {
    ?>

    <div class="kifutott_termek">
        <div class="padding-20">
            <h4>KIFUTOTT TERMÉK!</h4>
            <p>Sajnáljuk, ez a termék elfogyott :( </p>
            <p>Nézd meg aktuális kínlatunkat, bízunk benne találsz kedvedre valót újdonságaink között.</p>
        </div>
    </div>

    <?
}
?>


</div> <!-- //set-product-details-container -->


<?
//        if (!empty($_COOKIE['prev1'])) {
//            if (!$func->isMobile()) include('inc/inc.elozmeny.php');
//        } elseif (!$func->isMobile()) {
//            include('inc/inc.ajanlo.php');
//            setcookie('prev1', $_SESSION['termek_id'], strtotime('+30 days'), '/');
//        }
?>


</div> <!-- //product-order-desktop -->





                        <!-- END OF SECOND COLUMN -->
            </div>
        </div> <!-- //row -->
</div>




        
    <!-- END OF ROW -->


    <div class="container">
        <div class="product-shipping-info row">
            <div class="col-12 col-md">
                <div class="media">
                      <img src="/images/icons/date.png" alt="Coreshop.hu kiszállítás"/>
                      <div class="media-body">
                        <p>Kiszállítás:
                                <a href="<?= Url::to(['site/content', 'page' => 'shipping']) ?>"
                                   target="_blank">
                                    <?php
                                    if (GlobalisAdatok::getParam('egyedi_szallitas_idopont'))
                                        echo GlobalisAdatok::getParam('egyedi_szallitas_idopont');
                                    else
                                        echo Coreshop::dateToHU(Coreshop::GlsDeliveryDate());
                                    ?>
                                </a>
                        </p>
                    </div>
                </div>
                    
                   

            </div>
            <div class="col-12 col-md">
                <div class="media">
                  <img src="/images/icons/transport.png" alt="Coreshop.hu - ingyenes kiszállítás"/>
                  <div class="media-body">
                    <p>Ingyenes
                    kiszállítás <?= Yii::$app->formatter->asDecimal(GlobalisAdatok::getParam('ingyenes_szallitas')) ?>
                    Ft felett.</p>
                  </div>
                </div>

            </div>
            <div class="col-12 col-md">
                <div class="media">
                  <img src="/images/icons/shop.png" alt="Coreshop.hu - bemutatóterem"/>
                  <div class="media-body">
                   <!-- <p>Gyere el és nézd meg <a href="/hu/uzletunk">bemutatótermünkben</a>.</p> -->
                   <p>Megvásárolhatod <a href="/hu/uzletunk">üzletünkben</a> is.</p>
                  </div>
                </div>
            </div>

        </div> <!-- //product-shipping-info -->
    </div> <!-- //container --> 

    <h2 class="text-center margin-top-20">Legutóbb megtekintett <span class="blue">termékek</span></h2>

<?php
$dataProvider = (new TermekekSearch())->search(['q' => $model->termeknev, 'subCategory' => $model->defaultSubCategory->url_segment]);
$dataProvider->pagination = false;
$dataProvider->query->andWhere(['!=', 'id_termek', $model->id]);
$dataProvider->query->limit(12);
$dataProvider->query->orderBy('rand()');

if ($dataProvider->getCount() > 0)
    echo $this->render('_index_ajanlo', [
        'dataProvider' => $dataProvider,
    ]);
?>
