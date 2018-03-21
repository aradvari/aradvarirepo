<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "termek_ertekeles".
 *
 * @property string $id_termek_ertekeles
 * @property integer $id_termek
 * @property integer $ertek1
 * @property integer $ertek2
 * @property integer $ertek3
 * @property integer $ertek4
 * @property integer $ertek5
 */
class TermekErtekeles extends \app\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'termek_ertekeles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_termek', 'ertek1', 'ertek2', 'ertek3', 'ertek4', 'ertek5'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_termek_ertekeles' => 'Id Termek Ertekeles',
            'id_termek' => 'Id Termek',
            'ertek1' => 'Ertek1',
            'ertek2' => 'Ertek2',
            'ertek3' => 'Ertek3',
            'ertek4' => 'Ertek4',
            'ertek5' => 'Ertek5',
        ];
    }

    public function getTermek()
    {
        return $this->hasOne(Termekek::className(), ['id' => 'id_termek']);
    }

}
