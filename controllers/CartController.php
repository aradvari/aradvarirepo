<?php

namespace app\controllers;

use app\models\Vonalkodok;
use Yii;
use app\components\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;

class CartController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'ajax-add-item' => ['POST'],
                    'get-cart-count' => ['GET'],
                ],
            ],
        ];
    }

    public function actionView()
    {
        if (!Yii::$app->cart->items)
            return $this->render('_empty_cart');

        return $this->render('view');
    }

    public function actionAjaxAddItem()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $meret = Yii::$app->request->post('meret');
        $mennyiseg = Yii::$app->request->post('mennyiseg');
        $modify = Yii::$app->request->post('modify');

        $vonalkodModel = Vonalkodok::findOne(['vonalkod' => $meret]);
        $termekModel = $vonalkodModel->termek;

        if (Yii::$app->cart->getItemQuantity($meret) + $mennyiseg > $vonalkodModel->keszlet_1) {
            $mennyiseg = $vonalkodModel->keszlet_1 - Yii::$app->cart->getItemQuantity($meret);
        }

        Yii::$app->cart->addItem($meret, $mennyiseg, $modify);

        return [
            'meret' => $meret,
            'mennyiseg' => (int)$mennyiseg,
            'termek' => [
                'megnevezes' => $termekModel->termeknev,
                'ar' => \Yii::$app->formatter->asDecimal($termekModel->vegleges_ar * (int)$mennyiseg),
            ],
        ];
    }

    public function actionAjaxDeleteCartItem()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $meret = Yii::$app->request->post('meret');

        return Yii::$app->cart->deleteItem($meret);

    }

    public function actionGetCartCount()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $cart = Yii::$app->cart;

        return [
            'count' => $cart->getCount(),
        ];
    }

    public function actionAjaxSetCode()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $code = Yii::$app->request->post('kupon');

        return Yii::$app->cart->setCouponCode($code);

    }

    public function actionGetCart()
    {
        return $this->renderAjax('_cart');
    }

}
