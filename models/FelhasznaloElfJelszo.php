<?php

namespace app\models;

use app\components\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "felhasznalo_elf_jelszo".
 *
 * @property int $id_felhasznalo_elf_jelszo
 * @property int $id_felhasznalo
 * @property string $aktiv_kod
 * @property string $uj_jelszo
 * @property string $sztorno
 */
class FelhasznaloElfJelszo extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'felhasznalo_elf_jelszo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_felhasznalo', 'aktiv_kod', 'uj_jelszo'], 'required'],
            [['id_felhasznalo'], 'integer'],
            [['sztorno'], 'safe'],
            [['aktiv_kod'], 'string', 'max' => 200],
            [['uj_jelszo'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_felhasznalo_elf_jelszo' => 'Id Felhasznalo Elf Jelszo',
            'id_felhasznalo' => 'Id Felhasznalo',
            'aktiv_kod' => 'Aktiv Kod',
            'uj_jelszo' => 'Uj Jelszo',
            'sztorno' => 'Sztorno',
        ];
    }
}
