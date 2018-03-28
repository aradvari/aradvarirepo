<?php

namespace app\models;

use app\components\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "kozterulet".
 *
 * @property int $id_kozterulet
 * @property string $megnevezes
 */
class Kozterulet extends ActiveRecord
{

    const NAME_UTCA = 6;
    const NAME_UT = 7;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kozterulet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['megnevezes'], 'required'],
            [['megnevezes'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_kozterulet' => 'Id Kozterulet',
            'megnevezes' => 'Megnevezes',
        ];
    }
}
