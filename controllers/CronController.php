<?php

namespace app\controllers;

use Yii;
use app\components\web\Controller;
use yii\helpers\Url;

class CronController extends Controller
{

    public function actionTest()
    {

        $termekUrl = Url::to(['termekek/view',
            'mainCategory' => 'ferfi_ruhazat',
            'subCategory' => 'pulover',
            'brand' => 'vans',
            'termek' => 'termek-neve-1233',
        ]);
        $valami = 'Hello, itt az url:' . $termekUrl;

        //sql példa
        $termekek = Yii::$app->db->createCommand('SELECT * FROM termekek LIMIT 1')->queryAll();

        return $valami.'<br>'.print_r($termekek, true);

    }

}
