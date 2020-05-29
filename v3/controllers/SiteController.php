<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use app\models\Usuario;
use app\models\Publicacion;
use yii\web\ForbiddenHttpException;
use webvimark\modules\UserManagement\models\User;
use webvimark\modules\UserManagement\models\forms\ChangeOwnPasswordForm;

class SiteController extends BaseController
{
    public $freeAccessActions = ['index'];
    //public $freeAccess = true;

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

    public function actionUpload()
    {
        $publicacion = new Publicacion();
        
        if ( Yii::$app->request->isAjax && $publicacion->load(Yii::$app->request->post()))
		{

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $publicacion;
        }
        else
        {
            $this->layout= "/nosidebar";
            return $this->render('upload', [ "model" => $publicacion]);
        }
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

		if ( Yii::$app->request->isAjax)
		{
            Yii::$app->response->format = Response::FORMAT_JSON;
            
            $datos = Yii::$app->request->post();
            
            if(isset($datos["Usuario"]) && $user->load($datos)) {
                if($user->save())
                    return true;
                else
                    return $user->getErrors();

            } else if(isset($datos["ChangeOwnPasswordForm"]) && $changePassword->load($datos)) {
                if($changePassword->changePassword()) {
                    Yii::$app->user->logout();
                    $this->redirect(Yii::$app->homeUrl);
                    return true;
                }
                else
                    //return $changePassword->getErrors();
                    return $changePassword->hasErrors();
            }

		}
        
        return $this->render('settings', [ "model" => $user, "modelPassword" => $changePassword ]);
    }
}
