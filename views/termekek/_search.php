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

?>
<div class="container hidden-md-up">
    <div class="row align-items-center mobile-list-navigation">
        <div class="col-5">
            <!--<button type="button" class="btn btn-mobile btn-filter" data-toggle="modal" data-target="#filter-modal">
              Szűrő
            </button>-->
            <a class="btn btn-mobile btn-filter" data-toggle="collapse" href="#filter-modal" role="button"
               aria-expanded="false" aria-controls="filter-modal">Szűrő</a>
        </div>
        <div class="col-7">
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
                <div class="filter-topnav justify-content-around">

                    <select name="s" class="form-control custom-select">
                        <option value="leguljabb-elol" <?= $params['s'] == 'leguljabb-elol' ? 'selected' : '' ?>>
                            Újdonságok
                        </option>
                        <option value="ar-szerint-csokkeno" <?= $params['s'] == 'ar-szerint-csokkeno' ? 'selected' : '' ?>>
                            Ár szerint csökkenő
                        </option>
                        <option value="ar-szerint-novekvo" <?= $params['s'] == 'ar-szerint-novekvo' ? 'selected' : '' ?>>
                            Ár szerint növekvő
                        </option>
                    </select>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$show = $params['brand'] || $params['meret'] || $params['szin'];
?>

