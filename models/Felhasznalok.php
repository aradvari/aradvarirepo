<?php

namespace app\models;

use app\components\db\ActiveRecord;
use Yii;
use yii\base\Event;
use yii\db\Expression;

/**
 * This is the model class for table "felhasznalok".
 *
 * @property int $id
 * @property string $vezeteknev
 * @property string $keresztnev
 * @property string $cegnev
 * @property string $orszag_nev
 * @property int $id_orszag
 * @property string $irszam
 * @property int $id_megye
 * @property string $megye_nev
 * @property int $id_varos
 * @property string $varos_nev
 * @property string $utcanev
 * @property int $id_kozterulet
 * @property string $kozterulet_nev
 * @property string $hazszam
 * @property string $emelet
 * @property string $email
 * @property string $telefonszam1
 * @property string $telefonszam2
 * @property int $szuletesi_ev
 * @property int $szuletesi_honap
 * @property int $szuletesi_nap
 * @property string $jelszo
 * @property int $hirlevel
 * @property string $aktivacios_kod
 * @property int $klubtag_kod
 * @property int $kartya_kod
 * @property string $regisztralva
 * @property string $utolso_belepes
 * @property string $session_id
 * @property int $modositva
 * @property int $modositva2
 * @property int $modositva3
 * @property string $torolve
 */
class Felhasznalok extends ActiveRecord implements \yii\web\IdentityInterface
{

    const SCENARIO_FACEBOOK_REGISTER = 'fb_register';
    const SCENARIO_REGISTER = 'register';
    const SCENARIO_MODIFY = 'modify';
    const SCENARIO_PW = 'password';
    const SCENARIO_DELETE = 'delete';
    const SCENARIO_LOST_PW = 'lost_pw';
    const SCENARIO_SUBSCRIBE = 'subscribe';

    public $regi_jelszo;
    public $jelszo_ismetles;
    public $auth_key;

    public $contract = false;
    public $teljes_nev;

