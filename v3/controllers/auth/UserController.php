<?php

namespace app\controllers\auth;

use app\models\Usuario;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends \webvimark\modules\UserManagement\controllers\UserController
{
    public function actionUpdate()
	{
		$model = new Usuario(['scenario'=>'updateUser']);

		if ( $model->load(Yii::$app->request->post()) && $model->save() )
		{
			return $this->redirect(['view',	'id' => $model->id]);
		}

		return $this->renderIsAjax('create', compact('model'));
	}
}
