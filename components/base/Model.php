<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\components\base;

class Model extends \yii\base\Model
{

    public function afterValidate()
    {
        if ($this->errors && is_array($this->errors)) {

            foreach ($this->errors as $error) {
                if (is_array($error)) {
                    foreach ($error as $item) {
                        \Yii::$app->session->addFlash('error', $item);
                    }
                } else {
                    \Yii::$app->session->addFlash('error', $error);
                }

            }

        }


        return parent::beforeValidate();

    }

}
