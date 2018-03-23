<?php

use kop\y2sp\ScrollPager;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TermekekSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="termekek-marka">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="left-content">
        <?php echo $this->render('_brand_search', [
            'model' => $searchModel,
            'dataProvider' => $dataProvider,
            'mainCategoryDataProvider' => $mainCategoryDataProvider,
            'subCategoryDataProvider' => $subCategoryDataProvider,
            'brandDataProvider' => $brandDataProvider,
            'sizeDataProvider' => $sizeDataProvider,
            'colorDataProvider' => $colorDataProvider,
            'params' => $params,
            'brandModel' => $brandModel,
        ]); ?>
    </div>
    <div class="right-content">

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
            <div class="filter-topnav-right">
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
            </div>
        </form>

        <div class="brand-descripton">
            <?php
            echo str_repeat('Ide jön a(z) ' . ArrayHelper::getValue($brandModel, 'id') . ' márka leírás. ', 50);
            ?>
        </div>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'options' => ['class' => 'list-view row'],
            'itemOptions' => ['class' => 'item col-xl-2 col-lg-3 col-md-3 col-sm-3 col-6 text-center'],
            'itemView' => '_item',
            'pager' => [
                'class' => ScrollPager::className(),
                'triggerOffset' => 1,
                'noneLeftText' => '',
            ],
            'summary' => '',
        ]); ?>
    </div>

</div>
