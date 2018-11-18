<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "szavazas_valasz".
 *
 * @property integer $valasz_id
 * @property integer $kerdes_id
 * @property string $valasz
 */
class SzavazasValasz extends \app\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'szavazas_valasz';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kerdes_id', 'valasz'], 'required'],
            [['kerdes_id'], 'integer'],
            [['valasz'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'valasz_id' => 'Valasz ID',
            'kerdes_id' => 'Kerdes ID',
            'valasz' => 'Valasz',
        ];
    }

    public function getSzavazasSzavazat()
    {
        return $this->hasOne(SzavazasSzavazat::className(), ['valasz_id' => 'valasz_id']);
    }

}
