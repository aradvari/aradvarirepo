<?

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model app\models\Termekek */

?>

<?php if (Yii::$app->cart->items): ?>

    <table class="table table-striped">
        <tbody>
        <tr>
            <th></th>
            <th>Márka, terméknév</th>
            <th>Szín</th>
            <th>Méret</th>
            <th>Egységár</th>
            <th>Menny</th>
            <th>Összesen</th>
            <th>Törlés</th>
        </tr>
        <?php
        foreach (Yii::$app->cart->items as $item) {
            $model = $item['item'];
            $termekUrl = Url::to(['termekek/view',
                'mainCategory' => $model->termek->defaultMainCategory->url_segment,
                'subCategory' => $model->termek->defaultSubCategory->url_segment,
                'brand' => $model->termek->marka->url_segment,
                'termek' => $model->termek->url_segment,
            ]);
            ?>
            <tr>
                <td class="text-center align-middle">
                    <a href="<?=$termekUrl?>">
                        <img src="<?= $model->termek->getDefaultImage()['webUrl'] ?>"
                             style="padding:1px; border:1px solid #2a87e4; width:50px;height:50px;vertical-align:text-middle;"
                             alt="<?= $model->termek->termeknev ?>"></a></td>
                <td class="align-middle">
                    <a href="<?=$termekUrl?>"><?= $model->termek->marka->markanev ?></a><br>
                    <a href="<?=$termekUrl?>"><?= $model->termek->termeknev ?></a>
                </td>
                <td class="align-middle">
                    <a href="<?=$termekUrl?>"><?= $model->termek->szin ?></a>
                </td>
                <td class="align-middle"><a href="<?=$termekUrl?>"><?= $model->megnevezes ?></a>
                </td>
                <td class="text-right align-middle">
                    <?php
                    if ($model->termek->kisker_ar > $model->termek->vegleges_ar) {
                        echo '<del>' . Yii::$app->formatter->asDecimal($model->termek->kisker_ar) . ' Ft</del>';
                    }
                    ?>
                    <?= Yii::$app->formatter->asDecimal($model->termek->vegleges_ar) ?> Ft
                </td>
                <td class="text-right align-middle">
                    <?= Html::dropDownList('quantity', $item['quantity'] . '#' . $model->vonalkod, $item['quantityItems'], ['class' => 'form-control']); ?>
                </td>
                <td class="text-right align-middle"><?= Yii::$app->formatter->asDecimal($model->termek->vegleges_ar * $item['quantity']) ?>
                    Ft
                </td>
                <td class="text-center align-middle"><a
                            href="javascript:deleteCartItem('<?= $model->vonalkod ?>')"><img
                                src="/images/delete.png"></a></td>
            </tr>
        <?php } ?>

        <tr>
            <td colspan="5" class="text-right align-middle">Kuponkód:</td>
            <td class="text-right align-middle" colspan="3">
                <?php
                $code = Yii::$app->cart->getCouponCode();
                echo Html::textInput('kupon', $code['code'], ['class' => 'form-control kupon ' . ($code && $code['success'] ? 'is-valid' : 'is-invalid'), 'placeholder' => 'kuponkód']);
                ?>
            </td>
        </tr>

        <tr>
            <td colspan="5" class="text-right align-middle">Összesen:</td>
            <td class="text-right align-middle"
                colspan="2"><?= Yii::$app->formatter->asDecimal(Yii::$app->cart->totalAmount) ?> Ft<br>
                <span class="small">ÁFA (27%): <?= Yii::$app->formatter->asDecimal(Yii::$app->cart->totalVATAmount, 0) ?>
                    Ft</span>
            </td>
            <td>&nbsp;</td>
        </tr>

        <?php if (Yii::$app->cart->totalDiscountAmount): ?>
            <tr>
                <td colspan="5" class="text-right align-middle">Kedvezmények:</td>
                <td class="text-right align-middle" colspan="2">-
                    <?= Yii::$app->formatter->asDecimal(Yii::$app->cart->totalDiscountAmount, 0) ?> Ft
                </td>
                <td>&nbsp;</td>
            </tr>
        <?php endif; ?>

        <tr>
            <td colspan="5" class="text-right align-middle">+ Szállítási díj:</td>
            <td class="text-right align-middle" colspan="2">
                <?php if (Yii::$app->cart->shippingAmount): ?>
                    <?= Yii::$app->formatter->asDecimal(Yii::$app->cart->shippingAmount) . ' Ft' ?>
                <?php else: ?>
                    INGYENES
                <?php endif; ?>
            </td>
            <td>&nbsp;</td>
        </tr>

        <tr class="font-weight-bold">
            <td colspan="2"><a href="<?= Url::to(['order/create']) ?>" class="btn btn-success btn-sm cash-btn">Tovább a
                    pénztárhoz</a></td>
            <td colspan="3" class="text-right align-middle">Fizetendő:</td>
            <td class="text-right align-middle"
                colspan="2"><?= Yii::$app->formatter->asDecimal(Yii::$app->cart->totalAmountWithShipping, 0) ?>
                Ft
            </td>
            <td>&nbsp;</td>
        </tr>

        </tbody>
    </table>


<?php endif; ?>

<?php if (!Yii::$app->cart->items): ?>
    <table class="table table-striped">
        <tbody>
        <tr>
            <th>Kosár</th>
        </tr>
        <tr>
            <td class="text-nowrap">A kosarad jelenleg üres.</td>
        </tr>
        </tbody>
    </table>

<?php endif; ?>