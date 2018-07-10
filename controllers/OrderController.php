<?php

namespace app\controllers;

use app\extensions\cib\CIB;
use app\models\BankTranzakciok;
use app\models\Felhasznalok;
use app\models\FizetesiMod;
use app\models\Helyseg;
use app\models\Kozterulet;
use app\models\LoginForm;
use app\models\MegrendelesFej;
use app\models\MegrendelesTetel;
use app\models\SzallitasiMod;
use Yii;
use app\components\web\Controller;
use yii\db\Expression;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class OrderController extends Controller
{

    public function actionCreate()
    {

        if (!Yii::$app->cart->items)
            return $this->render('/cart/_empty_cart');

        //Bejelentkezés
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//            return $this->refresh();
        }

        if (Yii::$app->user->isGuest)
            $felhasznaloModel = new Felhasznalok();
        else
            $felhasznaloModel = Yii::$app->user->identity;

        $megrendelesModel = new MegrendelesFej();

        if (Yii::$app->request->post()) {

            $transaction = Yii::$app->db->beginTransaction();

            $transError = false;

            if ($felhasznaloModel->load(Yii::$app->request->post()) && $megrendelesModel->load(Yii::$app->request->post())) {

                if (!$megrendelesModel->eltero_szallitasi_adatok){
                    $megrendelesModel->szallitasi_nev = trim($felhasznaloModel->vezeteknev . ' ' . $felhasznaloModel->keresztnev);
                    $megrendelesModel->szallitasi_irszam = $felhasznaloModel->irszam;
                    $megrendelesModel->szallitasi_utcanev = $felhasznaloModel->utcanev;
                    $megrendelesModel->szallitasi_id_kozterulet = $felhasznaloModel->id_kozterulet;
                    $megrendelesModel->szallitasi_hazszam = $felhasznaloModel->hazszam;
                    $megrendelesModel->szallitasi_id_megye = $felhasznaloModel->id_megye;
                    $megrendelesModel->szallitasi_id_varos = $felhasznaloModel->id_varos;
                    $megrendelesModel->szallitasi_varos = $felhasznaloModel->varos_nev;
                }elseif (!$megrendelesModel->szallitasi_nev) {
                    $megrendelesModel->szallitasi_nev = trim($felhasznaloModel->vezeteknev . ' ' . $felhasznaloModel->keresztnev);
                }

                $v1 = $felhasznaloModel->validate();
                $v2 = $megrendelesModel->validate();

                if ($v1 && $v2) {

                    Yii::$app->cart->shippingType = $megrendelesModel->id_szallitasi_mod;

                    //Nem regisztrált user
                    if (!$felhasznaloModel->create_user && Yii::$app->user->isGuest)
                        $felhasznaloModel->auth_type = 'unregistered';

                    if (!$felhasznaloModel->save())
                        $transError = true;

                    //FEJ
                    $megrendelesModel->id_felhasznalo = $felhasznaloModel->getPrimaryKey();
                    $megrendelesModel->fizetendo = Yii::$app->cart->totalAmount;
                    $megrendelesModel->tetel_szam = Yii::$app->cart->getCount();
                    if ($megrendelesModel->id_szallitasi_mod != SzallitasiMod::TYPE_SZEMELYES)
                        $megrendelesModel->szallitasi_dij = Yii::$app->cart->shippingAmount;
                    else
                        $megrendelesModel->szallitasi_dij = 0;
                    $megrendelesModel->kedvezmeny_erteke = Yii::$app->cart->totalDiscountAmount;
                    $megrendelesModel->id_penznem = 0;
                    $megrendelesModel->id_orszag = 1;
                    if (!$megrendelesModel->save())
                        $transError = true;

                    //Tételek
                    foreach (Yii::$app->cart->items as $item) {
                        for ($i = 1; $i <= $item['quantity']; $i++) {
                            $tetelModel = new MegrendelesTetel();
                            $tetelModel->id_megrendeles_fej = $megrendelesModel->getPrimaryKey();
                            $tetelModel->id_termek = $item['item']->termek->id;
                            $tetelModel->id_marka = $item['item']->termek->markaid;
                            $tetelModel->id_vonalkod = $item['item']->id_vonalkod;
                            $tetelModel->termek_nev = $item['item']->termek->termeknev;
                            $tetelModel->termek_ar = $item['item']->termek->vegleges_ar;
                            $tetelModel->afa_kulcs = Yii::$app->params['vat'];
//                            $tetelModel->afa_ertek = round(($item['item']->termek->vegleges_ar * $item['quantity']) * (Yii::$app->params['vat'] / 100));
                            $tetelModel->afa_ertek = round(($item['item']->termek->vegleges_ar) * (Yii::$app->params['vat'] / 100));
                            $tetelModel->vonalkod = $item['item']->vonalkod;
                            $tetelModel->tulajdonsag = $item['item']->megnevezes;
                            $tetelModel->szin = $item['item']->termek->szin;
                            $tetelModel->termek_opcio = $item['item']->termek->opcio;
                            if (!$tetelModel->save())
                                $transError = true;
                        }
                    }

                    //Készlet ellenőrzés
                    foreach (Yii::$app->cart->items as $item) {
                        if ($item['item']->keszlet_1 < $item['quantity']) {
                            Yii::$app->session->addFlash('danger', 'A(z) "' . $item['item']->termek->termeknev . ' (' . $item['item']->megnevezes . ')" termékből az általad vásárolni kívánt ' . $item['quantity'] . ' db-ból már csak ' . $item['item']->keszlet_1 . ' db elérhető.');
                            $transError = true;
                        }
                    }

                    //BANKI FIZETÉS
                    if ($megrendelesModel->id_fizetesi_mod == FizetesiMod::TYPE_BANK) {

                        //cib
                        $cib = new CIB(Yii::$app->language, 'HUF');
                        $cib->setUserId($felhasznaloModel->getPrimaryKey());

                        $trid = mt_rand(1000, 9999) . date("is", mktime()) . mt_rand(1000, 9999) . date("is", mktime());
                        $ts = date('YmdHis');
                        $bankLink = $cib->msg10((int)$megrendelesModel->id_megrendeles_fej, $trid, 'CSH' . str_pad($cib->userId, 8, "0", STR_PAD_LEFT), Yii::$app->cart->totalAmountWithShipping, $ts);

                        if ($bankLink == "") {
                            Yii::$app->session->setFlash('danger', 'A Bankkártyás fizetés kódolásánál hiba lépett fel. A fizetést próbáld meg újra!');
                            $transError = true;
                        }

                        $megrendelesModel->id_statusz = 50;
                        if (!$megrendelesModel->save())
                            $transError = true;

                        if (!$transError)
                            $transaction->commit();

                        return $this->redirect($bankLink);

                    }

                    if (!$transError && !$megrendelesModel->close(true))
                        $transError = true;

                    if (!$transError) {

//                        Yii::$app->session->setFlash('success', 'A megrendelésed sikeres volt, a részletekről e-mailt küldtönk az email címedre.');
                        $transaction->commit();

                        //KOSÁR TÖRLÉSE
                        Yii::$app->cart->delete();

                        //MAIL
                        $megrendelesModel->refresh();
                        Yii::$app->mailer->compose('/mail/order.php', ['model' => $megrendelesModel])
                            ->setTo($megrendelesModel->felhasznalo->email)
                            ->setSubject('Sikeres rendelés - ' . $megrendelesModel->megrendeles_szama)
                            ->send();

                        return $this->redirect(['/order/success', 'id' => $megrendelesModel->getToken()]);

                    } else {

                        //Yii::$app->session->addFlash('danger', 'A vásárlás közben probléma lépett fel, kérünk hogy ismételd meg a megrendelésedet.');
                        $transaction->rollBack();

                    }

                }

            } else {

                //Yii::$app->session->addFlash('danger', 'A vásárlás közben probléma lépett fel, kérünk hogy ismételd meg a megrendelésedet.');
                $transaction->rollBack();

            }

        } else {

            $megrendelesModel->szallitasi_nev = trim($felhasznaloModel->vezeteknev . ' ' . $felhasznaloModel->keresztnev);
            $megrendelesModel->szallitasi_irszam = $felhasznaloModel->irszam;
            $megrendelesModel->szallitasi_utcanev = $felhasznaloModel->utcanev;
            $megrendelesModel->szallitasi_id_kozterulet = $felhasznaloModel->id_kozterulet;
            $megrendelesModel->szallitasi_hazszam = $felhasznaloModel->hazszam;
            $megrendelesModel->szallitasi_id_megye = $felhasznaloModel->id_megye;
            $megrendelesModel->szallitasi_id_varos = $felhasznaloModel->id_varos;
            $megrendelesModel->szallitasi_varos = $felhasznaloModel->varos_nev;
            $megrendelesModel->id_szallitasi_mod = Yii::$app->session->get('shippingType', SzallitasiMod::TYPE_CSOMAGKULDO);
            $megrendelesModel->id_fizetesi_mod = FizetesiMod::TYPE_KESZPENZ;

            if (!$felhasznaloModel->id_kozterulet)
                $felhasznaloModel->id_kozterulet = Kozterulet::NAME_UTCA;

            $felhasznaloModel->create_user = false;
            $felhasznaloModel->contract = true;

        }

        return $this->render('/user/order_data', [
            'model' => $model,
            'felhasznaloModel' => $felhasznaloModel,
            'megrendelesModel' => $megrendelesModel,
        ]);
    }

    public function actionCib($userId)
    {

        $cib = new CIB(Yii::$app->language, 'HUF');
        $cib->userId = $userId;

        $parse = $cib->getData(Yii::$app->request->queryString);

        $transModel = BankTranzakciok::findOne(['id_felhasznalo' => $userId, 'trid' => $parse["TRID"], 'lezarva' => null]);

        if (!$transModel)
            throw new NotFoundHttpException('A megadott tranzakció már lezárt, vagy nem feldolgozható!');

        if ($parse["MSGT"] == "21" && $transModel) {

            $transModel->history = $cib->getHistory($parse["TRID"], $transModel->amo);
            $transModel->save();

            $response = $cib->msg32($parse["TRID"], $transModel->amo);

            $transaction = Yii::$app->db->beginTransaction();
            try {

                if ($response["ANUM"] != "" && $response["RT"] != "" && $response["RC"] == "00") { //SIKERES TRANZAKCIÓ

                    $transModel->rc = $response["RC"];
                    $transModel->rt = iconv("ISO-8859-2", "UTF-8", $response["RT"]);
                    $transModel->anum = $response["ANUM"];
                    $transModel->lezarva = new Expression('NOW()');
                    $transModel->save();

                    $megrendelesModel = $transModel->megrendelesFej;
                    $megrendelesModel->id_statusz = 1;
                    $megrendelesModel->save();

                    //KÉSZLET KEZELÉS
                    $megrendelesModel->close();

                    $transaction->commit();

                    //KOSÁR TÖRLÉSE
                    Yii::$app->cart->delete();

                    //MAIL
                    $megrendelesModel->refresh();
                    Yii::$app->mailer->compose('/mail/order.php', ['model' => $megrendelesModel])
                        ->setTo($megrendelesModel->felhasznalo->email)
                        ->setSubject('Sikeres rendelés - ' . $megrendelesModel->megrendeles_szama)
                        ->send();


                } else { //SIKERTELEN TRANZAKCIÓ

                    $transModel->rc = $response["RC"];
                    $transModel->rt = iconv("ISO-8859-2", "UTF-8", $response["RT"]);
                    $transModel->lezarva = new Expression('NOW()');
                    $transModel->save();

                    $megrendelesModel = $transModel->megrendelesFej;
                    $megrendelesModel->id_statusz = 99;
                    $megrendelesModel->save();

                }

            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }

        } elseif ($parse["TRID"] == "") {

            return $this->goHome();

        }

        if ($transModel->rc == "00") {
            return $this->redirect(['/order/success', 'id' => $transModel->megrendelesFej->getToken()]);
        } elseif ($transModel->rc != "00") {
            Yii::$app->session->addFlash('danger', $this->renderPartial('cib_error', ['model' => $transModel]));
            return $this->redirect(['/order/create']);
        }

    }

    public function actionCibcron()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $response = [];

        $cib = new CIB(Yii::$app->language, 'HUF');

        $transModel = BankTranzakciok::find()->andWhere(['lezarva' => null])->andWhere('DATE_ADD(datum, INTERVAL 15 MINUTE) < NOW()')->all();

        $transaction = Yii::$app->db->beginTransaction();
        try {

            foreach ($transModel as $model) {

                $cib->setUserId($model->id_felhasznalo);
                $msg = $cib->msg32($model->trid, $model->amo);

                $model->rc = $msg["RC"];
                $model->rt = iconv("ISO-8859-2", "UTF-8", $msg["RT"]);
                $model->anum = $msg["ANUM"];
                $model->lezarva = new Expression('NOW()');
                $model->save(false);

                $res = $cib->msg33($model->trid, $model->amo);

                $megrendelesModel = MegrendelesFej::findOne($model->id_megrendeles_fej);
                $megrendelesModel->close();

                $response[] = [
                    'transModel' => $model->attributes,
                    'megrendelesModel' => $megrendelesModel->attributes,
                    'msg32' => iconv('UTF-8', 'UTF-8', $msg),
                    'msg33' => iconv('UTF-8', 'UTF-8', $res),
                ];

            }

        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $response;

    }

    public function actionAjaxGetCity()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $irsz = Yii::$app->request->post('irsz');
        $megye = Yii::$app->request->post('megye');

        if ($irsz) {
            if (substr($irsz, 0, 1) == '1')
                $irsz = '1011';

//            $selected = Helyseg::findOne(['IRANYITOSZAM' => $irsz]);
            $items = Helyseg::findAll(['IRANYITOSZAM' => $irsz]);

            return [
//                'selected' => $selected,
                'items' => $items,
                'itemsCount' => count($items),
            ];
        }

        if ($megye) {

            $items = Helyseg::findAll(['ID_MEGYE' => $megye]);

            return [
                'selected' => $megye,
                'items' => $items,
                'itemsCount' => count($items),
            ];

        }

    }

    public function actionSetShippingType($shippingType)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        Yii::$app->session->set('shippingType', $shippingType);

        return true;

    }

    public function actionSuccess($id)
    {
        $model = MegrendelesFej::findByToken($id);
        return $this->render('order_success', [
            'model' => $model,
        ]);
    }

    public function actionMyOrders()
    {
        return $this->render('my_orders');
    }

    public function actionAjaxGetOrder()
    {
        $model = MegrendelesFej::findByToken(Yii::$app->request->getBodyParam('id'));
        return $this->renderAjax('_order_data', [
            'model' => $model,
        ]);
    }


}
