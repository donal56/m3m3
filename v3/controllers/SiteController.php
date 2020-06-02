<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Response;
use app\models\Usuario;
use yii\web\UploadedFile;
use app\models\Comentario;
use app\models\Publicacion;
use app\components\Utilidades;
use app\models\PuntajePublicacion;
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

    public function actionIndex()
    {
        $this->layout = "/sidebar";

        return $this->render("feed");
    }

    
    public function actionPost($action)
    {
       if( Yii::$app->request->isAjax && Yii::$app->request->isPost ) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            $url    =   $_POST["id"];
            $user   =   Yii::$app->user->identity->id;

            $model  =   PuntajePublicacion::find()
                            ->innerJoin("publicacion", "puntaje_publicacion.id_publicacion = publicacion.id")
                            ->where(["publicacion.url" => $url, "puntaje_publicacion.id_usuario" => $user])
                            ->one();

            if(!$model) {
                $model = new PuntajePublicacion();
                $id = Publicacion::findOne(["url" => $url])->id;
                $model->id_publicacion = $id;
            }
            
            $model->id_usuario = $user;
            
            switch ($action) {
                case 'like':
                    $model->puntaje = 1;
                    break;
                case 'dislike':
                    $model->puntaje = -1;
                    break;
                case 'nullify':
                    $model->puntaje = null;
            }
            
            return $model->save(false);
        }
    }

    public function actionFeed()
    {
       if( Yii::$app->request->isAjax && Yii::$app->request->isPost ) {

            $page   =   intval($_POST["page"]);
            $type   =   $_POST["type"];
            $tag    =   $_POST["tag"];

            if( $page >= 0 && !empty($type !== null) ) {
                Yii::$app->response->format = Response::FORMAT_HTML;

                $user = Yii::$app->user->identity->id;
    
                $publicaciones = array();
                $res = "";
        
                if($tag === "*")
                    $tag = "null";
                else
                    $tag = "'$tag'";

                $command = Yii::$app->db->createCommand("call feed($page, '$type', $tag, $user)");
                $rows = $command->queryAll();
        
                foreach ($rows as $row) {
                    $model      =   new Publicacion();
                    $modelCom   =   new Comentario();
        
                    $model->load($row, "", false);
        
                    $publicaciones[] = $model;
                    $res .= $this->renderPartial("post_template", ["model" => $model, "modelCom" => $modelCom]);
                }
                
                return $res;
            }
        }
    }

    public function actionUpload()
    {
        $publicacion = new Publicacion();

        $datos = Yii::$app->request->post();

        if (Yii::$app->request->isAjax && $publicacion->load($datos)) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $publicacion->media_file = UploadedFile::getInstance($publicacion, 'media');
            $publicacion->url = Publicacion::generarURL();
            $publicacion->id_usuario = Yii::$app->user->id;

            if ($publicacion->validate()) {

                $ruta = $publicacion::MEDIA_BASE_PATH . Utilidades::generateRandomString(15) .  '.' .
                    $publicacion->media_file->extension;

                $publicacion->media_file->saveAs($ruta);
                $publicacion->media = "/" . $ruta;

                if ($publicacion->save(false)) {

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
        } else {
            return $this->render('upload', ["model" => $publicacion]);
        }
    }

    public function actionSettings()
    {
        $user           =   Usuario::getCurrentUser();
        $changePassword =   new ChangeOwnPasswordForm(['user' => $user]);

        if ($user->status != Usuario::STATUS_ACTIVE) {
            throw new ForbiddenHttpException();
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $datos = Yii::$app->request->post();

            if (isset($datos["Usuario"]) && $user->load($datos)) {
                if ($user->save())
                    return true;
                else
                    return $user->getErrors();
            } else if (isset($datos["ChangeOwnPasswordForm"]) && $changePassword->load($datos)) {
                if ($changePassword->changePassword()) {
                    Yii::$app->user->logout();
                    $this->redirect(Yii::$app->homeUrl);
                    return true;
                } else
                    //return $changePassword->getErrors();
                    return $changePassword->hasErrors();
            }
        }

        return $this->render('settings', ["model" => $user, "modelPassword" => $changePassword]);
    }
}
