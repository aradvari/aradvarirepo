<?php

use app\models\SzavazasSzavazat;
use app\models\SzavazasValasz;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<p class="font-weight-bold">Köszönjük szavazatod!</p>

<table class="table-cart">
    <?php
    $sum = SzavazasSzavazat::find(['kerdes_id' => $szavazasKerdes->primaryKey])->sum('szavazat');
    $max = 100;
    foreach ($szavazasKerdes->szavazasValasz as $key => $item):
        $percent = round(($item->szavazasSzavazat->szavazat / $sum) * 100);
        ?>
        <tr>
            <td>
                <?= $item->valasz ?>
                <div style="border-bottom: 3px solid #2A87E4; height: 10px; width:<?= $percent ?>%"></div>
            </td>
            <td align="text-right"><?= $percent ?>%</td>
        </tr>
    <?php
    endforeach;
    ?>
</table>
