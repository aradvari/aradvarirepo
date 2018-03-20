<?php

namespace app\models;

use app\components\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "termekkapcsolatok".
 *
 * @property int $id
 * @property int $kategoriaid
 * @property int $kapcsolat
 */
class Termekkapcsolatok extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'termekkapcsolatok';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kategoriaid', 'kapcsolat'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kategoriaid' => 'Kategoriaid',
            'kapcsolat' => 'Kapcsolat',
        ];
    }
}
