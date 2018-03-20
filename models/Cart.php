<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Json;
use yii\web\Cookie;

/**
 * ContactForm is the model behind the contact form.
 */
class Cart extends Model
{
    public $items = [];
    public $totalAmount = 0;
    public $totalVATAmount = 0;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['items'],
        ];
    }

    public function init()
    {
        parent::init();
        $this->items = $this->getItems();

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

                $data = [
                    'item' => $model,
                    'quantity' => $item['quantity'],
                ];
                $item = $data;
            }
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

    public function addItem($vonalkod, $quantity = 1)
    {

        $this->items[$vonalkod] = [
            'item' => $vonalkod,
            'quantity' => (isset($this->items[$vonalkod]) ? ((int)$this->items[$vonalkod]['quantity'] + $quantity) : $quantity),
        ];

        $cookies = Yii::$app->response->cookies;
        $cookies->add(new Cookie([
            'name' => 'cart',
            'value' => Json::encode($this->items),
        ]));

    }

}
