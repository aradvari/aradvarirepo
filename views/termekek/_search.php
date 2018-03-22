<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\TermekekSearch */
/* @var $form yii\widgets\ActiveForm */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $markaDataProvider yii\data\ActiveDataProvider */

?>

<div class="termekek-search">

    <?php
    //    //FŐKATEGÓRIÁK
    //    $models = $mainCategoryDataProvider->getModels();
    //    foreach ($models as $item) {
    //        echo Html::a(
    //            $item['megnevezes'],
    //            ['termekek/index', 'mainCategory' => $item['url_segment']],
    //            ['class' => $params['mainCategory'] == $item['url_segment'] ? 'active' : '']
    //        );
    //    }
    ?>

    <div class="desktop-subcat">
        <?php
        //ALKATEGÓRIÁK
        if ($params['mainCategory']) {
            $models = $subCategoryDataProvider->getModels();
            foreach ($models as $item) {

                echo Html::a(
                    $item['megnevezes'],
                    ['termekek/index', 'mainCategory' => $item['pk_url_segment'], 'subCategory' => $item['url_segment'], 's' => $params['s']],
                    ['class' => $params['subCategory'] == $item['url_segment'] ? 'selected' : '']
                );
            }
        }
        ?>
    </div>

    <div class="desktop-filter-container">

        <?php
        //MÁRKÁK
        $models = $brandDataProvider->getModels();
        if (count($models) >= 0):
            ?>
            <div class="desktop-filter">
                <a href="#" class="filter-name">Márka</a>
                <div class="imageButtonContainer">
                    <?php
                    foreach ($models as $item) {

                        $active = $params['brand'] == $item['url_segment'] ? true : false;
                        echo Html::a(
                            $item['markanev'],
                            ['termekek/index', 'mainCategory' => $params['mainCategory'], 'subCategory' => $params['subCategory'], 'brand' => ($active ? null : $item['url_segment']), 'meret' => $params['meret'], 'szin' => $params['szin'], 'q' => $params['q'], 's' => $params['s']],
                            ['class' => $active ? 'sizeButtonSelected' : 'sizeButton']
                        );
                    }
                    ?>
                </div>
            </div>
        <?php
        endif;
        ?>


        <?php
        //MÉRETEK
        $models = $sizeDataProvider->getModels();
        if (count($models) >= 0):
            ?>
            <div class="desktop-filter">
                <a href="#" class="filter-name">Méret</a>
                <div class="imageButtonContainer">
                    <?php
                    foreach ($models as $item) {
                        $active = $params['meret'] == $item['url_segment'] ? true : false;
                        echo Html::a(
                            $item['megnevezes'],
                            ['termekek/index', 'mainCategory' => $params['mainCategory'], 'subCategory' => $params['subCategory'], 'brand' => $params['brand'], 'meret' => ($active ? null : $item['url_segment']), 'szin' => $params['szin'], 'q' => $params['q'], 's' => $params['s']],
                            ['class' => $active ? 'sizeButtonSelected' : 'sizeButton']
                        );
                    }
                    ?>
                </div>
            </div>
        <?php
        endif;
        ?>

        <?php
        //SZÍNEK
        $models = $colorDataProvider->getModels();
        if (count($models) >= 0):
            ?>
            <div class="desktop-filter">
                <a href="#" class="filter-name">Szín</a>
                <div class="imageButtonContainer">
                    <?php
                    foreach ($models as $item) {
                        $active = $params['szin'] == $item['szinszuro'] ? true : false;
                        echo Html::a(
                            $item['szinszuro'],
                            ['termekek/index', 'mainCategory' => $params['mainCategory'], 'subCategory' => $params['subCategory'], 'brand' => $params['brand'], 'meret' => $params['meret'], 'szin' => ($active ? null : $item['szinszuro']), 'q' => $params['q'], 's' => $params['s']],
                            ['class' => $active ? 'sizeButtonSelected' : 'sizeButton']
                        );
                    }
                    ?>
                </div>
            </div>
        <?php
        endif;
        ?>

        <?php
        //EGYEDI KERESÉS
        if ($params['q']):
            ?>
            <div class="desktop-filter">
                <a href="#" class="filter-name">Egyedi keresés</a>
                <div class="imageButtonContainer">
                    <?php
                    echo Html::a(
                        $params['q'],
                        ['termekek/index', 'mainCategory' => $params['mainCategory'], 'subCategory' => $params['subCategory'], 'brand' => $params['brand'], 'meret' => $params['meret'], 'szin' => $params['szin'], 's' => $params['s']],
                        ['class' => 'sizeButtonSelected']
                    );
                    ?>
                </div>
            </div>
        <?php
        endif;
        ?>

        <form method="get" id="order-form"
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
            <div class="filter-topnav text-right">
                <p>
                    <span><?= $dataProvider->getTotalCount() ?> termék</span>
                    <select name="s">
                        <option value="leguljabb-elol" <?= $params['s'] == 'leguljabb-elol' ? 'selected' : '' ?>>
                            Legújabb elöl
                        </option>
                        <option value="ar-szerint-csokkeno" <?= $params['s'] == 'ar-szerint-csokkeno' ? 'selected' : '' ?>>
                            Ár szerint csökkenő
                        </option>
                        <option value="ar-szerint-novekvo" <?= $params['s'] == 'ar-szerint-novekvo' ? 'selected' : '' ?>>
                            Ár szerint növekvő
                        </option>
                    </select>
                </p>

                <?php
                echo Html::a(
                    'Szűrők törlése',
                    ['termekek/index', 'mainCategory' => $params['mainCategory'], 'subCategory' => $params['subCategory'], 'brand' => $params['brand']],
                    ['class' => 'sizeButtonSelected']
                );
                ?>

            </div>
        </form>

    </div>

</div>