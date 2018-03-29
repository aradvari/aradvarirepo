<?php

namespace app\components\web;

class Controller extends \yii\web\Controller
{

    public function afterAction($action, $result)
    {
        if (YII_DEBUG)
            \Yii::$app->seo->validate();
        
        return parent::afterAction($action, $result); // TODO: Change the autogenerated stub
    }

}