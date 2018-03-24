<table class="table table-striped">
    <tbody>
    <tr>
        <td>Válaszkód (RC):</td>
        <td class="font-weight-bold"><?= $model->rc ?></td>
    </tr>
    <tr>
        <td>Válaszüzenet (RT):</td>
        <td class="font-weight-bold"><?= $model->rt ?></td>
    </tr>
    <tr>
        <td>Tranzakció azonosító (TRID):</td>
        <td class="font-weight-bold"><?= $model->trid ?></td>
    </tr>
    <tr>
        <td>Engedélyszám (ANUM):</td>
        <td class="font-weight-bold"><?= $model->anum ?></td>
    </tr>
    <tr>
        <td>Tranzakció összege:</td>
        <td class="font-weight-bold"><?= Yii::$app->formatter->asDecimal($model->amo) ?> Ft</td>
    </tr>
    </tbody>
</table>