<?php

namespace app\models;

use app\components\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "markak".
 *
 * @property int $id
 * @property string $markanev
 * @property string $sztorno
 * @property int $alapert_kat alapertelmezett kategoria
 * @property int $top Top Brand
 * @property string $url_segment
 */
class Markak extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'markak';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sztorno', 'url_segment'], 'safe'],
            [['alapert_kat'], 'required'],
            [['alapert_kat', 'top'], 'integer'],
            [['markanev'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'markanev' => 'Markanev',
            'sztorno' => 'Sztorno',
            'alapert_kat' => 'Alapert Kat',
            'top' => 'Top',
        ];
    }
}
