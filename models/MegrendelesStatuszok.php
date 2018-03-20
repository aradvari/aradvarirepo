<?php

namespace app\models;

use app\components\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "megrendeles_statuszok".
 *
 * @property int $id_megrendeles_statusz
 * @property string $statusz_nev
 */
class MegrendelesStatuszok extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'megrendeles_statuszok';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['statusz_nev'], 'required'],
            [['statusz_nev'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_megrendeles_statusz' => 'Id Megrendeles Statusz',
            'statusz_nev' => 'Statusz Nev',
        ];
    }
}
