<?php

namespace app\models;

use app\components\base\Model;
use Yii;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LostPwForm extends Model
{
    public $username;
    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['username'], 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'E-mail cím',
        ];
    }

}
