<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\web\UploadedFile;
use app\models\Comentario;
use app\models\Publicacion;
use yii\web\NotFoundHttpException;

/**
 * ComentarioController implements the CRUD actions for Comentario model.
 */
class ComentarioController extends BaseController
{
    public $freeAccessActions = ['new'];

    /**
     * Lists all Comentario models.
     * @return mixed
     */
    // public function actionIndex()
    // {
    //     $searchModel = new ComentarioSearch();
    //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    //     return $this->render('index', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    /**
     * Displays a single Comentario model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    /**
     * Creates a new Comentario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionNew()
    {
        $model = new Comentario();

        $datos = Yii::$app->request->post();

        if (Yii::$app->request->isAjax && $model->load($datos)) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $url    =   $_POST["id"];

            $model->media = null;
            $model->media_file      =   UploadedFile::getInstance($model, 'media');
            $model->id_usuario      =   Yii::$app->user->id;
            $model->id_publicacion  =   Publicacion::findOne(["url" => $url])->id;

            if ($model->validate()) {

                if($model->media_file) {
                    $ruta = $model::MEDIA_BASE_PATH . Comentario::generarMedia() .  '.' . $model->media_file->extension;
                    $model->media_file->saveAs($ruta);
                    $model->media = "/" . $ruta;
                }

                if($model->save(false))
                    return true;
            }

            Yii::$app->response->setStatusCode(400);
            return $model->getErrors();
        } 
    }

    /**
     * Updates an existing Comentario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Deletes an existing Comentario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

    /**
     * Finds the Comentario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comentario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comentario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
