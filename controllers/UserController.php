<?php

namespace app\controllers;

use Yii;
use app\models\Felhasznalok;
use app\components\web\Controller;
use yii\db\Expression;

/**
 * FehasznalokController implements the CRUD actions for Felhasznalok model.
 */
class UserController extends Controller
{

    public function actionIndex()
    {

        return $this->render('/user/index', []);
    }

    public function actionCreate()
    {

        $felhasznaloModel = new Felhasznalok();
        $felhasznaloModel->scenario = Felhasznalok::SCENARIO_REGISTER;
        if ($felhasznaloModel->load(Yii::$app->request->post())) {
            if ($felhasznaloModel->save()) {

                if (Yii::$app->user->login(Felhasznalok::findOne(['email' => $felhasznaloModel->email]))) {

                    $this->goHome();

                }

            }

        }

        return $this->render('/user/full_reg', [
            'felhasznaloModel' => $felhasznaloModel,
        ]);
    }

    public function actionModify()
    {

        $felhasznaloModel = Felhasznalok::findIdentity(Yii::$app->user->id);
        $felhasznaloModel->scenario = Felhasznalok::SCENARIO_MODIFY;
        if ($felhasznaloModel->load(Yii::$app->request->post())) {
            if ($felhasznaloModel->save()) {
                \Yii::$app->session->addFlash('success', 'Az adatok mentése sikeres volt.');
            }

        }

        return $this->render('/user/modify', [
            'felhasznaloModel' => $felhasznaloModel,
        ]);
    }

    public function actionPassword()
    {

        $felhasznaloModel = Felhasznalok::findIdentity(Yii::$app->user->id);
        $felhasznaloModel->jelszo = '';
        $felhasznaloModel->scenario = Felhasznalok::SCENARIO_PW;
        if ($felhasznaloModel->load(Yii::$app->request->post())) {
            if ($felhasznaloModel->save()) {
                \Yii::$app->session->addFlash('success', 'A jelszó módosítása sikeres volt.');
                return $this->refresh();
            }

        }

        return $this->render('/user/password', [
            'felhasznaloModel' => $felhasznaloModel,
        ]);
    }

    public function actionDelete()
    {

        $felhasznaloModel = Felhasznalok::findIdentity(Yii::$app->user->id);
        $felhasznaloModel->scenario = Felhasznalok::SCENARIO_DELETE;

        if ($felhasznaloModel->load(Yii::$app->request->post())){

            $felhasznaloModel->torolve = new Expression('NOW()');

            if ($felhasznaloModel->save()) {

                Yii::$app->session->addFlash('success', 'A felhasználói fiókod véglegesen törlésre került.');
                Yii::$app->user->logout();
                return $this->goHome();

            }

        }

        return $this->render('/user/delete', [
            'felhasznaloModel' => $felhasznaloModel,
        ]);
    }

    public function actionUnsubscribe($email = null)
    {

        $model = new Felhasznalok();

        if (Yii::$app->request->post()) {

            $model->scenario = Felhasznalok::SCENARIO_SUBSCRIBE;
            if ($model->load(Yii::$app->request->post())) {
                $model = Felhasznalok::findOne(['email' => $model->email]);

                if (!$model) {
                    $model = new Felhasznalok();
                } else {
                    $model->hirlevel = 0;
                    $model->save(false);

                    Yii::$app->mailer->compose('/mail/unsubscribe.php', ['model' => $model])
                        ->setTo($model->email)
                        ->setSubject('Sikeres leiratkozás hírlevélről')
                        ->send();

                }

                Yii::$app->session->addFlash('success', 'Leiratkozási kérelmed sikeres volt, a tényleges leiratkozásról e-mail üzenetet küldünk részedre!');

            }

        } elseif ($email) {
            $model = Felhasznalok::find()->andWhere(['email' => $email])->andWhere(['!=', 'auth_type', 'unregistered'])->one();
            if (!$model) {
                $model = new Felhasznalok();
                $model->email = $email;
            }
        }

        return $this->render('/user/unsubscribe', [
            'model' => $model,
        ]);
    }

    public function actionSubscribe($email, $code)
    {

        $model = Felhasznalok::findOne(['email' => $email, 'aktivacios_kod' => $code]);
        if ($model){
            $model->hirlevel = 1;
            $model->save(false);
            Yii::$app->session->addFlash('success', 'Feliratkozási kérelmed hírlevelünkre sikeres volt, köszönjük bizalmadat!');
        }else{
            Yii::$app->session->addFlash('error', 'A megadott adatokkal a hírlevélre iratkozás nem hajtható végre! Kérjük lépj be a rendszerbe, és igényeld az adataid oldalon a hírlevelünket.');
        }

        $this->goHome();
    }
}
