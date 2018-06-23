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
        $dataProvider->pagination->pageSize = 18;

        $brandDataProvider = $searchModel->searchBrand(Yii::$app->request->queryParams);
        $sizeDataProvider = $searchModel->searchSize(Yii::$app->request->queryParams);
        $colorDataProvider = $searchModel->searchColor(Yii::$app->request->queryParams);
        $typeDataProvider = $searchModel->searchType(Yii::$app->request->queryParams);
        $mainCategoryDataProvider = $searchModel->searchMainCategory(Yii::$app->request->queryParams);
        $subCategoryDataProvider = $searchModel->searchSubCategory(Yii::$app->request->queryParams);

        $params = [
            'mainCategory' => Yii::$app->request->get('mainCategory'),
            'subCategory' => Yii::$app->request->get('subCategory'),
            'brand' => Yii::$app->request->get('brand'),
            'meret' => Yii::$app->request->get('meret'),
            'szin' => Yii::$app->request->get('szin'),
            'tipus' => Yii::$app->request->get('tipus'),
            'q' => Yii::$app->request->get('q'),
            's' => Yii::$app->request->get('s'),
        ];
        $fParams = [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'brandDataProvider' => $brandDataProvider,
            'sizeDataProvider' => $sizeDataProvider,
            'colorDataProvider' => $colorDataProvider,
            'typeDataProvider' => $typeDataProvider,
            'mainCategoryDataProvider' => $mainCategoryDataProvider,
            'subCategoryDataProvider' => $subCategoryDataProvider,
            'params' => $params,
            'mainCategoryModel' => Kategoriak::findOne(['url_segment' => $params['mainCategory']]),
            'subCategoryModel' => Kategoriak::findOne(['url_segment' => $params['subCategory']]),
            'brandModel' => Markak::findOne(['url_segment' => $params['brand']]),
            'sizeModel' => Vonalkodok::findOne(['url_segment' => $params['meret']]),
            'colorModel' => Termekek::findOne(['szinszuro' => $params['szin']]),
            'typeModel' => Termekek::findOne(['tipus' => $params['tipus']]),
            'brandLayout' => $params['brand'] && !$params['mainCategory'] && !$params['subCategory'],
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

        return $this->render('index', $fParams);
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

            //Átlag rögzítés
            $model = TermekErtekeles::findOne(['id_termek' => Yii::$app->request->post('id')]);
            if (!$model)
                $model = new TermekErtekeles();

            $value = 'ertek' . Yii::$app->request->post('value');
            $model->id_termek = Yii::$app->request->post('id');
            $model->{$value} += 1;
            $model->save();

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
//        $vonalkod = 191163353949;

        $quantity = Vonalkodok::find()->andWhere(['vonalkod' => $vonalkod])->sum('keszlet_1');

        //kapcsolódó szinek mennyiségei
        $vonalkodModel = Vonalkodok::find()->andWhere(['vonalkod' => $vonalkod])->one();
        $productModel = Termekek::find()->joinWith(['vonalkodok'])->andWhere(['vk.vonalkod' => $vonalkod])->one();
        $connectedProducts = Termekek::find()->joinWith(['vonalkodok'])->andWhere(['termeknev' => $productModel->termeknev, 'markaid' => $productModel->markaid])->andWhere(['>', 'vk.keszlet_1', 0])->all();
//        var_dump($vonalkodModel);
        $quantitys = [];
        foreach ($connectedProducts as $product) {
            foreach ($product->vonalkodok as $vonalkod) {
                if ($vonalkod->url_segment == $vonalkodModel->url_segment)
                    $quantitys[$product->url_segment] = $vonalkod->keszlet_1;

            }
        }

        return [
            'quantity' => (int)$quantity,
            'selectedSize' => $vonalkodModel->url_segment,
            'products' => $quantitys,
        ];
    }

    public function actionRedirect($categoryId = null, $brandId = null, $meretek = null, $keresendo = null, $productId = null)
    {

        if ($productId) {

            $productModel = Termekek::findOne($productId);

            $url = Url::to(['termekek/view',
                'mainCategory' => $productModel->defaultMainCategory->url_segment,
                'subCategory' => $productModel->defaultSubCategory->url_segment,
                'brand' => $productModel->marka->url_segment,
                'termek' => $productModel->url_segment,
            ]);

        } elseif ($categoryId || $brandId || $meretek || $keresendo) {

            $categoryModelMain = null;
            $categoryModel = Kategoriak::findOne($categoryId);
            if ($categoryModel->szulo)
                $categoryModelMain = Kategoriak::findOne($categoryModel->szulo);
            $brandModel = Markak::findOne($brandId);
            $meretModel = Vonalkodok::find()->andWhere(['megnevezes' => $meretek])->andWhere(['!=', 'megnevezes', 'null'])->one();

            $url = Url::to([
                'termekek/index',
                'mainCategory' => $categoryModelMain ? $categoryModelMain->url_segment : $categoryModel->url_segment,
                'subCategory' => $categoryModel->url_segment,
                'brand' => $brandModel->url_segment,
                'meret' => $meretModel->url_segment,
                'q' => $keresendo,
            ]);

        }

        return $this->redirect($url, 301);

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
