<?php

namespace app\models;

use app\components\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "megyek".
 *
 * @property int $ID_MEGYE
 * @property string $MEGYE_NEV
 * @property int $ID_REGIO
 */
class Megyek extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'megyek';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_MEGYE'], 'required'],
            [['ID_MEGYE', 'ID_REGIO'], 'integer'],
            [['MEGYE_NEV'], 'string', 'max' => 50],
            [['ID_MEGYE'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_MEGYE' => 'Id  Megye',
            'MEGYE_NEV' => 'Megye  Nev',
            'ID_REGIO' => 'Id  Regio',
        ];
    }
}
