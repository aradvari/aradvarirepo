<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bank_tranzakciok".
 *
 * @property integer $id_bank_tranzakcio
 * @property integer $id_megrendeles_fej
 * @property integer $id_giftcard
 * @property integer $id_felhasznalo
 * @property string $datum
 * @property string $ip_cim
 * @property string $trid
 * @property string $uid
 * @property double $amo
 * @property string $cur
 * @property string $ts
 * @property string $rc
 * @property string $rt
 * @property string $anum
 * @property string $history
 * @property string $lezarva
 */
class BankTranzakciok extends \app\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bank_tranzakciok';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_megrendeles_fej', 'id_giftcard', 'id_felhasznalo', 'trid', 'ts'], 'integer'],
            [['id_felhasznalo', 'datum', 'ip_cim', 'trid', 'uid', 'amo', 'cur', 'ts'], 'required'],
            [['datum', 'lezarva'], 'safe'],
            [['amo'], 'number'],
            [['ip_cim'], 'string', 'max' => 15],
            [['uid'], 'string', 'max' => 11],
            [['cur'], 'string', 'max' => 3],
            [['rc'], 'string', 'max' => 2],
            [['rt', 'history'], 'string', 'max' => 255],
            [['anum'], 'string', 'max' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_bank_tranzakcio' => 'Id Bank Tranzakcio',
            'id_megrendeles_fej' => 'Id Megrendeles Fej',
            'id_giftcard' => 'Id Giftcard',
            'id_felhasznalo' => 'Id Felhasznalo',
            'datum' => 'Datum',
            'ip_cim' => 'Ip Cim',
            'trid' => 'Trid',
            'uid' => 'Uid',
            'amo' => 'Amo',
            'cur' => 'Cur',
            'ts' => 'Ts',
            'rc' => 'Rc',
            'rt' => 'Rt',
            'anum' => 'Anum',
            'history' => 'History',
            'lezarva' => 'Lezarva',
        ];
    }

    public function getMegrendelesFej()
    {
        return $this->hasOne(MegrendelesFej::className(), ['id_megrendeles_fej' => 'id_megrendeles_fej']);
    }


}
