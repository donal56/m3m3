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
use app\models\PuntajeComentario;
use app\models\PuntajePublicacion;
use yii\web\ForbiddenHttpException;
use app\models\RelPublicacionEtiqueta;
use webvimark\modules\UserManagement\models\forms\ChangeOwnPasswordForm;

class SiteController extends BaseController
{
    public $freeAccessActions = ['index', 'feed', 'comments'];
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


    public function actionComment($action)
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            $id    =   $_POST["id"];
            $user   =   Yii::$app->user->identity->id;

            $model  =   PuntajeComentario::find()
                ->innerJoin("comentario", "puntaje_comentario.id_comentario = comentario.id")
                ->where(["comentario.id" => $id, "puntaje_comentario.id_usuario" => $user])
                ->one();

            if (!$model) {
                $model = new PuntajeComentario();
                $model->id_comentario = $id;
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

    public function actionComments($p)
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {

            Yii::$app->response->format = Response::FORMAT_HTML;

            if (!$user = Yii::$app->user->identity->id) 
                $user = "null";

            $comentarios = array();
            $res = "";

            $command = Yii::$app->db->createCommand("call comments('$p', 'nuevo', $user)");
            $rows = $command->queryAll();

            foreach ($rows as $row) {
                $model   =   new Comentario();

                $model->load($row, "", false);

                $comentarios[] = $model;

                $res .= $this->renderPartial("comment_template", ["model" => $model]);
            }

            return $res;
        } else if (!Yii::$app->request->isAjax && Yii::$app->request->isGet) {

            if (!$user = Yii::$app->user->identity->id)
                $user = "null";

            $model      =   new Publicacion();
            $modelCom   =   new Comentario();

            $command = Yii::$app->db->createCommand("call post('$p', $user)");
            $row = $command->queryOne();

            $model->load($row, "", false);

            if( Yii::$app->user->identity->nsfw || ! $model->nsfw)
                return $this->render('post', ["model" => $model, "modelCom" => $modelCom]);
            else
                $this->redirect(Yii::$app->homeUrl);
        }
    }


    public function actionPost($action)
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            $url    =   $_POST["id"];
            $user   =   Yii::$app->user->identity->id;

            $model  =   PuntajePublicacion::find()
                ->innerJoin("publicacion", "puntaje_publicacion.id_publicacion = publicacion.id")
                ->where(["publicacion.url" => $url, "puntaje_publicacion.id_usuario" => $user])
                ->one();

            if (!$model) {
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
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {

            $page   =   intval($_POST["page"]);
            $type   =   $_POST["type"];
            $tag    =   $_POST["tag"];

            if ($page >= 0 && !empty($type !== null)) {
                Yii::$app->response->format = Response::FORMAT_HTML;

                if (!$user = Yii::$app->user->identity->id) {
                    $user = "null";
                    $nsfw = "false";
                } else {
                    $nsfw = strval(Yii::$app->user->identity->nsfw);
                }

                $publicaciones = array();
                $res = "";

                if ($tag === "*")
                    $tag = "null";
                else
                    $tag = "'$tag'";

                $command = Yii::$app->db->createCommand("call feed($page, '$type', $tag, $user, $nsfw)");
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

            $user->email = "";

            if (isset($datos["Usuario"]) && $user->load($datos)) {

                $attrs = [];

                if ($user->avatar != "undefined") {
                    $user->avatar_file = UploadedFile::getInstance($user, 'avatar');

                    $imagen = $user::AVATAR_BASE_PATH . $user->username .  '.' . $user->avatar_file->extension;

                    if ($user->avatar_file) {

                        unlink($user->avatarExists());

                        $user->avatar_file->saveAs($imagen);
                        $user->avatar = "/" . $imagen;
                    }
                    
                    $attrs[] = "avatar";
                }

                if ($user->email !== "")
                    $attrs[] = "email";
                if ($user->nsfw !== "")
                    $attrs[] = "nsfw";
                if ($user->fecha_nacimiento  !== "")
                    $attrs[] = "fecha_nacimiento";
                if ($user->id_pais  !== "")
                    $attrs[] = "id_pais";
                if ($user->sexo  !== "")
                    $attrs[] = "sexo";

                if ($user->save(true, $attrs)) {
                    return true;
                } else {
                    Yii::$app->response->setStatusCode(400);
                    return $user->getErrors();
                }
            } else if (isset($datos["ChangeOwnPasswordForm"]) && $changePassword->load($datos)) {
                if ($changePassword->changePassword()) {
                    Yii::$app->user->logout();
                    $this->redirect(Yii::$app->homeUrl);
                    return true;
                } else {
                    Yii::$app->response->setStatusCode(400);
                    return $changePassword->getErrors();
                }
            }
        }

        return $this->render('settings', ["model" => $user, "modelPassword" => $changePassword]);
    }
}
