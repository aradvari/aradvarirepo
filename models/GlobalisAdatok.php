<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "globalis_adatok".
 *
 * @property string $kulcs
 * @property string $ertek
 * @property string $megnevezes
 * @property integer $sorrend
 */
class GlobalisAdatok extends \app\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'globalis_adatok';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kulcs', 'ertek', 'megnevezes', 'sorrend'], 'required'],
            [['ertek'], 'string'],
            [['sorrend'], 'integer'],
            [['kulcs'], 'string', 'max' => 30],
            [['megnevezes'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kulcs' => 'Kulcs',
            'ertek' => 'Ertek',
            'megnevezes' => 'Megnevezes',
            'sorrend' => 'Sorrend',
        ];
    }

    public static function getParam($paramName)
    {
        return GlobalisAdatok::findOne(['kulcs' => $paramName])->ertek;
    }

}
