<?php

namespace app\controllers;

use app\models\Kategoriak;
use app\models\Markak;
use app\models\Vonalkodok;
use Yii;
use app\models\Termekek;
use app\models\TermekekSearch;
use app\components\web\Controller;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

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

        if ($params['brand'] && !$params['mainCategory'] && !$params['subCategory']) {
            return $this->render('brand', $fParams);
        } else {
            return $this->render('index', $fParams);
        }
    }

    public function actionView($termek)
    {
        $model = $this->findModel($termek);

        $cookies = \Yii::$app->request->cookies;
        $history = json_decode($cookies->getValue('product-history'), true);
        if (!$history || !in_array($model->id, array_values($history))) {
            $history[] = $model->id;

            $cookies = \Yii::$app->response->cookies;
            $cookies->add(new Cookie([
                'name' => 'product-history',
                'value' => json_encode($history),
            ]));
        }

        return $this->render('view', [
            'model' => $model,
            'history' => $history,
        ]);
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
