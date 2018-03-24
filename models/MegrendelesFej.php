<?php

namespace app\models;

use app\components\db\ActiveRecord;
use Yii;
use yii\BaseYii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "megrendeles_fej".
 *
 * @property int $id_megrendeles_fej
 * @property string $megrendeles_szama
 * @property int $id_felhasznalo
 * @property string $szallitasi_nev
 * @property string $szallitasi_irszam
 * @property string $szallitasi_varos
 * @property string $szallitasi_utcanev
 * @property string $szallitasi_kozterulet
 * @property string $szallitasi_hazszam
 * @property string $szallitasi_emelet
 * @property string $szamlazasi_nev
 * @property string $szamlazasi_irszam
 * @property string $szamlazasi_varos
 * @property string $szamlazasi_utcanev
 * @property string $szamlazasi_kozterulet
 * @property string $szamlazasi_hazszam
 * @property int $fizetendo
 * @property int $tetel_szam
 * @property int $szallitasi_dij
 * @property int $id_fizetesi_mod
 * @property int $id_szallitasi_mod
 * @property int $id_kedvezmeny
 * @property int $kedvezmeny_erteke
 * @property int $kedvezmeny_tipusa 1:%, 2:FIX ÖSSZEG
 * @property int $klubkartya
 * @property int $id_giftcard
 * @property int $giftcard_osszeg
 * @property int $id_orszag
 * @property double $fizetendo_deviza
 * @property double $szallitasi_dij_deviza
 * @property double $kedvezmeny_erteke_deviza
 * @property double $giftcard_osszeg_deviza
 * @property double $deviza_arfolyam
 * @property int $id_penznem
 * @property string $megjegyzes
 * @property string $datum
 * @property int $id_statusz
 * @property string $sztorno
 */
class MegrendelesFej extends ActiveRecord
{

    public $szamlazasi_id_varos;
    public $szamlazasi_id_megye;
    public $szamlazasi_id_kozterulet;

    public $szallitasi_id_varos;
    public $szallitasi_id_megye;
    public $szallitasi_id_kozterulet;

