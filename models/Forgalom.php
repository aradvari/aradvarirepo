<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "forgalom".
 *
 * @property integer $id_forgalom
 * @property integer $id_raktar
 * @property integer $id_vonalkod
 * @property integer $id_keszlet
 * @property integer $lista_ar
 * @property integer $fogy_ar
 * @property integer $statusz
 * @property string $datum
 */
class Forgalom extends \app\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forgalom';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_raktar', 'id_vonalkod'], 'required'],
            [['id_raktar', 'id_vonalkod', 'id_keszlet', 'lista_ar', 'fogy_ar'], 'integer'],
            [['datum'], 'safe'],
//            [['statusz'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_forgalom' => 'Id Forgalom',
            'id_raktar' => 'Id Raktar',
            'id_vonalkod' => 'Id Vonalkod',
            'id_keszlet' => 'Id Keszlet',
            'lista_ar' => 'Lista Ar',
            'fogy_ar' => 'Fogy Ar',
            'statusz' => 'Statusz',
            'datum' => 'Datum',
        ];
    }
}
