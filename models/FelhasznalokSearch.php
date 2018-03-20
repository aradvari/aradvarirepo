<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Felhasznalok;

/**
 * FelhasznalokSearch represents the model behind the search form of `app\models\Felhasznalok`.
 */
class FelhasznalokSearch extends Felhasznalok
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_orszag', 'id_megye', 'id_varos', 'id_kozterulet', 'szuletesi_ev', 'szuletesi_honap', 'szuletesi_nap', 'hirlevel', 'klubtag_kod', 'kartya_kod', 'modositva', 'modositva2', 'modositva3'], 'integer'],
            [['vezeteknev', 'keresztnev', 'cegnev', 'orszag_nev', 'irszam', 'megye_nev', 'varos_nev', 'utcanev', 'kozterulet_nev', 'hazszam', 'emelet', 'email', 'telefonszam1', 'telefonszam2', 'jelszo', 'aktivacios_kod', 'regisztralva', 'utolso_belepes', 'session_id', 'torolve'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Felhasznalok::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_orszag' => $this->id_orszag,
            'id_megye' => $this->id_megye,
            'id_varos' => $this->id_varos,
            'id_kozterulet' => $this->id_kozterulet,
            'szuletesi_ev' => $this->szuletesi_ev,
            'szuletesi_honap' => $this->szuletesi_honap,
            'szuletesi_nap' => $this->szuletesi_nap,
            'hirlevel' => $this->hirlevel,
            'klubtag_kod' => $this->klubtag_kod,
            'kartya_kod' => $this->kartya_kod,
            'regisztralva' => $this->regisztralva,
            'utolso_belepes' => $this->utolso_belepes,
            'modositva' => $this->modositva,
            'modositva2' => $this->modositva2,
            'modositva3' => $this->modositva3,
            'torolve' => $this->torolve,
        ]);

        $query->andFilterWhere(['like', 'vezeteknev', $this->vezeteknev])
            ->andFilterWhere(['like', 'keresztnev', $this->keresztnev])
            ->andFilterWhere(['like', 'cegnev', $this->cegnev])
            ->andFilterWhere(['like', 'orszag_nev', $this->orszag_nev])
            ->andFilterWhere(['like', 'irszam', $this->irszam])
            ->andFilterWhere(['like', 'megye_nev', $this->megye_nev])
            ->andFilterWhere(['like', 'varos_nev', $this->varos_nev])
            ->andFilterWhere(['like', 'utcanev', $this->utcanev])
            ->andFilterWhere(['like', 'kozterulet_nev', $this->kozterulet_nev])
            ->andFilterWhere(['like', 'hazszam', $this->hazszam])
            ->andFilterWhere(['like', 'emelet', $this->emelet])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'telefonszam1', $this->telefonszam1])
            ->andFilterWhere(['like', 'telefonszam2', $this->telefonszam2])
            ->andFilterWhere(['like', 'jelszo', $this->jelszo])
            ->andFilterWhere(['like', 'aktivacios_kod', $this->aktivacios_kod])
            ->andFilterWhere(['like', 'session_id', $this->session_id]);

        return $dataProvider;
    }
}
