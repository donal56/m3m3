<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use app\models\Usuario;
use yii\web\UploadedFile;
use app\models\Publicacion;
use app\components\Utilidades;
use yii\web\ForbiddenHttpException;
use app\models\RelPublicacionEtiqueta;
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

        $datos = Yii::$app->request->post();

        if (Yii::$app->request->isAjax && $publicacion->load($datos))
		{
            Yii::$app->response->format = Response::FORMAT_JSON;
            
            $publicacion->media_file = UploadedFile::getInstance($publicacion, 'media');
            $publicacion->url = Publicacion::generarURL();
            $publicacion->id_usuario = Yii::$app->user->id;
            
            if( $publicacion->validate() ) {
                
                $ruta= $publicacion::MEDIA_BASE_PATH . Utilidades::generateRandomString(15) .  '.' .          
                $publicacion->media_file->extension;
                
                $publicacion->media_file->saveAs($ruta);
                $publicacion->media = "/" . $ruta;
                
                if($publicacion->save(false)) {
                    
                    $etiquetas = explode(",", $datos["Publicacion"]["relPublicacionEtiquetas"]);
                    
                    foreach ($etiquetas as $etiqueta) {
                        $tag = new RelPublicacionEtiqueta();
                        $tag->id_publicacion = $publicacion->id;
                        $tag->id_etiqueta = $etiqueta;
                        
                        $tag->save();
                    }
                    return $publicacion;
                }
            }
            
            Yii::$app->response->setStatusCode(400);
            return $publicacion->getErrors();
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
