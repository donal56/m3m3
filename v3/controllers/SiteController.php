<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use app\models\Usuario;
use yii\web\ForbiddenHttpException;
use webvimark\modules\UserManagement\models\forms\ChangeOwnPasswordForm;

class SiteController extends BaseController
{
    //public $freeAccessActions = ['index'];
    public $freeAccess = true;

    /**
     * {@inheritdoc}
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
        ];
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

    public function actionSettings()
    {
        $user           =   Usuario::getCurrentUser();
        $changePassword =   new ChangeOwnPasswordForm(['user'=> $user]);

        $this->layout= "/nosidebar";

        if ( $user->status != Usuario::STATUS_ACTIVE )
		{
			throw new ForbiddenHttpException();
		}

		if ( Yii::$app->request->isAjax AND $user->load(Yii::$app->request->post()) AND $user->changePassword() )
		{
            Yii::$app->response->format = Response::FORMAT_JSON;
			return true;
		}
        
        return $this->render('settings', [ "model" => $user, "modelPassword" => new ChangeOwnPasswordForm(['user'=> $user]) ]);
    }
}
