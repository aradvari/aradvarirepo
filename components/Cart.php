<?php

namespace app\components;

use app\models\GlobalisAdatok;
use app\models\SzallitasiMod;
use app\models\Vonalkodok;
use yii\base\Component;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Cookie;

class Cart extends Component
{

    public $items = [];
    public $totalAmount = 0;
    public $totalAmountWithShipping = 0;
    public $totalVATAmount = 0;
    public $totalDiscountAmount = 0;
    public $shippingAmount = 990;
    public $couponCode;
    public $shippingType;

    public function init()
    {
        parent::init();

        $this->items = $this->getItems();
        $this->couponCode = $this->getCouponCode();
        $this->refreshItems();

    }

    public function setCouponCode($code)
    {

        $success = array_key_exists($code, Yii::$app->params['couponItems']);

        $this->couponCode = [
            'code' => $code,
            'success' => $success,
        ];

        $cookies = Yii::$app->response->cookies;
        $cookies->add(new Cookie([
            'name' => 'cart-coupon',
            'value' => Json::encode($this->couponCode),
        ]));

        return $this->couponCode;

    }

    public function getCouponCode()
    {
        $cookies = Yii::$app->request->cookies;
        $code = json_decode($cookies->getValue('cart-coupon'), true);

        return [
            'code' => $code['code'],
            'success' => array_key_exists($code['code'], Yii::$app->params['couponItems']),
        ];

    }

    public static function getStaticCouponCode()
    {
        $cookies = Yii::$app->request->cookies;
        $code = json_decode($cookies->getValue('cart-coupon'), true);

        return [
            'code' => $code['code'],
            'success' => array_key_exists($code['code'], Yii::$app->params['couponItems']),
        ];

    }

    public function getItemQuantity($vonalkod)
    {

        return (int)ArrayHelper::getValue($this->items, $vonalkod . '.quantity');

    }

    public function getItems()
    {
        $this->shippingType = Yii::$app->session->get('shippingType', SzallitasiMod::TYPE_CSOMAGKULDO);

        $cookies = Yii::$app->request->cookies;
        $items = json_decode($cookies->getValue('cart'), true);

        $this->totalAmount = 0;
        $this->totalVATAmount = 0;

        if (is_array($items)) {
            foreach ($items as $key => &$item) {

                $model = Vonalkodok::find()->joinWith(['termek', 'termek.marka'])->andWhere(['vonalkod' => $item['item']])->one();

                if ($model->keszlet_1 < 1) {
                    unset($items[$key]);

                    if (!Yii::$app->request->isAjax)
                        Yii::$app->session->setFlash('danger', 'Sajnáljuk, de a kosaradban található <span class="font-weight-bold">' . $model->termek->termeknev . '</span> termék időközben elfogyott!');

                    break;
                }

                if ($model->keszlet_1 < $item['quantity']) {
                    $item['quantity'] = $model->keszlet_1;
                }

                $this->totalAmount += $model->termek->vegleges_ar * $item['quantity'];
                $this->totalVATAmount += ($model->termek->vegleges_ar * $item['quantity']) * (Yii::$app->params['vat'] / 100);
                $this->totalDiscountAmount += ($model->termek->kisker_ar * $item['quantity']) - ($model->termek->vegleges_ar * $item['quantity']);

                $maxItem = [];
                for ($i = 1; $i <= $model->keszlet_1; $i++) {
                    $maxItem[$i . '#' . $model->vonalkod] = $i . ' db';
                }

                $data = [
                    'item' => $model,
                    'quantity' => $item['quantity'],
                    'different' => $model->keszlet_1,
                    'quantityItems' => $maxItem,
                ];
                $item = $data;

            }
        }

        //Free shipping check
        if ($this->totalAmount > GlobalisAdatok::getParam('ingyenes_szallitas'))
            $this->shippingAmount = 0;

        if ($this->shippingType != SzallitasiMod::TYPE_SZEMELYES)
            $this->totalAmountWithShipping = $this->totalAmount + $this->shippingAmount;
        else {
            $this->totalAmountWithShipping = $this->totalAmount;
            $this->shippingAmount = 0;
        }

        return $items;

    }

    public function getCount()
    {
        $count = 0;
        if (is_array($this->items)) {
            foreach ($this->items as $item) {
                $count += $item['quantity'];
            }
        }
        return $count;
    }

    public function addItem($vonalkod, $quantity = 1, $modify = false)
    {

        $this->items[$vonalkod] = [
            'item' => $vonalkod,
            'quantity' => ((isset($this->items[$vonalkod]) && !$modify) ? ((int)$this->items[$vonalkod]['quantity'] + $quantity) : $quantity),
        ];

        $cookies = Yii::$app->response->cookies;
        $cookies->add(new Cookie([
            'name' => 'cart',
            'value' => Json::encode($this->items),
        ]));

    }

    public function deleteItem($vonalkod, $quantity = null)
    {
        if ($quantity) {
            $this->items[$vonalkod]['quantity'] -= $quantity;
            if ($this->items[$vonalkod]['quantity'] < 1)
                unset($this->items[$vonalkod]);
        } else {
            unset($this->items[$vonalkod]);
        }

        $cookies = Yii::$app->response->cookies;
        $cookies->add(new Cookie([
            'name' => 'cart',
            'value' => Json::encode($this->items),
        ]));

        return true;

    }

    public function refreshItems()
    {

        $cookies = Yii::$app->response->cookies;
        $cookies->add(new Cookie([
            'name' => 'cart',
            'value' => Json::encode($this->items),
        ]));

        return true;

    }

    public function delete()
    {

        $cookies = Yii::$app->response->cookies;
        $cookies->remove('cart');

        $this->items = [];
        $this->totalAmount = 0;
        $this->totalAmountWithShipping = 0;
        $this->totalVATAmount = 0;
        $this->totalDiscountAmount = 0;

        return true;

    }

}