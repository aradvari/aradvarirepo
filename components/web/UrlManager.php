<?php

namespace app\components\web;

use app\models\Cart;
use app\models\Kategoriak;
use app\models\Markak;
use lajax\translatemanager\helpers\Language;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class UrlManager extends \yii\web\UrlManager
{

    public $paramRegural = '((meret|szin|tipus)_([\w_\-\"]+))';

    public function init()
    {
        parent::init();
        $this->generateRules();
    }

    public function parseRequest($request)
    {
        $parse = parent::parseRequest($request);

        foreach ($parse[1] as $key => $item) {
            $matches = [];
//            preg_match("/((meret|szin|keresendo|sorrend)_(\\w+))/", $item, $matches);
//            preg_match("/((meret|szin|keresendo|sorrend)_([\\w_\\-\\\"]+))/", $item, $matches);
            preg_match("/" . $this->paramRegural . "/", $item, $matches);
            if ($matches[2] && $matches[3]) {
//                var_dump($parse[1]);
                $parse[1] = ArrayHelper::merge($parse[1], [$matches[2] => $matches[3]]);
            }
        }

//        var_dump($parse);

        return $parse;
    }

    public function createUrl($params)
    {
        $paramNames = [
            'szin' => 'param1',
            'meret' => 'param2',
            'tipus' => 'param3',
//            'keresendo'=>'param3',
//            'sorrend'=>'param4',
        ];
        foreach ($params as $key => $param) {

            if (in_array((string)$key, ['meret', 'szin', 'tipus', /*'keresendo', 'sorrend'*/])) {
                if ($params[$key]) {
                    $params[$paramNames[$key]] = $key . '_' . $params[$key];
                    unset($params[$key]);
                }
            }

        }

        return parent::createUrl($params);
    }

    public function generateRules()
    {
        $mainCategorys = Kategoriak::findAllMainCategory();
        $mainCategorysString = implode("|", ArrayHelper::getColumn($mainCategorys, 'url_segment'));

        $subCategorys = Kategoriak::findAllSubCategory();
        $subCategorysString = implode("|", ArrayHelper::getColumn($subCategorys, 'url_segment'));

        $brands = Markak::find()->andWhere(['sztorno' => null])->all();
        $brandsString = implode("|", ArrayHelper::getColumn($brands, 'url_segment'));

        $paramRule = '<param1:' . $this->paramRegural . '>/<param2:' . $this->paramRegural . '>/<param3:' . $this->paramRegural . '>/<param4:' . $this->paramRegural . '>/<param5:' . $this->paramRegural . '>';

        $this->addRules([
            [
                'pattern' => '<mainCategory:(' . $mainCategorysString . ')>/<subCategory:(' . $subCategorysString . ')>/<brand:(' . $brandsString . ')>/' . $paramRule,
                'route' => 'termekek/index',
                'defaults' => [
                    'param1' => '',
                    'param2' => '',
                    'param3' => '',
                    'param4' => '',
                    'param5' => '',
                ],
            ],
            [
                'pattern' => '<mainCategory:(' . $mainCategorysString . ')>/<subCategory:(' . $subCategorysString . ')>/' . $paramRule,
                'route' => 'termekek/index',
                'defaults' => [
                    'param1' => '',
                    'param2' => '',
                    'param3' => '',
                    'param4' => '',
                    'param5' => '',
                ],
            ],
            [
                'pattern' => '<mainCategory:(' . $mainCategorysString . ')>/<brand:(' . $brandsString . ')>/' . $paramRule,
                'route' => 'termekek/index',
                'defaults' => [
                    'param1' => '',
                    'param2' => '',
                    'param3' => '',
                    'param4' => '',
                    'param5' => '',
                ],
            ],
            [
                'pattern' => '<brand:(' . $brandsString . ')>/' . $paramRule,
                'route' => 'termekek/index',
                'defaults' => [
                    'param1' => '',
                    'param2' => '',
                    'param3' => '',
                    'param4' => '',
                    'param5' => '',
                ],
            ],
            [
                'pattern' => '<mainCategory:(' . $mainCategorysString . ')>/' . $paramRule,
                'route' => 'termekek/index',
                'defaults' => [
                    'param1' => '',
                    'param2' => '',
                    'param3' => '',
                    'param4' => '',
                    'param5' => '',
                ],
            ],
            [
                'pattern' => 'termekek/' . $paramRule,
                'route' => 'termekek/index',
                'defaults' => [
                    'param1' => '',
                    'param2' => '',
                    'param3' => '',
                    'param4' => '',
                    'param5' => '',
                ],
            ],
            [
                'pattern' => '<mainCategory:(' . $mainCategorysString . ')>/<subCategory:(' . $subCategorysString . ')>/<brand:(' . $brandsString . ')>/<termek>',
                'route' => 'termekek/view',
            ],
            /*
             * URL REDIRECT
             */
            [
                'pattern' => 'hu/termekek/<categoryName>/<categoryId>/<brandName>/<brandId>',
                'route' => 'termekek/redirect',
            ],
            [
                'pattern' => 'hu/termekek/<categoryName>/<categoryId>',
                'route' => 'termekek/redirect',
            ],
            [
                'pattern' => 'hu/termekek',
                'route' => 'termekek/redirect',
            ],
            [
                'pattern' => 'hu/termek/<productName>/<productId>',
                'route' => 'termekek/redirect',
            ],
            [
                'pattern' => 'hu/<page>',
                'route' => 'site/redirect',
            ],
        ]);

    }

}
