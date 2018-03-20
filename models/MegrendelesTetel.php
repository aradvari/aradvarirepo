<?php

namespace app\models;

use app\components\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "megrendeles_tetel".
 *
 * @property int $id_megrendeles_tetel
 * @property int $id_megrendeles_fej
 * @property int $id_termek
 * @property int $id_marka
 * @property int $id_vonalkod
 * @property string $termek_nev
 * @property int $termek_ar
 * @property double $termek_ar_deviza
 * @property int $afa_kulcs
 * @property int $afa_ertek
 * @property double $afa_ertek_deviza
 * @property string $vonalkod
 * @property int $id_keszlet
 * @property string $tulajdonsag
 * @property string $szin
 * @property string $termek_opcio
 * @property string $vtsz
 * @property string $sztorno
 */
class MegrendelesTetel extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'megrendeles_tetel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_megrendeles_fej', 'id_termek', 'termek_nev', 'termek_ar', 'vonalkod'], 'required'],
            [['id_megrendeles_fej', 'id_termek', 'id_marka', 'id_vonalkod', 'termek_ar', 'afa_kulcs', 'afa_ertek', 'id_keszlet'], 'integer'],
            [['termek_ar_deviza', 'afa_ertek_deviza'], 'number'],
            [['sztorno'], 'safe'],
            [['termek_nev'], 'string', 'max' => 200],
            [['vonalkod', 'tulajdonsag', 'termek_opcio'], 'string', 'max' => 50],
            [['szin'], 'string', 'max' => 100],
            [['vtsz'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_megrendeles_tetel' => 'Id Megrendeles Tetel',
            'id_megrendeles_fej' => 'Id Megrendeles Fej',
            'id_termek' => 'Id Termek',
            'id_marka' => 'Id Marka',
            'id_vonalkod' => 'Id Vonalkod',
            'termek_nev' => 'Termek Nev',
            'termek_ar' => 'Termek Ar',
            'termek_ar_deviza' => 'Termek Ar Deviza',
            'afa_kulcs' => 'Afa Kulcs',
            'afa_ertek' => 'Afa Ertek',
            'afa_ertek_deviza' => 'Afa Ertek Deviza',
            'vonalkod' => 'Vonalkod',
            'id_keszlet' => 'Id Keszlet',
            'tulajdonsag' => 'Tulajdonsag',
            'szin' => 'Szin',
            'termek_opcio' => 'Termek Opcio',
            'vtsz' => 'Vtsz',
            'sztorno' => 'Sztorno',
        ];
    }

    public function getVonalkodok()
    {
        return $this->hasOne(Vonalkodok::className(), ['id_vonalkod' => 'id_vonalkod']);
    }

    public function getTermek()
    {
        return $this->hasOne(Termekek::className(), ['id' => 'id_termek']);
    }


}
