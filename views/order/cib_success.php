<h2>Sikeres fizetés!</h2>

<ul>
    <li>Válaszkód (RC): <b><?= $model->rc ?></b></li>
    <li>Válaszüzenet (RT): <b><?= $model->rt ?></b></li>
    <li>Tranzakció azonosító (TRID): <b><?= $model->trid ?></b></li>
    <li>Engedélyszám (ANUM): <b><?= $model->anum ?></b></li>
    <li>Tranzakció összege: <b><?= Yii::$app->formatter->asDecimal($model->amo) ?></b></li>
</ul>