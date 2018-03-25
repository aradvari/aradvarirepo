<?php

use app\models\TermekekSearch;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\TermekekSearch */
/* @var $form yii\widgets\ActiveForm */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $markaDataProvider yii\data\ActiveDataProvider */
/* @var $model yii\data\ActiveDataProvider */
/* @var $subCategoryDataProvider app\models\TermekekSearch */

?>

<div class="termekek-search">

    <div class="brand-site-logo">
        <img src="https://coreshop.hu/pictures/markak/<?= ArrayHelper::getValue($brandModel, 'id') ?>.png">
    </div>

    <div class="desktop-filter-container">

        <?php
        //FŐKATEGÓRIÁK
        $filteredSubCategories = (new TermekekSearch())->searchSubCategoryWithParams($params)->getModels();
        $mapped = ArrayHelper::map($filteredSubCategories, 'id_kategoriak', 'url_segment');

        $subModels = (new TermekekSearch())->searchSubCategoryWithParams(['brand' => $params['brand']])->getModels();
        $pkOldName = '';
        foreach ($subModels as $subItem) {

            if (in_array($subItem['url_segment'], $mapped)) {

                if ($pkOldName != $subItem['pk_megnevezes']) {
                    echo Html::a(
                        $subItem['pk_megnevezes'],
                        ['termekek/index', 'mainCategory' => $subItem['pk_url_segment'], 'brand' => $params['brand'], 'meret' => $params['meret'], 'szin' => $params['szin'], 'q' => $params['q'], 's' => $params['s']],
                        ['class' => 'brand-main-category ']
                    );
                    $pkOldName = $subItem['pk_megnevezes'];
                }

                echo Html::a(
                    $subItem['megnevezes'],
                    ['termekek/index', 'mainCategory' => $subItem['pk_url_segment'], 'subCategory' => $subItem['url_segment'], 'brand' => $params['brand'], 'meret' => $params['meret'], 'szin' => $params['szin'], 'q' => $params['q'], 's' => $params['s']],
                    ['class' => 'brand-sub-category ']
                );

            } else {

                if ($pkOldName != $subItem['pk_megnevezes']) {
                    echo Html::a(
                        $subItem['pk_megnevezes'],
                        ['termekek/index', 'mainCategory' => $subItem['pk_url_segment'], 'brand' => $params['brand'], 's' => $params['s']],
                        ['class' => 'brand-main-category ']
                    );
                    $pkOldName = $subItem['pk_megnevezes'];
                }

                echo Html::a(
                    $subItem['megnevezes'],
                    ['termekek/index', 'mainCategory' => $subItem['pk_url_segment'], 'subCategory' => $subItem['url_segment'], 'brand' => $params['brand'], 's' => $params['s']],
                    ['class' => 'brand-sub-category ']
                );

            }

        }
        ?>

        <?php
        //MÉRETEK
        $models = $sizeDataProvider->getModels();
        if (count($models) >= 0):
            ?>
            <div class="desktop-filter">
                <h4 class="filter-name">Méret</h4>
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
                <h4 class="filter-name">Szín</h4>
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
                <h4 class="filter-name">Egyedi keresés</h4>
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

    </div>

</div>