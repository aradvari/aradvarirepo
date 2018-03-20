<?php

namespace app\controllers;

use Yii;
use app\models\Felhasznalok;
use app\models\FelhasznalokSearch;
use app\components\web\Controller;
use yii\db\Expression;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
}
