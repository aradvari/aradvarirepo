<?php

namespace app\models;

use app\components\db\ActiveRecord;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii2mod\query\ArrayQuery;

/**
 * This is the model class for table "kategoriak".
 *
 * @property int $id_kategoriak
 * @property string $megnevezes
 * @property string $nyelvi_kulcs
 * @property int $szulo
 * @property int $publikus
 * @property int $sorrend
 * @property string $sztorno
 * @property string $url_segment
 */
class Kategoriak extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kategoriak';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['szulo', 'publikus', 'sorrend'], 'integer'],
            [['sztorno', 'url_segment'], 'safe'],
            [['megnevezes', 'nyelvi_kulcs'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_kategoriak' => 'Id Kategoriak',
            'megnevezes' => 'Megnevezes',
            'nyelvi_kulcs' => 'Nyelvi Kulcs',
            'szulo' => 'Szulo',
            'publikus' => 'Publikus',
            'sorrend' => 'Sorrend',
            'sztorno' => 'Sztorno',
        ];
    }

//    public static function findAllByParentSegment($segment)
//    {
//
//        $query = new Query();
//        $query->select('k.*')
//            ->from('kategoriak k')
//            ->leftJoin('kategoriak pk', 'k.szulo = pk.id_kategoriak AND pk.sztorno IS NULL')
//            ->andWhere(['pk.url_segment' => $segment])
//            ->andWhere(['k.sztorno' => null])
//            ->orderBy('k.sorrend');
//
//        return $query->all();
//
//    }

    public static function findAllMainCategory()
    {

        return Kategoriak::find()->andWhere(['szulo' => 0, 'sztorno' => null])->all();

    }

    public static function findAllSubCategory()
    {

        return Kategoriak::find()->andWhere(['>', 'szulo', 0])->andWhere(['sztorno' => null])->all();

    }

    public static function findAllActiveCategory()
    {

        $query = TermekekSearch::getSearchQuery();
        $query->select('k.id_kategoriak alkatagoria_id, k.megnevezes alkategoria_megnevezes, k.url_segment alkategoria_url_segment, pk.id_kategoriak fokatagoria_id, pk.megnevezes fokategoria_megnevezes, pk.url_segment fokategoria_url_segment')
            ->andWhere('k.id_kategoriak IS NOT NULL')
            ->groupBy('k.id_kategoriak');

        $results = $query->all();

        $kategoriak = [];
        foreach ($results as $item) {


//            $query = new ArrayQuery();
//            $query->from($results);
//            $query->where(['kategoria' => $fokategoria]);
//
            $kategoriak[$item['fokategoria_id']] = [
                'data' => $fokategoria,
                'items' => $query->all(),
            ];

        }

        return $kategoriak;

    }

    public function getParentCategory()
    {
        return $this->hasOne(Kategoriak::className(), ['id_kategoriak' => 'szulo'])->alias('parent_kategoriak');
    }


}
