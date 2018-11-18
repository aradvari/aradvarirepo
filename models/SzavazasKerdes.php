<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "szavazas_kerdes".
 *
 * @property integer $id
 * @property string $aktiv
 * @property string $kerdes
 */
class SzavazasKerdes extends \app\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'szavazas_kerdes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aktiv'], 'string'],
            [['kerdes'], 'required'],
            [['kerdes'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aktiv' => 'Aktiv',
            'kerdes' => 'Kerdes',
        ];
    }

    public function getSzavazasValasz()
    {
        return $this->hasMany(SzavazasValasz::className(), ['kerdes_id' => 'id']);
    }

}
