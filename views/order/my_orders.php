<?php

use app\models\MegrendelesFej;
use luya\bootstrap4\grid\GridView;
use yii\data\ActiveDataProvider;

?>

<?= $this->render('/user/_sub_menu') ?>

<?php
$dataProvider = new ActiveDataProvider([
    'query' => MegrendelesFej::find()->andWhere(['id_felhasznalo' => Yii::$app->user->id])->with('felhasznalo', 'statusz'),
    'sort' => false,
]);
echo GridView::widget([
    'id' => 'my-orders',
    'dataProvider' => $dataProvider,
    'columns' => [
        'megrendeles_szama',
        'datum:date',
        'statusz.statusz_nev',
        [
            'attribute' => 'fizetendo',
            'value' => function ($model) {
                return Yii::$app->formatter->asDecimal($model->fizetendo) . ' Ft';
            },
        ],
    ],
    'rowOptions' => function ($model, $key, $index, $grid) {
        return ['data-token' => $model->getToken(), 'class' => 'action'];
    },
    'summary' => '',
]); ?>