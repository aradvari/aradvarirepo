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
            [['gls_adatok'], 'string', 'max' => 1000],
            [['szallitasi_kozterulet', 'szamlazasi_kozterulet'], 'string', 'max' => 30],
            [['szallitasi_hazszam', 'szallitasi_emelet', 'szamlazasi_hazszam'], 'string', 'max' => 20],
            [['id_szallitasi_mod', 'id_fizetesi_mod'], 'required'],

            [['szallitasi_nev', 'szallitasi_irszam', 'szallitasi_utcanev', 'szallitasi_varos'], 'required', 'when' => function ($model) {
                return $model->eltero_szallitasi_adatok;
            }, 'whenClient' => "function (attribute, value) {
                    return $('#megrendelesfej-eltero_szallitasi_adatok').is(':checked');
            }"],

            [['id_szallitasi_mod'], function ($attribute_name, $params) {
                if ($this->gls_kod || $this->id_szallitasi_mod != SzallitasiMod::TYPE_GLS)
                    return true;

                $this->addError($attribute_name, 'GLS csomagpont címének kiválasztása kötelező');
                return false;
            }],


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
            'szallitasi_id_varos' => 'Város',
            'szallitasi_irszam' => 'Irányítószám',
            'szallitasi_varos' => 'Város',
            'szallitasi_utcanev' => 'Cím',
            'szallitasi_kozterulet' => 'Közterület',
            'szallitasi_hazszam' => 'Házszám',
            'szallitasi_emelet' => 'Emelet',
            'szamlazasi_nev' => 'Név',
            'szamlazasi_irszam' => 'Irányítószám',
            'szamlazasi_varos' => 'Város',
            'szamlazasi_utcanev' => 'Cím',
            'szamlazasi_kozterulet' => 'Közterület',
            'szamlazasi_hazszam' => 'Házszám',
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

        if ($felhasznaloModel->cegnev)
            $this->szamlazasi_nev = $felhasznaloModel->cegnev;
        else
            $this->szamlazasi_nev = $felhasznaloModel->vezeteknev . ' ' . $felhasznaloModel->keresztnev;

        $this->szamlazasi_irszam = $felhasznaloModel->irszam;
        $this->szamlazasi_utcanev = $felhasznaloModel->utcanev;
        $this->szamlazasi_id_kozterulet = $felhasznaloModel->id_kozterulet;
        $this->szamlazasi_kozterulet = $felhasznaloModel->kozterulet_nev;
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

    public function getStatusz()
    {
        return $this->hasOne(MegrendelesStatuszok::className(), ['id_megrendeles_statusz' => 'id_statusz']);
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

    public function close($transaction = false)
    {

        $newTransaction = false;
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

                //Google, Facebook követés
                $anaconvitems[] = [
                    'glumiId' => $tetel->id_termek . '-' . $tetel->vonalkod,
                    'SKU' => $tetel->vonalkod,
                    'productname' => $tetel->marka->markanev . ' ' . $tetel->termek_nev,
                    'itemprice' => (int)$tetel->termek_ar,
                    'itemqty' => 1,
                ];

            }

            //Google, Facebook követések
            $anaconvgeneral = array();
            $anaconvgeneral['invoice'] = $this->megrendeles_szama;
            $anaconvgeneral['totalnovat'] = (int)$this->fizetendo;
            $anaconvgeneral['shipping'] = 0;
            $anaconvgeneral['totalvat'] = 0;
            Yii::$app->session->set('anaconvgeneral', $anaconvgeneral);
            Yii::$app->session->set('anaconvitems', $anaconvitems);
            Yii::$app->session->set('google_fizetendo', (int)$this->fizetendo);

        } catch (\Exception $e) {
            if ($newTransaction)
                $newTransaction->rollBack();
            return false;
        }

        if ($newTransaction)
            $newTransaction->commit();
        return true;

    }

}
