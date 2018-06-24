<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Termekek;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * TermekekSearch represents the model behind the search form of `app\models\Termekek`.
 */
class TermekekSearch extends Termekek
{

    public $mainCategory;
    public $subCategory;
    public $brand;

    public $meret;
    public $szin;
    public $tipus;
    public $q;

    public $s = 'leguljabb-elol';

    public static $urls;

    private $likeFilter = "lower(CONCAT(IFNULL(t.termeknev, ''), ' ', IFNULL(t.szin, ''), ' ', IFNULL(t.tipus, ''), ' ', IFNULL(m.markanev, ''), ' ', IFNULL(k.megnevezes, ''), ' ', IFNULL(pk.megnevezes, ''), ' ', IFNULL(v.megnevezes, '')))";

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mainCategory', 'subCategory', 'brand', 'meret', 'szin', 'tipus', 'q', 's'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public static function getSearchQuery()
    {

        $query = new Query();
        $query->from('termekek t')
            ->join('inner join', 'vonalkodok v', 'v.id_termek = t.id AND v.aktiv = 1 AND (v.keszlet_1 > 0 /*OR v.keszlet_2 > 0*/)')
            ->join('left join', 'vonalkod_sorrendek vs', 'vs.vonalkod_megnevezes = v.megnevezes')
            ->join('left join', 'markak m', 'm.id = t.markaid')
            ->join('left join', 'termek_kategoria_kapcs tkk', 'tkk.id_termekek = t.id')
            ->join('left join', 'kategoriak k', 'tkk.id_kategoriak = k.id_kategoriak')
            ->join('left join', 'kategoriak pk', 'pk.id_kategoriak = k.szulo')
            ->andWhere('t.torolve is null')
            ->andWhere('t.aktiv >= 1')
            ->andWhere('k.id_kategoriak is not null');

        return $query;

    }

