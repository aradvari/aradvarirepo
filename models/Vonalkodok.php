<?php

namespace app\models;

use app\components\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "vonalkodok".
 *
 * @property int $id_vonalkod
 * @property int $id_termek
 * @property string $vonalkod
 * @property string $megnevezes
 * @property int $aktiv
 * @property int $keszlet_1
 * @property int $keszlet_2
 * @property int $keszlet_3
 * @property string $id_shoprenter zoneshop id
 */
class Vonalkodok extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vonalkodok';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_termek', 'aktiv'], 'required'],
            [['id_termek', 'aktiv', 'keszlet_1', 'keszlet_2', 'keszlet_3'], 'integer'],
            [['vonalkod'], 'string', 'max' => 100],
            [['megnevezes'], 'string', 'max' => 50],
            [['id_shoprenter'], 'string', 'max' => 11],
            [['vonalkod'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_vonalkod' => 'Id Vonalkod',
            'id_termek' => 'Id Termek',
            'vonalkod' => 'Vonalkod',
            'megnevezes' => 'Megnevezes',
            'aktiv' => 'Aktiv',
            'keszlet_1' => 'Keszlet 1',
            'keszlet_2' => 'Keszlet 2',
            'keszlet_3' => 'Keszlet 3',
            'id_shoprenter' => 'Id Shoprenter',
        ];
    }

    public function getTermek()
    {
        return $this->hasOne(Termekek::className(), ['id' => 'id_termek']);
    }

    public function getKeszletek1()
    {
        return $this->hasMany(Keszlet::className(), ['id_vonalkod' => 'id_vonalkod'])->andOnCondition(['kikerulesi_datum' => null, 'kikerulesi_ar' => null, 'id_raktar' => 1]);
    }

    public function getKeszlet1()
    {
        return $this->hasOne(Keszlet::className(), ['id_vonalkod' => 'id_vonalkod'])->andOnCondition(['kikerulesi_datum' => null, 'kikerulesi_ar' => null, 'id_raktar' => 1]);
    }

}
