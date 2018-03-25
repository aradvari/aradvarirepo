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
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    public $contract = false;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
//            ['contract', 'required', 'requiredValue' => 1, 'message' => 'A szerződési feltételek elfogadása kötelező!'],
            // rememberMe must be a boolean value
            [['rememberMe', 'contract'], 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'E-mail cím',
            'password' => 'Jelszó',
            'rememberMe' => 'Bejelentkezés megjegyzése',
            'contract' => 'Szerződési feltételek',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
//            $this->_user = Felhasznalok::find()->andWhere(['email' => $this->username, 'torolve' => null])->andWhere(['not', ['aktivacios_kod' => null]])->one();
            $this->_user = Felhasznalok::getUser($this->username, 'normal');
        }

        return $this->_user;
    }
}