    public $create_user = false;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'felhasznalok';
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_LOST_PW => ['uj_jelszo'],
            self::SCENARIO_DELETE => ['contract'],
            self::SCENARIO_SUBSCRIBE => ['email', 'contract'],
            self::SCENARIO_FACEBOOK_REGISTER => ['email', 'vezeteknev', 'keresztnev'],
            self::SCENARIO_PW => ['jelszo', 'jelszo_ismetles', 'regi_jelszo'],
            self::SCENARIO_DEFAULT => ['vezeteknev', 'keresztnev', 'cegnev', 'irszam', 'id_megye', 'megye_nev', 'id_varos', 'varos_nev', 'utcanev', 'id_kozterulet', 'kozterulet_nev', 'emelet', 'email', 'hirlevel', 'teljes_nev', 'hazszam', 'telefonszam1', 'telefonszam2', 'jelszo', 'jelszo_ismetles', 'contract', 'create_user'],
            self::SCENARIO_REGISTER => ['vezeteknev', 'keresztnev', 'irszam', 'id_megye', 'megye_nev', 'id_varos', 'varos_nev', 'utcanev', 'id_kozterulet', 'kozterulet_nev', 'email', 'hirlevel', 'hazszam', 'telefonszam1', 'jelszo', 'jelszo_ismetles', 'contract'],
            self::SCENARIO_MODIFY => ['vezeteknev', 'keresztnev', 'cegnev', 'irszam', 'id_varos', 'varos_nev', 'utcanev', 'id_kozterulet', 'kozterulet_nev', 'hazszam', 'emelet', 'email', 'hirlevel', 'telefonszam1', 'telefonszam2', 'jelszo', 'jelszo_ismetles'],
        ];
    }

    public function init()
    {
        parent::init();

        Event::on(\yii\web\User::className(), \yii\web\User::EVENT_AFTER_LOGIN, function () {
            $this->utolso_belepes = new Expression('NOW()');
            $this->session_id = Yii::$app->session->id;
            $this->save(false);
        });
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vezeteknev', 'keresztnev', 'irszam', 'utcanev', 'id_kozterulet', 'kozterulet_nev', 'email', 'hirlevel', 'regisztralva', 'hazszam', 'telefonszam1'], 'required'],
            [['id_orszag', 'id_megye', 'id_varos', 'id_kozterulet', 'szuletesi_ev', 'szuletesi_honap', 'szuletesi_nap', 'hirlevel', 'klubtag_kod', 'kartya_kod', 'modositva', 'modositva2', 'modositva3'], 'integer'],
            [['regisztralva', 'utolso_belepes', 'torolve', 'teljes_nev', 'cegnev', 'hirlevel', 'create_user'], 'safe'],
            [['vezeteknev', 'keresztnev', 'emelet', 'telefonszam1', 'telefonszam2', 'session_id'], 'string', 'max' => 50],
            ['id_varos', 'required', 'when' => function ($model) {
                return !$model->varos_nev;
            }, 'whenClient' => "function (attribute, value) {
                    return $('#felhasznalok-varos_nev').val() == '';
            }"],
            ['varos_nev', 'required', 'when' => function ($model) {
                return !$model->id_varos;
            }, 'whenClient' => "function (attribute, value) {
                    return $('#felhasznalok-id_varos').val() == null;
            }"],
            [['cegnev'], 'string', 'max' => 255],
            [['orszag_nev', 'kozterulet_nev'], 'string', 'max' => 100],
            [['irszam'], 'string', 'max' => 4],
            [['megye_nev', 'varos_nev', 'utcanev', 'email'], 'string', 'max' => 200],
            [['hazszam'], 'string', 'max' => 20],
            [['jelszo', 'aktivacios_kod'], 'string', 'max' => 32],
            [['email'], 'email'],
            ['teljes_nev', 'match', 'pattern' => "/\s+/", 'message' => 'A teljes név legalább két részből kell hogy álljon!'],
            ['email', 'unique', 'targetAttribute' => 'email', 'when' => function ($model) {
                return $model->create_user;
            }],
            ['jelszo_ismetles', 'compare', 'compareAttribute' => 'jelszo', 'message' => 'A jelszó ismétlés nem egyezik!'],
            [['jelszo', 'jelszo_ismetles'], 'required', 'on' => self::SCENARIO_REGISTER],
            [['jelszo', 'jelszo_ismetles', 'regi_jelszo'], 'required', 'on' => self::SCENARIO_PW],
            [['regi_jelszo'], 'oldPasswordCheck', 'on' => self::SCENARIO_PW],
            [['email'], 'unique', 'filter' => ['auth_type' => 'normal'], 'on' => self::SCENARIO_FACEBOOK_REGISTER],
            ['contract', 'required', 'requiredValue' => 1, 'message' => 'A szerződési feltételek elfogadása kötelező!'],
        ];
    }

    public function oldPasswordCheck($attribute_name, $params)
    {
        if (Yii::$app->user->identity->jelszo != md5($this->$attribute_name))
            $this->addError($attribute_name, 'A régi jelszó nem megfelelő!');
        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vezeteknev' => 'Vezetéknév',
            'keresztnev' => 'Keresztnév',
            'cegnev' => 'Cégnév',
            'orszag_nev' => 'Ország',
            'id_orszag' => 'Ország azonosító',
            'irszam' => 'Irányítószám',
            'teljes_nev' => 'Teljes név',
            'id_megye' => 'Megye',
            'megye_nev' => 'Megye',
            'id_varos' => 'Város',
            'varos_nev' => 'Város',
            'utcanev' => 'Utcanév',
            'id_kozterulet' => 'Közterület típusa',
            'kozterulet_nev' => 'Kozterület típusa',
            'hazszam' => 'Házszám',
            'emelet' => 'Emelet',
            'email' => 'E-mail',
            'telefonszam1' => 'Telefonszám',
            'telefonszam2' => 'Telefonszám 2 (nem kötelező)',
            'szuletesi_ev' => 'Szuletesi Ev',
            'szuletesi_honap' => 'Szuletesi Honap',
            'szuletesi_nap' => 'Szuletesi Nap',
            'jelszo' => 'Jelszó',
            'jelszo_ismetles' => 'Jelszó ismétlés',
            'hirlevel' => 'Feliratkozom a hírlevélre',
            'contract' => 'Elfogadom az általános szerződési feltételeket',
            'aktivacios_kod' => 'Aktivacios Kod',
            'klubtag_kod' => 'Klubtag Kod',
            'kartya_kod' => 'Kartya Kod',
            'regisztralva' => 'Regisztralva',
            'utolso_belepes' => 'Utolso Belepes',
            'session_id' => 'Session ID',
            'modositva' => 'Modositva',
            'modositva2' => 'Modositva2',
            'modositva3' => 'Modositva3',
            'torolve' => 'Torolve',
            'create_user' => 'Felhasználói fiók létrehozása',
            'regi_jelszo' => 'Jelenlegi jelszó',
        ];
    }

    public function afterFind()
    {
        parent::afterFind();

        if ($this->vezeteknev || $this->keresztnev)
            $this->teljes_nev = $this->vezeteknev . ' ' . $this->keresztnev;
    }

    public function beforeValidate()
    {
        if ($this->teljes_nev && !$this->vezeteknev && $this->keresztnev) {
            $explodedName = explode(' ', $this->teljes_nev);
            $this->vezeteknev = $explodedName[0];
            $this->keresztnev = $explodedName[1];
        }

        if ($this->id_megye)
            $this->megye_nev = Megyek::findOne($this->id_megye)->MEGYE_NEV;
        if ($this->id_varos)
            $this->varos_nev = Helyseg::findOne($this->id_varos)->HELYSEG_NEV;
        if ($this->id_kozterulet)
            $this->kozterulet_nev = Kozterulet::findOne($this->id_kozterulet)->megnevezes;

        return parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->regisztralva = new Expression('NOW()');
            $this->aktivacios_kod = Yii::$app->getSecurity()->generateRandomString();
            $this->jelszo = md5($this->jelszo);
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    // Interface methods

    /** INCLUDE USER LOGIN VALIDATION FUNCTIONS**/
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param  string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['email' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param  string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->jelszo === md5($password);
//        return Security::validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = md5($password);//Security::generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Security::generateRandomKey();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Security::generateRandomKey() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public static function getUser($userName, $authType = 'normal')
    {
        return Felhasznalok::find()->andWhere(['email' => $userName, 'torolve' => null, 'auth_type' => $authType])->andWhere(['!=', 'auth_type', 'unregistered'])->one();
    }

}
