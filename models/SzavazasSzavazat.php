<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "szavazas_szavazat".
 *
 * @property integer $id
 * @property integer $kerdes_id
 * @property integer $valasz_id
 * @property integer $szavazat
 */
class SzavazasSzavazat extends \app\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'szavazas_szavazat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kerdes_id', 'valasz_id', 'szavazat'], 'required'],
            [['kerdes_id', 'valasz_id', 'szavazat'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kerdes_id' => 'Kerdes ID',
            'valasz_id' => 'Valasz ID',
            'szavazat' => 'Szavazat',
        ];
    }
}
