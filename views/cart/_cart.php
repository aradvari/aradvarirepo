<?

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model app\models\Termekek */
?>

<div class="cart-container alice-blue-bg">

    <?php if (Yii::$app->cart->items): ?>
        <h4> Kosarad <span class="maire"> tartalma </span></h4>
        <table class="table">
            <tbody>
            <tr>
                <th scope="col">Termék</th>
                <th scope="col">Menny.</th>
                <th scope="col">Egységár</th>
                <th scope="col">Összesen</th>
                <th scope="col">Törlés</th>
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
                <tr class="cart-product-name">

                    <!-- Product brandname, name, color, size -->
                    <td scope="row" class="text-center align-middle">
                        <div class="media">
                            <img src="<?= $model->termek->getDefaultImage()['webUrl'] ?>"
                                 alt="<?= $model->termek->termeknev ?>" class="cart-img">
                            <div class="media-body text-left">
                                <p> <span class="text-nowrap">
                                    <a href="<?= $termekUrl ?>"><?= $model->termek->marka->markanev ?></a>
                                    <a href="<?= $termekUrl ?>"><?= $model->termek->termeknev ?></a>
                                </span>
                                    <br>


                                    <span class="text-nowrap">Szín: <a
                                                href="<?= $termekUrl ?>"><?= $model->termek->szin ?></a></span><br>
                                    <span class="text-nowrap">Méret: <a
                                                href="<?= $termekUrl ?>"><?= $model->megnevezes ?></a></span>
                                    <!-- Méret -->
                                </p>
                            </div>
                        </div>

                    </td>  <!-- //Product brandname, name, color, size -->

                    <!-- Product quantity -->
                    <td scope="row" cclass="text-right align-middle">
                        <?= Html::dropDownList('quantity', $item['quantity'] . '#' . $model->vonalkod, $item['quantityItems'], ['class' => 'form-control']); ?>
                    </td>

                    <!-- Product price -->
                    <td class="text-right align-middle">
                        <?php
                        if ($model->termek->kisker_ar > $model->termek->vegleges_ar) {
                            echo '<del>' . Yii::$app->formatter->asDecimal($model->termek->kisker_ar) . ' Ft</del>';
                        }
                        ?>
                        <?= Yii::$app->formatter->asDecimal($model->termek->vegleges_ar) ?> Ft
                    </td>

                    <!-- Product price -->
                    <td class="text-right align-middle">
                        <p class="text-nowrap"><?= Yii::$app->formatter->asDecimal($model->termek->vegleges_ar * $item['quantity']) ?>
                            Ft</p>
                    </td>

                    <!-- Product delete element -->
                    <td class="text-center align-middle">
                        <a href="javascript:deleteCartItem('<?= $model->vonalkod ?>')">
                            <img src="/images/delete.png">
                        </a>
                    </td>


                </tr>

            <?php } ?>

            <tr>
                <td colspan="2" class="text-right align-middle">Kuponkód</td>
                <td colspan="3" class="text-right align-middle">
                    <div class="input-group mb-3">
                        <?php
                        $code = Yii::$app->cart->getCouponCode();
                        echo Html::textInput('kupon', $code['code'], ['class' => 'form-control kupon ' . ($code && $code['success'] ? 'is-valid' : 'is-invalid'), 'placeholder' => 'kuponkód']);
                        ?>
                        <div class="input-group-append">
                            <button class="btn btn-secondary kupon-btn" type="button">Beváltás</button>
                        </div>
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan="2" class="text-right align-middle">Összesen</td>
                <td colspan="3" class="text-right align-middle">
                    <?= Yii::$app->formatter->asDecimal(Yii::$app->cart->totalAmount) ?> Ft<br>
                    <span class="small opacity-50">ÁFA (27%): <?= Yii::$app->formatter->asDecimal(Yii::$app->cart->totalVATAmount, 0) ?>
                        Ft</span>
                </td>
            </tr>

            <?php if (Yii::$app->cart->totalDiscountAmount): ?>
                <tr>
                    <td colspan="2" class="text-right align-middle">Kedvezmények</td>
                    <td colspan="3" class="text-right align-middle">-
                        <?= Yii::$app->formatter->asDecimal(Yii::$app->cart->totalDiscountAmount, 0) ?> Ft
                    </td>
                </tr>
            <?php endif; ?>

            <tr class="cart-product-name">
                <td colspan="2" class="text-right align-middle">+ Szállítási díj</td>
                <td colspan="3" class="text-right align-middle">
                    <?php if (Yii::$app->cart->shippingAmount): ?>
                        <?= Yii::$app->formatter->asDecimal(Yii::$app->cart->shippingAmount) . ' Ft' ?>
                    <?php else: ?>
                        INGYENES
                    <?php endif; ?>
                </td>
            </tr>

            <tr class="font-weight-bold">

                <td colspan="2" class="text-right align-middle">Fizetendő</td>
                <td colspan="3" class="text-right align-middle">
                    <?= Yii::$app->formatter->asDecimal(Yii::$app->cart->totalAmountWithShipping, 0) ?> Ft
                </td>

            </tr>

            </tbody>
        </table>
        <a href="<?= Url::to(['order/create']) ?>" class="btn btn-primary btn-sm cash-btn float-right">Tovább a
            pénztárhoz</a>
        <div class="clearfix"></div>

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
</div> <!-- //cart-container-->