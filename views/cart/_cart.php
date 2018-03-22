<?

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model app\models\Termekek */
?>

<?php if (Yii::$app->cart->items): ?>

    <div id="kosar" style="clear:both;">
        <table class="table-cart" border="0">
            <tbody>
            <tr>
                <th></th>
                <th style="text-align:left;">Márka, terméknév</th>
                <th style="text-align:left;">Szín</th>
                <th>Méret</th>
                <th>Egységár</th>
                <th>Menny</th>
                <th>Összesen</th>
                <th>Törlés</th>
            </tr>
            <?php foreach (Yii::$app->cart->items as $item) {
                $model = $item['item']; ?>
                <tr>
                    <td style="text-align:center;">
                        <a href="/hu/termek/ultrarange-rapidweld/7347">
                            <img src="<?= $model->termek->getDefaultImage()['webUrl'] ?>"
                                 style="padding:1px; border:1px solid #2a87e4; width:50px;height:50px;vertical-align:text-middle;"
                                 alt="<?= $model->termek->termeknev ?>"></a></td>
                    <td style="border-bottom:1px solid #CCC;text-align:left;">
                        <a href="/hu/termek/ultrarange-rapidweld/7347"><?= $model->termek->marka->markanev ?></a>
                        <a href="/hu/termek/ultrarange-rapidweld/7347"><?= $model->termek->termeknev ?></a></td>
                    <td style="border-bottom:1px solid #CCC;text-align:left;"><a
                                href="/hu/termek/ultrarange-rapidweld/7347"><?= $model->termek->szin ?></a>
                    </td>
                    <td style="border-bottom:1px solid #CCC;"><a href="/hu/termek/ultrarange-rapidweld/7347"
                                                                 class="arrow_box"><?= $model->megnevezes ?></a>
                    </td>
                    <td style="border-bottom:1px solid #CCC;" align="right">
                        <?php
                        if ($model->termek->kisker_ar > $model->termek->vegleges_ar) {
                            echo '<del>' . Yii::$app->formatter->asDecimal($model->termek->kisker_ar) . ' Ft</del>';
                        }
                        ?>
                        <?= Yii::$app->formatter->asDecimal($model->termek->vegleges_ar) ?> Ft
                    </td>
                    <td style="border-bottom:1px solid #CCC;">
                        <?= Html::dropDownList('quantity', $item['quantity'] . '#' . $model->vonalkod, $item['quantityItems'], ['class' => 'form-control']); ?>
                    </td>
                    <td style="border-bottom:1px solid #CCC;"><?= Yii::$app->formatter->asDecimal($model->termek->vegleges_ar * $item['quantity']) ?>
                        Ft
                    </td>
                    <td style="border-bottom:1px solid #CCC;" align="center"><a
                                href="javascript:deleteCartItem('<?= $model->vonalkod ?>')"><img
                                    src="/images/delete.png"></a></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="8">

                </td>
            </tr>

            <tr>
                <td colspan="5" style="text-align:right;">Kuponkód:</td>
                <td style="text-align:right;" colspan="2">
                    <?php
                    $code = Yii::$app->cart->getCouponCode();
                    echo Html::textInput('kupon', $code['code'], ['class' => 'form-control kupon ' . ($code && $code['success'] ? 'form-control-success' : 'form-control-danger'), 'placeholder' => 'kuponkód']);
                    ?>
                </td>
            </tr>

            <tr>
                <td colspan="5" style="text-align:right;">Összesen:</td>
                <td style="text-align:right;"
                    colspan="2"><?= Yii::$app->formatter->asDecimal(Yii::$app->cart->totalAmount) ?>
                    Ft
                </td>
            </tr>
            <tr>
                <td colspan="5" style="text-align:right;">Kedvezmények:</td>
                <td style="text-align:right;" colspan="2">-
                    <?= Yii::$app->formatter->asDecimal(Yii::$app->cart->totalDiscountAmount, 0) ?>
                    Ft
                </td>
            </tr>

            <tr>
                <td colspan="8" style="border-bottom:1px solid #CCC;"></td>
            </tr>


            <tr>
                <td colspan="5" style="text-align:right;">+ Szállítási díj:</td>
                <td style="text-align:right;"
                    colspan="2"><?= Yii::$app->formatter->asDecimal(Yii::$app->cart->shippingAmount) ?> Ft
                </td>
            </tr>

            <tr>
                <td colspan="8" style="border-top:1px solid #CCC;"></td>
            </tr>

            <tr>
                <td colspan="5" style="text-align:right;color:#999;">ÁFA összege (27%):</td>
                <td style="text-align:right;"
                    colspan="2"><?= Yii::$app->formatter->asDecimal(Yii::$app->cart->totalVATAmount, 0) ?> Ft
                </td>
            </tr>

            <tr>
                <td colspan="8" style="border-bottom:1px solid #2a87e4;"></td>
            </tr>

            <tr>
                <td colspan="5" style="text-align:right;"><font size="4">Összesen:</font></td>
                <td style="text-align:right;" colspan="2"><font
                            size="4"><?= Yii::$app->formatter->asDecimal(Yii::$app->cart->totalAmountWithShipping, 0) ?>
                        Ft</font></td>
            </tr>

            <tr>
                <td colspan="8">&nbsp;</td>
            </tr>


            </tbody>
        </table>
    </div>

    <a href="<?= Url::to(['order/create']) ?>" class="btn btn-success btn-sm cash-btn">Tovább a pénztárhoz</a>
<?php endif; ?>

<?php if (!Yii::$app->cart->items): ?>
<div id="kosar" style="clear:both;">
    ÜRES A KOSARAD
</div>
<?php endif; ?>