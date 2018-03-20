<?

use app\assets\TermekAsset;
use app\components\helpers\Coreshop;
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

?>

    <!-- THUMB, MAINIMAGE, INFOBOX container -->
    <div class="product-container">

        <!-- KEP ELEJE -->
        <select id="optionlist" onChange="javascript:changeImage()" style="display:none">
            <?
            $pictures = $model->getImages('large');
            if (is_array($pictures)) {

                foreach ($pictures as $picture) {
                    echo Html::tag('option', $picture->id . '. Image', ['value' => $picture->webUrl]);
                }

            }
            ?>
        </select>

        <?

        // MOBILE PRODUCT DETAILS
        if (Yii::$app->mobileDetect->isMobile()) {
            echo '<div class="product-details-mobile">';

            echo '<h1>' . $model->marka->markanev . ' ' . $model->termeknev . '</h1> <h2>' . $model->szin . '</h2>';

            echo '</div>';
        }

        ?>

        <div class="product-thumbs">

            <?php

            // THUMBS, ASZTALIN BAL SZELEN
            $pictures = $model->getImages('large');
            if (is_array($pictures)) {

                foreach ($pictures as $key => $picture) {
                    echo Html::img($picture->webUrl, [
                        'id' => 'thumb' . $key,
                        'name' => 'thumb' . $key,
                        'onclick' => 'javascript:nextImage("' . $key . '")',
                        'alt' => $model->seo_name,
                        'title' => $model->seo_name,
                    ]);
                }

            }

            ?>

        </div>
        <div class="product-image-container">

            <div class="product-image-nav-info">További nézetekhez klikkelj a képre</div>

            <div class="product-image">

                <!-- PRODUCT IMAGE, DESC -->
                <img name="mainimage"
                     id="mainimage"
                     src="/images/loading.gif"
                     onClick="javascript:nextImage()"
                     alt="<?= $model->seo_name ?>"
                     title="<?= $model->seo_name ?>"
                     class="<?= $model->getDefaultImage('large')->sizes[0] >= $model->getDefaultImage('large')->sizes[1] ? 'vertical-image' : 'horizontal-image' ?>"/>

                <div id="zoom-icon" class="zoom-div-icon"><img src="/images/search.svg" alt="zoom"/></div>

            </div>

            <div class="product-description"
                 style="display:block; margin-bottom:10px;"><?= nl2br($model->leiras) ?></div>

        </div>
        <!-- ENDOF PRODUCT IMAGE, DESC -->


        <!-- zoom div 100% -->
        <div id="zoom-div" class="zoom-div">

            <div id="zoom-close" class="zoom-close">X</div>

            <div class="product-thumbs-zoom">
                <?

                $pictures = $model->getImages();
                if (is_array($pictures)) {

                    foreach ($pictures as $key => $picture) {
                        echo Html::img($picture->webUrl, [
                            'id' => 'thumbzoom' . $key,
                            'name' => 'thumbzoom' . $key,
                            'onclick' => 'javascript:nextImage("' . $key . '")',
                            'alt' => $model->seo_name,
                            'title' => $model->seo_name,
                        ]);
                    }

                }
                ?>
            </div>
            <img name="mainzoomimage" id="mainzoomimage" src="" onClick="javascript:nextImage()"/>

        </div>
        <!-- endof zoom div -->


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
                    if (count($model->vonalkodok) > 1) {
                        foreach ($model->vonalkodok as $vonalkod) {
                            ?>
                            <input type="radio"
                                   name="meret_radio"
                                   style="display:none"
                                   id="v_<?= $vonalkod->vonalkod ?>"
                                   onclick="selectSize('<?= $vonalkod->vonalkod ?>')"
                            />
                            <label for="v_<?= $vonalkod->vonalkod ?>"
                                   class="product-size"><?= $vonalkod->megnevezes ?></label>

                            <?php
                        }
                    } else {
                        $this->registerJs('selectSize("' . $model->vonalkodok[0]->vonalkod . '")');
                    }
                    ?>

                </div>

                <div id="termek-meretek-2">

                    <form method="post" class="cart-form">
                        <?= Html::dropDownList('meret', null, ArrayHelper::map($model->vonalkodok, 'vonalkod', 'megnevezes'), ['style' => Yii::$app->mobileDetect->isDescktop() ? 'display:none' : '', 'prompt' => count($model->vonalkodok > 1) ? 'Válassz...' : '', 'id' => 'meret']) ?>
                        <span id="keszlet" style="display: none">
                    <select name="mennyiseg" style="margin-top:20px;">
                    </select>
                    <button type="submit" class="arrow_box">Hozzáadás a kosárhoz</button>
                </span>
                    </form>

                    <div class="product-shipping-info">

                        <img src="/images/cxs_logo.svg" alt="CXS logo - Coreshop.hu"/>
                        <p>Kiszállítás: <a href="<?= Url::to(['site/content', 'page' => 'shipping']) ?>"
                                           target="_blank"><?= Coreshop::GlsDeliveryDate() ?></a>
                        </p>

                        <br/>

                        <img src="/images/shipping_logo.svg" alt="Shippin logo - Coreshop.hu"/>
                        <p>Ingyenes kiszállítás xxxxx Ft felett.</p>

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

<?php
if ($history) {
    echo $this->render('_history', ['history' => $history]);
} else {
    echo $this->render('_ajanlo', ['subCategory' => ArrayHelper::getValue($model, 'defaultSubCategory.url_segment')]);
}
?>