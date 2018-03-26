<?php

namespace app\controllers;

use app\models\Kategoriak;
use app\models\KeresendoLog;
use app\models\Markak;
use app\models\TermekErtekeles;
use app\models\TermekErtekelesFelhasznalo;
use app\models\Vonalkodok;
use Yii;
use app\models\Termekek;
use app\models\TermekekSearch;
use app\components\web\Controller;
use yii\base\Event;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ListView;

/**
 * TermekekController implements the CRUD actions for Termekek model.
 */
class TermekekController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'ajaxGetSizes' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Termekek models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TermekekSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $brandDataProvider = $searchModel->searchBrand(Yii::$app->request->queryParams);
        $sizeDataProvider = $searchModel->searchSize(Yii::$app->request->queryParams);
        $colorDataProvider = $searchModel->searchColor(Yii::$app->request->queryParams);
        $mainCategoryDataProvider = $searchModel->searchMainCategory(Yii::$app->request->queryParams);
        $subCategoryDataProvider = $searchModel->searchSubCategory(Yii::$app->request->queryParams);

        $params = [
            'mainCategory' => Yii::$app->request->get('mainCategory'),
            'subCategory' => Yii::$app->request->get('subCategory'),
            'brand' => Yii::$app->request->get('brand'),
            'meret' => Yii::$app->request->get('meret'),
            'szin' => Yii::$app->request->get('szin'),
            'q' => Yii::$app->request->get('q'),
            's' => Yii::$app->request->get('s'),
        ];

        $fParams = [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'brandDataProvider' => $brandDataProvider,
            'sizeDataProvider' => $sizeDataProvider,
            'colorDataProvider' => $colorDataProvider,
            'mainCategoryDataProvider' => $mainCategoryDataProvider,
            'subCategoryDataProvider' => $subCategoryDataProvider,
            'params' => $params,
            'mainCategoryModel' => Kategoriak::findOne(['url_segment' => $params['mainCategory']]),
            'subCategoryModel' => Kategoriak::findOne(['url_segment' => $params['subCategory']]),
            'brandModel' => Markak::findOne(['url_segment' => $params['brand']]),
            'sizeModel' => Vonalkodok::findOne(['url_segment' => $params['meret']]),
            'colorModel' => Termekek::findOne(['szinszuro' => $params['szin']]),
        ];

        if (!Yii::$app->request->isAjax && Yii::$app->request->get('q'))
            Event::on(ListView::className(), ListView::EVENT_AFTER_RUN, function ($event) {
                if ($event->sender->id == 'product-list') {
                    $logModel = new KeresendoLog();
                    $logModel->keresoszo = Yii::$app->request->get('q');
                    $logModel->talalat = (int)ArrayHelper::getValue($event, 'sender.dataProvider.totalCount');
                    $logModel->ip = Yii::$app->request->getUserIP();
                    $logModel->browser = Yii::$app->request->getUserAgent();
                    $logModel->save(false);
                }
            });

        if ($params['brand'] && !$params['mainCategory'] && !$params['subCategory']) {
            return $this->render('brand', $fParams);
        } else {
            return $this->render('index', $fParams);
        }
    }

    public function actionView($termek)
    {
        $model = $this->findModel($termek);

//        $cookies = \Yii::$app->request->cookies;
//
//        $history = json_decode($cookies->getValue('product-history'), true);
//        if (!$history || !in_array($model->id, array_values($history))) {
//            $history[] = $model->id;
//
//            $cookies = \Yii::$app->response->cookies;
//            $cookies->add(new Cookie([
//                'name' => 'product-history',
//                'value' => json_encode($history),
//            ]));
//        }

        return $this->render('view', [
            'model' => $model,
//            'history' => $history,
        ]);
    }

    public function actionAjaxRate()
    {
        $error = null;
        $model = null;

        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!Yii::$app->user->isGuest) {

            //Korábbi szavazás ellenőrzése
            $lastRate = TermekErtekelesFelhasznalo::findOne(['id_termek' => Yii::$app->request->post('id'), 'id_felhasznalo' => Yii::$app->user->id]);

            if (!$lastRate) {

                //Átlag rögzítés
                $model = TermekErtekeles::findOne(['id_termek' => Yii::$app->request->post('id')]);
                if (!$model)
                    $model = new TermekErtekeles();

                $value = 'ertek' . Yii::$app->request->post('value');
                $model->id_termek = Yii::$app->request->post('id');
                $model->{$value} += 1;
                $model->save();

                //Személy rögzítés
                $logModel = TermekErtekelesFelhasznalo::findOne(['id_termek' => Yii::$app->request->post('id'), 'id_felhasznalo' => Yii::$app->user->id]);
                if (!$logModel)
                    $logModel = new TermekErtekelesFelhasznalo();

                $logModel->id_termek = Yii::$app->request->post('id');
                $logModel->id_felhasznalo = Yii::$app->user->id;
                $logModel->ertek = Yii::$app->request->post('value');
                $logModel->datum = new Expression('now()');
                $logModel->save();

            } else {
                $error = 'Sajnáljuk de korábban már értékelted a terméket!';
            }

        } else {
            $error = 'Sajnáljuk, de értékelni csak regisztrált és bejelentkezett felhasználóval tudsz!';
        }

        return [
            'error' => $error,
            'value' => ArrayHelper::getValue($model, 'termek.ertekelesAVG'),
        ];

    }

    public function actionAjaxGetQuantity()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $vonalkod = Yii::$app->request->post('vonalkod');

        $quantity = Vonalkodok::find()->andWhere(['vonalkod' => $vonalkod])->sum('keszlet_1');

        return [
            'quantity' => (int)$quantity,
        ];
    }

    /**
     * Finds the Termekek model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $urlSegment
     * @return Termekek the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($urlSegment)
    {
        if (($model = Termekek::findByUrlSegment($urlSegment)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