    public $gls;
    public $eltero_szallitasi_adatok = false;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'megrendeles_fej';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['szamlazasi_id_megye', 'szamlazasi_id_varos', 'szamlazasi_id_megye', 'szamlazasi_id_kozterulet'], 'integer'],
            [['szallitasi_id_megye', 'szallitasi_id_varos', 'szallitasi_id_megye', 'szallitasi_id_kozterulet'], 'integer'],
            [['id_felhasznalo', 'fizetendo', 'tetel_szam', 'szallitasi_dij', 'id_fizetesi_mod', 'id_szallitasi_mod', 'id_kedvezmeny', 'kedvezmeny_erteke', 'kedvezmeny_tipusa', 'klubkartya', 'id_giftcard', 'giftcard_osszeg', 'id_orszag', 'id_penznem', 'id_statusz'], 'integer'],
            [['fizetendo_deviza', 'szallitasi_dij_deviza', 'kedvezmeny_erteke_deviza', 'giftcard_osszeg_deviza', 'deviza_arfolyam'], 'number'],
            [['megjegyzes'], 'string'],
            [['datum', 'sztorno', 'gls', 'eltero_szallitasi_adatok'], 'safe'],
            [['megrendeles_szama'], 'string', 'max' => 13],
            [['szallitasi_nev', 'szallitasi_utcanev', 'szamlazasi_nev', 'szamlazasi_utcanev'], 'string', 'max' => 100],
            [['szallitasi_irszam', 'szamlazasi_irszam'], 'string', 'max' => 14],
            [['szallitasi_varos', 'szamlazasi_varos', 'gls_kod'], 'string', 'max' => 50],
            [['szallitasi_kozterulet', 'szamlazasi_kozterulet'], 'string', 'max' => 30],
            [['szallitasi_hazszam', 'szallitasi_emelet', 'szamlazasi_hazszam'], 'string', 'max' => 20],
            [['id_szallitasi_mod', 'id_fizetesi_mod'], 'required'],

            [['szallitasi_nev', 'szallitasi_irszam', 'szallitasi_utcanev', 'szallitasi_varos'], 'required', 'when' => function ($model) {
                return $model->eltero_szallitasi_adatok;
            }, 'whenClient' => "function (attribute, value) {
                    return $('#megrendelesfej-eltero_szallitasi_adatok').is(':checked');
            }"],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_megrendeles_fej' => 'Id Megrendeles Fej',
            'megrendeles_szama' => 'Megrendelés száma',
            'id_felhasznalo' => 'Megrendelő azonosítója',
            'szallitasi_nev' => 'Szállítási név',
            'szallitasi_id_varos' => 'Szállítási város',
            'szallitasi_irszam' => 'Szállítási irányítószám',
            'szallitasi_varos' => 'Szállítási város',
            'szallitasi_utcanev' => 'Szállítási cím',
            'szallitasi_kozterulet' => 'Szállítási közterül',
            'szallitasi_hazszam' => 'Szállítási házszám',
            'szallitasi_emelet' => 'Szállítási emelet',
            'szamlazasi_nev' => 'Számlázási név',
            'szamlazasi_irszam' => 'Számlázási irányítószám',
            'szamlazasi_varos' => 'Számlázási város',
            'szamlazasi_utcanev' => 'Számlázási cím',
            'szamlazasi_kozterulet' => 'Számlázási közterület',
            'szamlazasi_hazszam' => 'Számlázási házszám',
            'fizetendo' => 'Fizetendő',
            'tetel_szam' => 'Darabszám',
            'szallitasi_dij' => 'Szállítási díj',
            'id_fizetesi_mod' => 'Fizetési mód',
            'id_szallitasi_mod' => 'Szállítási mód',
            'id_kedvezmeny' => 'Kedvezmény',
            'kedvezmeny_erteke' => 'Kedvezmény értéke',
            'kedvezmeny_tipusa' => 'Kedvezmény típusa',
            'klubkartya' => 'Kubkártya száma',
            'id_giftcard' => 'Ajándékkártya',
            'giftcard_osszeg' => 'Ajándékkártya összege',
            'id_orszag' => 'Ország',
            'fizetendo_deviza' => 'Fizetendo Deviza',
            'szallitasi_dij_deviza' => 'Szallitasi Dij Deviza',
            'kedvezmeny_erteke_deviza' => 'Kedvezmeny Erteke Deviza',
            'giftcard_osszeg_deviza' => 'Giftcard Osszeg Deviza',
            'deviza_arfolyam' => 'Deviza Arfolyam',
            'id_penznem' => 'Pénznem',
            'megjegyzes' => 'Megjegyzés',
            'datum' => 'Dátum',
            'id_statusz' => 'Státusz',
            'sztorno' => 'Törlés dátuma',
            'gls_kod' => 'GLS szállítási azonosító',
            'eltero_szallitasi_adatok' => 'Eltérő szállítási adatok',
        ];
    }

    public function afterFind()
    {
        return parent::afterFind();
    }

    public function beforeValidate()
    {
        if ($this->szamlazasi_id_varos)
            $this->szamlazasi_varos = Helyseg::findOne($this->szamlazasi_id_varos)->HELYSEG_NEV;
        if ($this->szamlazasi_id_kozterulet)
            $this->szamlazasi_kozterulet = Kozterulet::findOne($this->szamlazasi_id_kozterulet)->megnevezes;

        if ($this->szallitasi_id_varos)
            $this->szallitasi_varos = Helyseg::findOne($this->szallitasi_id_varos)->HELYSEG_NEV;
        if ($this->szallitasi_id_kozterulet)
            $this->szallitasi_kozterulet = Kozterulet::findOne($this->szallitasi_id_kozterulet)->megnevezes;

        //Számlázási adatok
        $felhasznaloModel = $this->felhasznalo;
        $this->szamlazasi_nev = $felhasznaloModel->vezeteknev . ' ' . $felhasznaloModel->keresztnev;
        $this->szamlazasi_irszam = $felhasznaloModel->irszam;
        $this->szamlazasi_utcanev = $felhasznaloModel->utcanev;
        $this->szamlazasi_id_kozterulet = $felhasznaloModel->id_kozterulet;
        $this->szamlazasi_hazszam = $felhasznaloModel->hazszam;
        $this->szamlazasi_id_megye = $felhasznaloModel->id_megye;
        $this->szamlazasi_id_varos = $felhasznaloModel->id_varos;
        $this->szamlazasi_varos = $felhasznaloModel->varos_nev;

        return parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
        $this->datum = new Expression('NOW()');

        //Ha nincs szállítási cím megadva, másoljuk a számlázásit
        if (!$this->szallitasi_nev)
            $this->szallitasi_nev = $this->szamlazasi_nev;

        if (!$this->szallitasi_irszam && !$this->szallitasi_utcanev && !$this->szallitasi_id_kozterulet &&
            !$this->szallitasi_hazszam && !$this->szallitasi_id_megye && !$this->szallitasi_id_varos &&
            !$this->szallitasi_varos) {
            $this->szallitasi_irszam = $this->szamlazasi_irszam;
            $this->szallitasi_utcanev = $this->szamlazasi_utcanev;
            $this->szallitasi_id_kozterulet = $this->szamlazasi_id_kozterulet;
            $this->szallitasi_hazszam = $this->szamlazasi_hazszam;
            $this->szallitasi_id_megye = $this->szamlazasi_id_megye;
            $this->szallitasi_id_varos = $this->szamlazasi_id_varos;
            $this->szallitasi_varos = $this->szamlazasi_varos;
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }


    public function afterSave($insert, $changedAttributes)
    {
        if (!$this->megrendeles_szama) {
            $this->megrendeles_szama = date("Y") . "/" . str_pad($this->id_megrendeles_fej, 8, "0", STR_PAD_LEFT);
            $this->save(true, ['megrendeles_szama']);
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    public function getFelhasznalo()
    {
        return $this->hasOne(Felhasznalok::className(), ['id' => 'id_felhasznalo']);
    }

    public function getTetelek()
    {
        return $this->hasMany(MegrendelesTetel::className(), ['id_megrendeles_fej' => 'id_megrendeles_fej']);
    }

    public function getBankTranzakcio()
    {
        return $this->hasOne(BankTranzakciok::className(), ['id_megrendeles_fej' => 'id_megrendeles_fej']);
    }

    public function getSzallitasiMod()
    {
        return $this->hasOne(SzallitasiMod::className(), ['id_szallitasi_mod' => 'id_szallitasi_mod']);
    }

    public function getFizetesiMod()
    {
        return $this->hasOne(FizetesiMod::className(), ['id_fizetesi_mod' => 'id_fizetesi_mod']);
    }

    public function getToken()
    {

        return md5($this->id_megrendeles_fej . $this->megrendeles_szama . $this->id_felhasznalo);

    }

    public static function findByToken($token)
    {

        $model = MegrendelesFej::find()
            ->andWhere(['md5(concat(id_megrendeles_fej,megrendeles_szama,id_felhasznalo))' => $token])
            ->one();

        return $model;

    }

    public function close()
    {

        $transaction = Yii::$app->db->transaction;
        if (!$transaction)
            $newTransaction = Yii::$app->db->beginTransaction();

        try {

            foreach ($this->tetelek as $tetel) {

                $keszletModel = $tetel->vonalkodok->keszlet1;
                if (!$keszletModel) {
                    Yii::$app->session->addFlash('danger', 'A(z) "' . $tetel->termek_nev . ' (' . $tetel->tulajdonsag . ')" termékből nincs elegendő készlet. Elérhető mennyiség ' . count($tetel->vonalkodok->keszletek1) . ' db.');

                    if ($newTransaction)
                        $newTransaction->rollBack();
                    return false;
                }

                //Készletek frissítése
                $keszletModel->fogy_ar = $tetel->termek_ar;
                $keszletModel->kikerulesi_ar = $tetel->termek_ar;
                $keszletModel->kikerulesi_datum = new Expression('NOW()');
                $keszletModel->id_felhasznalok = $this->id_felhasznalo;
                $keszletModel->save();

                //Megrendelés tétel frissítése
                $tetel->id_keszlet = $keszletModel->getPrimaryKey();
                $tetel->save();

                //Forgalom mentése
                $forgalomModel = new Forgalom();
                $forgalomModel->id_raktar = 1;
                $forgalomModel->id_vonalkod = $tetel->vonalkod;
                $forgalomModel->id_keszlet = $keszletModel->getPrimaryKey();
                $forgalomModel->lista_ar = $tetel->termek->kisker_ar;
                $forgalomModel->fogy_ar = $tetel->termek_ar;
                $forgalomModel->statusz = 0;
                $forgalomModel->datum = new Expression('NOW()');
                $forgalomModel->save();

                //Vonalkod készlet frissítése
                $vonalkodModel = $tetel->vonalkodok;
                $vonalkodModel->keszlet_1 = $vonalkodModel->keszlet_1 - 1;
                $vonalkodModel->save();

                //Termék készlet frissítése
                $termekModel = $tetel->termek;
                $termekModel->keszleten = $termekModel->keszleten - 1;
                $termekModel->save();

            }

            if ($newTransaction)
                $newTransaction->commit();

            return true;

        } catch (\Exception $e) {
            if ($newTransaction)
                $newTransaction->rollBack();
            return false;
        }

    }

}
