<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\components\db;

class ActiveRecord extends \yii\db\ActiveRecord
{

    public function afterValidate()
    {
        if ($this->errors && is_array($this->errors)) {

            foreach ($this->errors as $error) {
                if (is_array($error)) {
                    foreach ($error as $item) {
                        \Yii::$app->session->addFlash('danger', $item);
                    }
                } else {
                    \Yii::$app->session->addFlash('danger', $error);
                }

            }

        }


        return parent::beforeValidate();

    }

}
