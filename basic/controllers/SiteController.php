<?php

namespace app\controllers;

use Yii;
// use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
// use yii\filters\VerbFilter;
// use app\models\LoginForm;
// use app\models\ContactForm;
use yii\helpers\VarDumper;
use app\models\Comment;

class SiteController extends Controller
{
    // /**
    //  * {@inheritdoc}
    //  */
    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::class,
    //             'only' => ['logout'],
    //             'rules' => [
    //                 [
    //                     'actions' => ['logout'],
    //                     'allow' => true,
    //                     'roles' => ['@'],
    //                 ],
    //             ],
    //         ],
    //         'verbs' => [
    //             'class' => VerbFilter::class,
    //             'actions' => [
    //                 'logout' => ['post'],
    //             ],
    //         ],
    //     ];
    // }

    // /**
    //  * {@inheritdoc}
    //  */
    // public function actions()
    // {
    //     return [
    //         'error' => [
    //             'class' => 'yii\web\ErrorAction',
    //         ],
    //         'captcha' => [
    //             'class' => 'yii\captcha\CaptchaAction',
    //             'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
    //         ],
    //     ];
    // }

    // /**
    //  * Displays homepage.
    //  *
    //  * @return string
    //  */
    // public function actionIndex()
    // {
    //     return $this->render('index');
    // }

    // /**
    //  * Login action.
    //  *
    //  * @return Response|string
    //  */
    // public function actionLogin()
    // {
    //     if (!Yii::$app->user->isGuest) {
    //         return $this->goHome();
    //     }

    //     $model = new LoginForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->login()) {
    //         return $this->goBack();
    //     }

    //     $model->password = '';
    //     return $this->render('login', [
    //         'model' => $model,
    //     ]);
    // }

    // /**
    //  * Logout action.
    //  *
    //  * @return Response
    //  */
    // public function actionLogout()
    // {
    //     Yii::$app->user->logout();

    //     return $this->goHome();
    // }

    // /**
    //  * Displays contact page.
    //  *
    //  * @return Response|string
    //  */
    // public function actionContact()
    // {
    //     $model = new ContactForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
    //         Yii::$app->session->setFlash('contactFormSubmitted');

    //         return $this->refresh();
    //     }
    //     return $this->render('contact', [
    //         'model' => $model,
    //     ]);
    // }

    // /**
    //  * Displays about page.
    //  *
    //  * @return string
    //  */
    // public function actionAbout()
    // {
    //     return $this->render('about');
    // }

    public function beforeAction($action) {            
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionComment() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $text = Yii::$app->request->post('text');
        $cafe_id = Yii::$app->request->post('cafe_id');
        $model = new Comment;
        if (!Yii::$app->request->isPost || !$text || !$cafe_id || !is_numeric($cafe_id)/* !$model->load(Yii::$app->request->post()) */) {
            return [
                'code' => 400,
            ];
        }
        $model->text = $text;
        $model->cafe_id = intval($cafe_id);
        $model->save();
        return [
            'comment' => $text,
            'code' => 200,
        ];
    }

    public function actionGetComments() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $cafe_id = Yii::$app->request->post('cafe_id');
        if (!Yii::$app->request->isPost || !$cafe_id || !is_numeric($cafe_id)) {
            return [
                'code' => 400,
            ];
        }
        $comments = Comment::findAll([
            'cafe_id' => intval($cafe_id),
        ]);
        return [
            'comments' => $comments,
            'code' => 200,
        ];
    }
}
