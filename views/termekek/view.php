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
$this->title = $model->marka->markanev . ' ' . $model->termeknev . ' ' . $model->szinszuro;
$description = $model->leiras ? $model->leiras : $this->title;
$keywords = $model->defaultMainCategory->megnevezes . ' ' . $model->defaultSubCategory->megnevezes . ' ' . $model->marka->markanev . ' ' . $model->termeknev . ' ' . $model->szinszuro;
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
    <div class="product-container">

        <div class="product-thumbs">

            <?php

            // THUMBS, ASZTALIN BAL SZELEN
            $pictures = $model->getImages('large');
            if (is_array($pictures)) {

                foreach ($pictures as $key => $picture) {
                    echo Html::img($picture->webUrl, [
                        'alt' => $model->seo_name,
                        'title' => $model->seo_name,
                        'data-target' => '#carousel-thumb',
                        'data-slide-to' => $key,
                    ]);
                }

            }

            ?>

        </div>
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
                                    $('#carousel-thumb').on('slid.bs.carousel', function () {
                                      ImageViewer('.carousel-item.active');
                                    })
JS
                        );
                        ?>

                    </div>
                    <!--/.Slides-->
                    <!--Controls-->
                    <a class="carousel-control-prev" href="#carousel-thumb" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel-thumb" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>

                    <!--/.Controls-->
                    <!--        <ol class="carousel-indicators">-->
                    <!--            <li data-target="#carousel-thumb" data-slide-to="0" class="active"> <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Others/Carousel-thumbs/img%20(88).jpg" class="img-fluid"></li>-->
                    <!--            <li data-target="#carousel-thumb" data-slide-to="1"><img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Others/Carousel-thumbs/img%20(121).jpg" class="img-fluid"></li>-->
                    <!--            <li data-target="#carousel-thumb" data-slide-to="2"><img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Others/Carousel-thumbs/img%20(31).jpg" class="img-fluid"></li>-->
                    <!--        </ol>-->
                </div>
                <!--/.Carousel Wrapper-->

            </div>

            <div class="product-description"
                 style="display:block; margin-bottom:10px;"><?= nl2br($model->leiras) ?></div>

        </div>
        <!-- ENDOF PRODUCT IMAGE, DESC -->


        <!-- product-order-desktop -->
        <div class="product-order-desktop">

            <div class="product-details-desktop">

                <img src="/markak/<?= $model->markaid ?>.png" alt="<?= $model->seo_name ?>"
                     title="<?= $model->seo_name ?>">

                <h1><?= $model->marka->markanev ?> <?= $model->termeknev ?></h1>
                <h2><?= $model->szin ?></h2>
                <?= $model->cikkszam ? 'Cikkszám: ' . $model->cikkszam : '' ?>

            </div>

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

            </div>

            <div class="rating">
                <?php
                echo StarRating::widget([
                    'id' => 'product-rating',
                    'name' => 'product-rating',
                    'pluginOptions' => [
                        'theme' => 'krajee-svg',
                        'size' => 'xs',
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
            </div>

            <?php
            if ($model->vonalkodok) {
                ?>

                <div id="termek-meretek-1">

                    <?php
                    if (count($model->vonalkodok) > 1) {
                        ?>
                        <p>Válassz méretet</p>
                        <?php
                    }
                    ?>

                    <?php
                    if ($model->kategoria == 94 || $model->kategoria == 95) {
                        ?>
                        <a href="#<?= $model->kategoria . '_' . $model->markaid ?>" rel="facebox"
                           style="float:right;padding:4px 10px 0 0;">
                            <img src="/images/merettabla.png" style="vertical-align:middle;">
                        </a>
                        <?php
                    }
                    ?>

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

                </div>

                <div id="termek-meretek-2">

                    <form method="post" class="cart-form">
                        <?= Html::dropDownList('meret', null, ArrayHelper::map($model->vonalkodok, 'vonalkod', 'megnevezes'), ['style' => Yii::$app->mobileDetect->isDescktop() ? 'display:none' : '', 'prompt' => count($model->vonalkodok > 1) ? 'Válassz...' : '', 'id' => 'meret']) ?>
                        <span id="keszlet" style="display: none">
                            <select name="mennyiseg" class="margin-top:20px;"></select>
                        </span>
                        <button type="submit" class="arrow_box" disabled>Válassz méretet...</button>
                    </form>

                    <div class="product-shipping-info">

                        <img src="/images/cxs_logo.svg" alt="CXS logo - Coreshop.hu"/>
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

                        <br/>

                        <img src="/images/shipping_logo.svg" alt="Shippin logo - Coreshop.hu"/>
                        <p>Ingyenes
                            kiszállítás <?= Yii::$app->formatter->asDecimal(GlobalisAdatok::getParam('ingyenes_szallitas')) ?>
                            Ft felett.</p>

                        <br/>

                        <img src="/images/shop_logo.svg" alt="Shop logo - Coreshop.hu"/>
                        <p>Gyere el és nézd meg <a href="/hu/uzletunk">bemutatótermünkben</a>.</p>

                    </div>

                </div>

                <?php
            } else {
                ?>

                <div class="kifutott_termek">
                    <h2>KIFUTOTT TERMÉK!</h2>
                    Sajnáljuk, ez a termék elfogyott :(
                    <br/>
                    <br/>
                    <br/>
                    Nézd meg aktuális kínlatunkat, bízunk benne találsz kedvedre valót újdonságaink között.
                </div>

                <?
            }
            ?>

            <?
            //        if (!empty($_COOKIE['prev1'])) {
            //            if (!$func->isMobile()) include('inc/inc.elozmeny.php');
            //        } elseif (!$func->isMobile()) {
            //            include('inc/inc.ajanlo.php');
            //            setcookie('prev1', $_SESSION['termek_id'], strtotime('+30 days'), '/');
            //        }
            ?>

        </div>

    </div>

    <div class="content-right-headline" style="clear:both;">Termékajánló</div>

<?php
$dataProvider = (new TermekekSearch())->search(['q' => $model->termeknev, 'subCategory' => $model->defaultSubCategory->url_segment]);
$dataProvider->pagination = false;
$dataProvider->query->andWhere(['!=', 'id_termek', $model->id]);
$dataProvider->query->limit(10);
$dataProvider->query->orderBy('rand()');

if ($dataProvider->getCount() > 0)
    echo $this->render('_index_ajanlo', [
        'dataProvider' => $dataProvider,
    ]);
?>