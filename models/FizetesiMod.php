<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fizetesi_mod".
 *
 * @property string $id_fizetesi_mod
 * @property string $nev
 */
class FizetesiMod extends \app\components\db\ActiveRecord
{

    const TYPE_KESZPENZ = 1;
    const TYPE_BANK = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fizetesi_mod';
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
            'id_fizetesi_mod' => 'Id Fizetesi Mod',
            'nev' => 'Nev',
        ];
    }
}
