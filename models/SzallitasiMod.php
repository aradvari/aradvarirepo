<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "szallitasi_mod".
 *
 * @property string $id_szallitasi_mod
 * @property string $nev
 */
class SzallitasiMod extends \app\components\db\ActiveRecord
{
    const TYPE_CSOMAGKULDO = 1;
    const TYPE_SZEMELYES = 2;
    const TYPE_GLS = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'szallitasi_mod';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nev'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_szallitasi_mod' => 'Id Szallitasi Mod',
            'nev' => 'Nev',
        ];
    }
}
