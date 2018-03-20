<?php

namespace app\models;

use app\components\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "helyseg".
 *
 * @property string $ID_HELYSEG
 * @property string $HELYSEG_NEV
 * @property string $HELYSEG_KOD
 * @property string $IRANYITOSZAM
 * @property string $ID_MEGYE
 * @property string $ID_REGIO
 * @property string $ID_KISTERSEG
 * @property string $V_KORZET
 * @property string $KSH_KOD
 * @property string $STORNO
 */
class Helyseg extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'helyseg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_HELYSEG'], 'required'],
            [['ID_HELYSEG', 'ID_MEGYE', 'ID_REGIO', 'ID_KISTERSEG'], 'number'],
            [['STORNO'], 'safe'],
            [['HELYSEG_NEV'], 'string', 'max' => 50],
            [['HELYSEG_KOD', 'IRANYITOSZAM', 'KSH_KOD'], 'string', 'max' => 5],
            [['V_KORZET'], 'string', 'max' => 3],
            [['ID_HELYSEG'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_HELYSEG' => 'Id  Helyseg',
            'HELYSEG_NEV' => 'Helyseg  Nev',
            'HELYSEG_KOD' => 'Helyseg  Kod',
            'IRANYITOSZAM' => 'Iranyitoszam',
            'ID_MEGYE' => 'Id  Megye',
            'ID_REGIO' => 'Id  Regio',
            'ID_KISTERSEG' => 'Id  Kisterseg',
            'V_KORZET' => 'V  Korzet',
            'KSH_KOD' => 'Ksh  Kod',
            'STORNO' => 'Storno',
        ];
    }
}