    public function search($params)
    {
        $sortOrder = [
            'leguljabb-elol' => 'v.id_vonalkod desc',
            'ar-szerint-csokkeno' => '(case when t.akcios_kisker_ar > 0 THEN t.akcios_kisker_ar ELSE t.kisker_ar END) desc',
            'ar-szerint-novekvo' => '(case when t.akcios_kisker_ar > 0 THEN t.akcios_kisker_ar ELSE t.kisker_ar END) asc',
        ];

        $query = static::getSearchQuery()
            ->select([
                't.*',
                'pk.megnevezes main_category_name',
                'pk.url_segment main_category_url_segment',
                'k.megnevezes sub_category_name',
                'k.url_segment sub_category_url_segment',
                'm.markanev markanev',
                'm.url_segment marka_url_segment',
            ])
            ->groupBy(['t.id']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageParam' => 'page',
            ],
        ]);

        $this->setAttributes($params);

        $query->andFilterWhere([
            'pk.url_segment' => $this->mainCategory,
            'k.url_segment' => $this->subCategory,
            'm.url_segment' => $this->brand,
            'v.url_segment' => $this->meret,
            't.szinszuro' => $this->szin,
            't.tipus' => $this->tipus,
        ]);

        $q = (array)explode(" ", $this->q);
        foreach ($q as $text)
            $query->andFilterWhere(['like', $this->likeFilter, mb_strtolower($text)]);

        $query->orderBy($sortOrder[$this->s]);

        return $dataProvider;
    }

    public function searchBrand($params)
    {
        $query = $this->getSearchQuery()
            ->select(['m.*'])
            ->orderBy('m.top')
            ->groupBy(['m.id']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->setAttributes($params);

        $query->andFilterWhere([
            'pk.url_segment' => $this->mainCategory,
            'k.url_segment' => $this->subCategory,
            'v.url_segment' => $this->meret,
            't.szinszuro' => $this->szin,
            't.tipus' => $this->tipus,
        ]);

        $q = (array)explode(" ", $this->q);
        foreach ($q as $text)
            $query->andFilterWhere(['like', $this->likeFilter, mb_strtolower($text)]);

        return $dataProvider;
    }

    public function searchSize($params)
    {
        $query = $this->getSearchQuery()
            ->select(['v.*'])
            ->orderBy('vs.sorrend, v.megnevezes')
            ->groupBy(['v.megnevezes']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->setAttributes($params);

        $query->andFilterWhere([
            'pk.url_segment' => $this->mainCategory,
            'k.url_segment' => $this->subCategory,
            'm.url_segment' => $this->brand,
            't.szinszuro' => $this->szin,
            't.tipus' => $this->tipus,
        ]);

        $query->andFilterWhere(['!=', 'v.megnevezes', '-']);

        $q = (array)explode(" ", $this->q);
        foreach ($q as $text)
            $query->andFilterWhere(['like', $this->likeFilter, mb_strtolower($text)]);

        return $dataProvider;
    }

    public function searchColor($params)
    {

        $query = $this->getSearchQuery()
            ->select(['t.szinszuro'])
            ->orderBy('t.szinszuro')
            ->groupBy(['t.szinszuro']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->setAttributes($params);

        $query->andFilterWhere([
            'pk.url_segment' => $this->mainCategory,
            'k.url_segment' => $this->subCategory,
            'm.url_segment' => $this->brand,
            'v.url_segment' => $this->meret,
            't.tipus' => $this->tipus,
        ]);

        $query->andWhere(['!=', 't.szinszuro', '']);

        $q = (array)explode(" ", $this->q);
        foreach ($q as $text)
            $query->andFilterWhere(['like', $this->likeFilter, mb_strtolower($text)]);

        return $dataProvider;
    }

    public function searchType($params)
    {
        $query = $this->getSearchQuery()
            ->select(['t.tipus'])
            ->orderBy('t.tipus')
            ->groupBy(['t.tipus']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->setAttributes($params);

        $query->andFilterWhere([
            'pk.url_segment' => $this->mainCategory,
            'k.url_segment' => $this->subCategory,
            'm.url_segment' => $this->brand,
            'v.url_segment' => $this->meret,
            't.szinszuro' => $this->szin,
        ]);

        $query->andWhere(['!=', 't.tipus', '']);

        $q = (array)explode(" ", $this->q);
        foreach ($q as $text)
            $query->andFilterWhere(['like', $this->likeFilter, mb_strtolower($text)]);

        return $dataProvider;
    }

    public function searchSubCategory($params)
    {
        $query = $this->getSearchQuery()
            ->select(['k.*', 'pk.url_segment pk_url_segment', 'pk.megnevezes pk_megnevezes'])
            ->groupBy(['k.id_kategoriak'])
            ->orderBy('pk.sorrend, k.sorrend');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->setAttributes($params);

        $query->andFilterWhere([
            'pk.url_segment' => $this->mainCategory,
        ]);

//        $query->andFilterWhere(['like', "CONCAT(t.termeknev, ' ', t.szin, ' ', m.markanev, ' ', k.megnevezes, ' ', pk.megnevezes, ' ', v.megnevezes)", $this->q]);

        return $dataProvider;
    }

    public function searchSubCategoryWithParams($params)
    {
        $query = $this->getSearchQuery()
            ->select(['k.*', 'pk.url_segment pk_url_segment', 'pk.megnevezes pk_megnevezes'])
            ->groupBy(['k.id_kategoriak'])
            ->orderBy('pk.sorrend, k.sorrend');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->setAttributes($params);

        $query->andFilterWhere([
            'pk.url_segment' => $this->mainCategory,
            'm.url_segment' => $this->brand,
            'v.url_segment' => $this->meret,
            't.szinszuro' => $this->szin,
            't.tipus' => $this->tipus,
        ]);

//        $query->andFilterWhere(['like', "CONCAT(t.termeknev, ' ', t.szin, ' ', m.markanev, ' ', k.megnevezes, ' ', pk.megnevezes, ' ', v.megnevezes)", $this->q]);

        return $dataProvider;
    }

    public function searchMainCategory($params)
    {
        $query = $this->getSearchQuery()
            ->select(['pk.*'])
            ->groupBy(['pk.id_kategoriak'])
            ->orderBy('pk.sorrend, k.sorrend');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->setAttributes($params);

//        $query->andFilterWhere(['like', "CONCAT(t.termeknev, ' ', t.szin, ' ', m.markanev, ' ', k.megnevezes, ' ', pk.megnevezes, ' ', v.megnevezes)", $this->q]);

        return $dataProvider;
    }

    public function searchMainCategoryWithParams($params)
    {
        $query = $this->getSearchQuery()
            ->select(['pk.*'])
            ->groupBy(['pk.id_kategoriak'])
            ->orderBy('pk.sorrend, k.sorrend');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->setAttributes($params);

        $query->andFilterWhere([
            'k.url_segment' => $this->subCategory,
            'm.url_segment' => $this->brand,
            'v.url_segment' => $this->meret,
            't.szinszuro' => $this->szin,
            't.tipus' => $this->tipus,
        ]);

//        $query->andFilterWhere(['like', "CONCAT(t.termeknev, ' ', t.szin, ' ', m.markanev, ' ', k.megnevezes, ' ', pk.megnevezes, ' ', v.megnevezes)", $this->q]);

        return $dataProvider;
    }

    public function searchCustom($params)
    {
        $query = static::getSearchQuery()
            ->select(['t.*'])
            ->groupBy(['t.id']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->setAttributes($params);

        $query->andFilterWhere([
            'pk.url_segment' => $this->mainCategory,
            'k.url_segment' => $this->subCategory,
            'm.url_segment' => $this->brand,
            'v.url_segment' => $this->meret,
            't.szinszuro' => $this->szin,
            't.tipus' => $this->tipus,
        ]);

        $q = (array)explode(" ", $this->q);
        foreach ($q as $text)
            $query->andFilterWhere(['like', $this->likeFilter, mb_strtolower($text)]);

        return $dataProvider;
    }

    public static $models = [
        ['searchMainCategoryWithParams', 'mainCategory', 'url_segment'],
        ['searchSubCategoryWithParams', 'subCategory', 'url_segment'],
        ['searchBrand', 'brand', 'url_segment'],
//        ['searchSize', 'meret', 'url_segment'],
        ['searchColor', 'szin', 'szinszuro'],
        ['searchType', 'tipus', 'tipus'],
    ];

    public static $a = 1;

    public static function generateMap($params = [])
    {

        static::$a++;
        if (static::$a > 10) return;
        $searchModel = new TermekekSearch();

        foreach (static::$models as $model) {

            if (!in_array($model[1], array_keys($params))) {

                $dataProvider = $searchModel->{$model[0]}($params);
//                $dataProvider->query->limit(5);
                $items = $dataProvider->getModels();
                $route = [];
                foreach ($items as $item) {

                    if ($item[$model[2]]) {
                        $route = ArrayHelper::merge($params, [$model[1] => $item[$model[2]]]);
                        asort($route);
//                    static::$urls[] = $route;
                        static::$urls[serialize($route)] = Url::to(ArrayHelper::merge(['termekek/index'], $route), true);
                    }
                    static::generateMap($route);

                }

            }

        }

    }

}
