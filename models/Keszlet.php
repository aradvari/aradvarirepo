<?php

namespace app\models;

use app\components\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "keszlet".
 *
 * @property int $id_keszlet
 * @property int $id_raktar
 * @property int $id_vonalkod
 * @property int $id_bevetelezes
 * @property int $id_kivezetes
 * @property int $fogy_ar
 * @property string $bekerulesi_ar
 * @property string $bekerulesi_datum
 * @property string $kikerulesi_ar
 * @property string $kikerulesi_datum
 * @property int $id_felhasznalok
 * @property int $id_bevetelezo
 * @property int $id_kivezeto
 */
class Keszlet extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'keszlet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_raktar', 'id_vonalkod'], 'required'],
            [['id_raktar', 'id_vonalkod', 'id_bevetelezes', 'id_kivezetes', 'fogy_ar', 'bekerulesi_ar', 'kikerulesi_ar', 'id_felhasznalok', 'id_bevetelezo', 'id_kivezeto'], 'integer'],
            [['bekerulesi_datum', 'kikerulesi_datum'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_keszlet' => 'Id Keszlet',
            'id_raktar' => 'Id Raktar',
            'id_vonalkod' => 'Id Vonalkod',
            'id_bevetelezes' => 'Id Bevetelezes',
            'id_kivezetes' => 'Id Kivezetes',
            'fogy_ar' => 'Fogy Ar',
            'bekerulesi_ar' => 'Bekerulesi Ar',
            'bekerulesi_datum' => 'Bekerulesi Datum',
            'kikerulesi_ar' => 'Kikerulesi Ar',
            'kikerulesi_datum' => 'Kikerulesi Datum',
            'id_felhasznalok' => 'Id Felhasznalok',
            'id_bevetelezo' => 'Id Bevetelezo',
            'id_kivezeto' => 'Id Kivezeto',
        ];
    }
}
