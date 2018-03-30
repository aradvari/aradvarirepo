<?php

use yii\helpers\Html;

?>

<div class="row">
    <div class="col">

        <table class="table table-striped">
            <tbody>
            <tr>
                <td>Rendelés szám:</td>
                <td class="font-weight-bold"><?= $model->megrendeles_szama ?></td>
            </tr>
            <tr>
                <td>Rendelés dátuma:</td>
                <td class="font-weight-bold"><?= Yii::$app->formatter->asDate($model->datum) ?></td>
            </tr>
            <tr>
                <td>Fizetendő végösszeg:</td>
                <td class="font-weight-bold"><?= Yii::$app->formatter->asDecimal($model->fizetendo + $model->szallitasi_dij) ?>
                    Ft
                </td>
            </tr>
            <tr>
                <td>Fizetési mód:</td>
                <td class="font-weight-bold"><?= $model->fizetesiMod->nev ?></td>
            </tr>
            <tr>
                <td>Szállítási mód:</td>
                <td class="font-weight-bold"><?= $model->szallitasiMod->nev ?></td>
            </tr>
            </tbody>
        </table>

    </div>
    <?php if ($model->bankTranzakcio): ?>
        <div class="col">
            <?= $this->render('cib_success', ['model' => $model->bankTranzakcio]); ?>
        </div>
    <?php endif; ?>
</div>

<h2>Rendelés részletei</h2>

<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">Termék</th>
        <th scope="col text-right">Összeg</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($model->tetelek as $item): ?>
        <tr>
            <td>
                <img src="<?= $item->termek->getDefaultImage()->webUrl ?>" align="left" class="pr-2"/>
                <?= $item->termek_nev ?> <strong>x 1</strong><br>
                Méret: <span class="font-weight-bold"><?= $item->tulajdonsag ?></span>
            </td>
            <td>
                <?= Yii::$app->formatter->asDecimal($item->termek_ar) ?> Ft<br>
                <span class="small">(<?= Yii::$app->formatter->asDecimal($item->afa_ertek) ?> Ft adó)</span>
            </td>
        </tr>

    <?php endforeach; ?>

    <tr>
        <td colspan="2" class="bg-secondary"></td>
    </tr>

    <?php if (count($model->tetelek) > 1): ?>
        <tr>
            <td class="font-weight-bold text-uppercase">Termékek összege:</td>
            <td>
                <?= Yii::$app->formatter->asDecimal($model->fizetendo) ?> Ft<br>
                <small>(<?= Yii::$app->formatter->asDecimal($item->afa_ertek) ?> Ft adó)</small>
            </td>
        </tr>
    <?php endif; ?>
    <tr>
        <td class="font-weight-bold text-uppercase">Szállítási díj:</td>
        <td>
            <?= ($model->szallitasi_dij) ? Yii::$app->formatter->asDecimal($model->szallitasi_dij) . ' Ft' : 'INGYENES' ?>
        </td>
    </tr>

    <tr>
        <td class="font-weight-bold text-uppercase">Összesen fizetendő:</td>
        <td>
            <?= Yii::$app->formatter->asDecimal($model->fizetendo + $model->szallitasi_dij) ?> Ft<br>
            <small>(<?= Yii::$app->formatter->asDecimal($item->afa_ertek) ?> Ft adó)</small>
        </td>
    </tr>

    </tbody>
</table>