<div class="termekek-search collapse <?= $show ? 'show' : '' ?>" id="filter-modal">
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

    <div class="desktop-filter-container">

        <?php
        //ALKATEGÓRIÁK
        if ($params['mainCategory']):
            ?>
            <div class="desktop-subcat">
                <h4 class="filter-name filter-name-first m-0">Kategória</h4>
                <div class="container">
                    <ul class="list-unstyled">
                        <?php
                        $models = $subCategoryDataProvider->getModels();
                        foreach ($models as $item) {
                            echo "<li>";
                            echo Html::a(
                                $item['megnevezes'],
                                ['termekek/index', 'mainCategory' => $item['pk_url_segment'], 'subCategory' => $item['url_segment'], 's' => $params['s']],
                                ['class' => $params['subCategory'] == $item['url_segment'] ? 'selected' : '']
                            );
                            echo "</li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        <?php
        elseif($params['brand']):
            ?>
            <div class="desktop-subcat">
                <h4 class="filter-name filter-name-first m-0">Kategória</h4>
                <div class="container">
                    <ul class="list-unstyled">
                        <?php
                        //FŐKATEGÓRIÁK
                        $subModels = (new TermekekSearch())->searchSubCategoryWithParams(['brand' => $params['brand'], 'meret' => $params['meret'], 'szin' => $params['szin'], 'q' => $params['q'], 's' => $params['s']])->getModels();
                        $pkOldName = '';
                        foreach ($subModels as $item) {

                            echo "<li>";
                            echo Html::a(
                                $item['megnevezes'],
                                ['termekek/index', 'mainCategory' => $item['pk_url_segment'], 'subCategory' => $item['url_segment'], 'brand' => $params['brand'], 'meret' => $params['meret'], 'szin' => $params['szin'], 'q' => $params['q'], 's' => $params['s']],
                                ['class' => $params['subCategory'] == $item['url_segment'] ? 'selected' : '']
                            );
                            echo "</li>";

                        }
                        ?>
                    </ul>
                </div>
            </div>
        <?
        endif;
        ?>


        <?php
        //MÁRKÁK
        $models = $brandDataProvider->getModels();
        if (count($models) > 0):
            ?>
            <div class="desktop-filter">
                <h4 class="filter-name">Márka</h4>
                <div class="container size-filter-container brand-container">
                    <div class="row">
                        <?php
                        foreach ($models as $item) {

                            $active = $params['brand'] == $item['url_segment'] ? true : false;
                            echo Html::a(
                                $item['markanev'],
                                ['termekek/index', 'mainCategory' => $params['mainCategory'], 'subCategory' => $params['subCategory'], 'brand' => ($active ? null : $item['url_segment']), 'meret' => $params['meret'], 'szin' => $params['szin'], 'tipus' => $params['tipus'], 'q' => $params['q'], 's' => $params['s']],
                                ['class' => $active ? 'sizeButtonSelected' : 'sizeButton']
                            );
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php
        endif;
        ?>


        <?php
        //MÉRETEK
        $models = $sizeDataProvider->getModels();
        if (count($models) > 0):
            ?>
            <div class="desktop-filter">
                <h4 class="filter-name">Méret</h4>
                <div class="container size-container">
                    <div class="row">
                        <?php
                        foreach ($models as $item) {
                            $active = $params['meret'] == $item['url_segment'] ? true : false;
                            echo Html::a(
                                $item['megnevezes'],
                                ['termekek/index', 'mainCategory' => $params['mainCategory'], 'subCategory' => $params['subCategory'], 'brand' => $params['brand'], 'meret' => ($active ? null : $item['url_segment']), 'szin' => $params['szin'], 'tipus' => $params['tipus'], 'q' => $params['q'], 's' => $params['s']],
                                ['class' => $active ? 'sizeButtonSelected' : 'sizeButton']
                            );
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php
        endif;
        ?>

        <?php
        //SZÍNEK
        $models = $colorDataProvider->getModels();
        if (count($models) > 0):
            ?>
            <div class="desktop-filter">
                <h4 class="filter-name">Szín</h4>
                <div class="row justify-content-start color-container">

                    <?php
                    foreach ($models as $item) {
                        echo '<div class="float-left">';
                        $active = $params['szin'] == $item['szinszuro'] ? true : false;
                        echo "<span>";
                        echo Html::a(
                            "",
                            ['termekek/index', 'mainCategory' => $params['mainCategory'], 'subCategory' => $params['subCategory'], 'brand' => $params['brand'], 'meret' => $params['meret'], 'szin' => ($active ? null : $item['szinszuro']), 'tipus' => $params['tipus'], 'q' => $params['q'], 's' => $params['s']],
                            ['class' => $active ? 'colorButton colorButtonSelected ' . $item['szinszuro'] : 'colorButton ' . $item['szinszuro']]
                        );
                        echo "</span>";
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        <?php
        endif;
        ?>

        <?php
        //TÍPUSOK
        $models = $typeDataProvider->getModels();
        if (count($models) > 0):
            ?>
            <div class="desktop-filter">
                <h4 class="filter-name">Legnépszerűbb</h4>
                <div class="row justify-content-start color-container">
                    <?php
                    foreach ($models as $item) {
                        $active = $params['tipus'] == $item['tipus'] ? true : false;
                        echo Html::a(
                            $item['tipus'],
                            ['termekek/index', 'mainCategory' => $params['mainCategory'], 'subCategory' => $params['subCategory'], 'brand' => $params['brand'], 'meret' => $params['meret'], 'szin' => $params['szin'], 'tipus' => ($active ? null : $item['tipus']), 'q' => $params['q'], 's' => $params['s']],
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
                        ['termekek/index', 'mainCategory' => $params['mainCategory'], 'subCategory' => $params['subCategory'], 'brand' => $params['brand'], 'meret' => $params['meret'], 'szin' => $params['szin'], 'tipus' => $params['tipus'], 's' => $params['s']],
                        ['class' => 'sizeButtonSelected']
                    );
                    ?>
                </div>
            </div>
        <?php
        endif;
        ?>


        <?php
        if ($params['brand'] || $params['meret'] || $params['szin'] || $params['q'])
            echo Html::a(
                'Szűrők törlése',
                ['termekek/index', 'mainCategory' => $params['mainCategory'], 'subCategory' => $params['subCategory']],
                ['class' => 'sizeButtonSelected delete-filter']
            );
        ?>
    </div>
</div>