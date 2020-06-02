<?php

namespace app\controllers\auth;

use Yii;
use app\models\Usuario;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends \webvimark\modules\UserManagement\controllers\UserController
{
    public function actionUpdate($id)
	{
		$model = new Usuario(['scenario'=>'updateUser']);

		if ( $model->load(Yii::$app->request->post()) && $model->save() )
		{
			return $this->redirect(['view',	'id' => $id]);
		}

		return $this->renderIsAjax('create', compact('model'));
	}
}
