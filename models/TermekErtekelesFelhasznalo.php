<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "termek_ertekeles_felhasznalo".
 *
 * @property string $id_termek_ertekeles_felhasznalo
 * @property integer $id_termek_ertekeles
 * @property integer $id_felhasznalo
 * @property string $datum
 */
class TermekErtekelesFelhasznalo extends \app\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'termek_ertekeles_felhasznalo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_termek', 'id_felhasznalo', 'ertek'], 'integer'],
            [['datum'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_termek_ertekeles_felhasznalo' => 'Id Termek Ertekeles Felhasznalo',
            'id_termek' => 'Id Termek Ertekeles',
            'id_felhasznalo' => 'Id Felhasznalo',
            'datum' => 'Datum',
            'ertek' => 'Ertek',
        ];
    }
}
