<?php

namespace app\controllers;

use app\components\helpers\Coreshop;
use app\models\FelhasznaloElfJelszo;
use app\models\Felhasznalok;
use app\models\LostPwForm;
use Yii;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'oAuthSuccess'],
                'cancelUrl' => ['/'],
            ],
        ];
    }

    /**
     * This function will be triggered when user is successfuly authenticated using some oAuth client.
     *
     * @param yii\authclient\ClientInterface $client
     * @return boolean|yii\web\Response
     */
    public function oAuthSuccess($client)
    {
        // get user data from client
        $userAttributes = $client->getUserAttributes();
        $user = Felhasznalok::getUser($userAttributes['email'], $client->getId());

        if (!$user) {

            $user = new Felhasznalok();
            $user->scenario = Felhasznalok::SCENARIO_FACEBOOK_REGISTER;

            switch ($client->getId()) {

                case 'facebook':
                    $user->email = $userAttributes['email'];
                    $user->vezeteknev = $userAttributes['last_name'];
                    $user->keresztnev = $userAttributes['first_name'];
                    break;

                case 'google':
                    $user->email = $userAttributes['emails'][0]['value'];
                    $user->vezeteknev = $userAttributes['name']['familyName'];
                    $user->keresztnev = $userAttributes['name']['givenName'];
                    break;

            }
            $user->auth_type = $client->getId();
            if ($user->save(false)) {
                //MAIL
                Yii::$app->mailer->compose('/mail/social-registration.php', ['model' => $user])
                    ->setTo($user->email)
                    ->setSubject('Sikeres regisztráció')
                    ->send();
            } else {
                Yii::$app->session->setFlash('error', 'A bejelentkezés alatt hiba történt, kérjük próbáld meg újra a folyamatot.');
                return $this->goHome();
            }

        }

        Yii::$app->user->login($user);

        if (Yii::$app->cart->items)
            return $this->redirect('/order/create');
        else
            return $this->goHome();
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionContent($page)
    {
        return $this->render($page);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $felhasznaloModel = new Felhasznalok();
        $felhasznaloModel->scenario = Felhasznalok::SCENARIO_FACEBOOK_REGISTER;
        if ($felhasznaloModel->load(Yii::$app->request->post())) {

            $password = Coreshop::randomPassword();
            $felhasznaloModel->jelszo = $password;
//            $felhasznaloModel->create_user = true;

            if ($felhasznaloModel->save()) {

                //MAIL
                Yii::$app->mailer->compose('/mail/registration.php', ['model' => $felhasznaloModel, 'password' => $password])
                    ->setTo($felhasznaloModel->email)
                    ->setSubject('Sikeres regisztráció')
                    ->send();

                Yii::$app->user->login($felhasznaloModel);
                $this->goHome();

            }

        }

        return $this->render('login', [
            'model' => $model,
            'felhasznaloModel' => $felhasznaloModel,
        ]);
    }

    public function actionLostPassword($code = '')
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if ($code) {

            $jelszoModel = FelhasznaloElfJelszo::findOne(['aktiv_kod' => $code]);

            if ($jelszoModel) {

                $felhasznaloModel = Felhasznalok::findOne(['id' => $jelszoModel->id_felhasznalo]);
                $felhasznaloModel->jelszo = $jelszoModel->uj_jelszo;

                $jelszoModel->sztorno = new Expression('NOW()');
                $jelszoModel->save(false);

                Yii::$app->session->addFlash('success', 'A jelszó aktiválás sikeres volt. A rendszer automatikusan bejelentkeztette.');
                Yii::$app->user->login($felhasznaloModel);
                return $this->goHome();

            } else {
                Yii::$app->session->addFlash('danger', 'A jelszó aktiválás sikertelen volt.');
                return $this->redirect('/site/lost-password');
            }

        }

        $model = new LostPwForm();

        if ($model->load(Yii::$app->request->post())) {

            $felhasznaloModel = Felhasznalok::findOne(['email' => $model->username, 'auth_type' => 'normal']);

            if ($felhasznaloModel) {

                $felhasznaloModel->scenario = Felhasznalok::SCENARIO_LOST_PW;

                $password = Coreshop::randomPassword();

                $jelszoModel = new FelhasznaloElfJelszo();
                $jelszoModel->id_felhasznalo = $felhasznaloModel->getPrimaryKey();
                $jelszoModel->aktiv_kod = Yii::$app->getSecurity()->generateRandomString();
                $jelszoModel->uj_jelszo = md5($password);
                if ($jelszoModel->save()) {

                    //MAIL
                    Yii::$app->mailer->compose('/mail/lost_pw.php', ['model' => $felhasznaloModel, 'jelszoModel' => $jelszoModel, 'password' => $password])
                        ->setTo($felhasznaloModel->email)
                        ->setSubject('Elfelejtett jelszó')
                        ->send();

                }
            }

            Yii::$app->session->addFlash('success', 'Amennyiben regisztrált tagunk vagy a jelszó módosításról e-mailt küldtünk a megadott címre!');
            return $this->refresh();

        }

        return $this->render('lost_password', [
            'model' => $model,
            'felhasznaloModel' => $felhasznaloModel,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

}
