<?php
use app\models\TermekekSearch;1;
?>

    <h2>Köszönjük! A megrendelést megkaptuk</h2>

<?php
echo $this->render('_order_data', ['model' => $model]);

$dataProvider = (new TermekekSearch())->search(['subCategory' => ['ferfi-cipo', 'noi-cipo']]);
$dataProvider->pagination = false;
$dataProvider->query->andWhere(['opcio' => 'UJ']);
$dataProvider->query->limit(15);
$dataProvider->query->orderBy('rand()');

if ($dataProvider->getCount() > 0)
    echo $this->render('/termekek/_index_ajanlo', [
        'dataProvider' => $dataProvider,
    ]);
?>