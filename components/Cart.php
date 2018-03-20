<?php

namespace app\components;

use app\models\Vonalkodok;
use yii\base\Component;
use Yii;
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

    public function init()
    {
        parent::init();
        $this->items = $this->getItems();
        $this->couponCode = $this->getCouponCode();

    }

    public function setCouponCode($code)
    {

        $this->couponCode = [
            'code' => $code,
            'success' => array_key_exists($code, Yii::$app->params['couponItems']),
        ];

        $cookies = Yii::$app->response->cookies;
        $cookies->add(new Cookie([
            'name' => 'cart-coupon',
            'value' => Json::encode($this->couponCode),
        ]));

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

    public function getItems()
    {

        $cookies = Yii::$app->request->cookies;
        $items = json_decode($cookies->getValue('cart'), true);

        $this->totalAmount = 0;
        $this->totalVATAmount = 0;

        if (is_array($items)) {
            foreach ($items as $key => &$item) {

                $model = Vonalkodok::find()->joinWith(['termek', 'termek.marka'])->andWhere(['vonalkod' => $item['item']])->one();

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
                    'quantityItems' => $maxItem,
                ];
                $item = $data;

            }
        }

        $this->totalAmountWithShipping = $this->totalAmount + $this->shippingAmount;

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

    public function deleteItem($vonalkod)
    {

        unset($this->items[$vonalkod]);

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

        return true;

    }

}