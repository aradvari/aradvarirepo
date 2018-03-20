<?php

namespace app\models;

use app\components\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "termek_kategoria_kapcs".
 *
 * @property int $id_termek_kategoria_kapcs
 * @property int $id_termekek
 * @property int $id_kategoriak
 */
class TermekKategoriaKapcs extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'termek_kategoria_kapcs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_termekek', 'id_kategoriak'], 'required'],
            [['id_termekek', 'id_kategoriak'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_termek_kategoria_kapcs' => 'Id Termek Kategoria Kapcs',
            'id_termekek' => 'Id Termekek',
            'id_kategoriak' => 'Id Kategoriak',
        ];
    }
}
