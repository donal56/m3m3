<?php

namespace app\controllers\auth;

use webvimark\modules\UserManagement\components\UserAuthEvent;
use webvimark\modules\UserManagement\models\User;
use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

class AuthController extends \webvimark\modules\UserManagement\controllers\AuthController
{
	/**
	 * Registration logic
	 *
	 * @return string
	 */
	public function actionRegistration()
	{
		if ( !Yii::$app->user->isGuest )
		{
			return $this->goHome();
		}

		$model = new $this->module->registrationFormClass(['scenario'=>'registration']);

		if ( Yii::$app->request->isAjax AND $model->load(Yii::$app->request->post()) )
		{

			Yii::$app->response->format = Response::FORMAT_JSON;

			// Ajax validation breaks captcha. See https://github.com/yiisoft/yii2/issues/6115
			// Thanks to TomskDiver
			$validateAttributes = $model->attributes;
			unset($validateAttributes['captcha']);

			return ActiveForm::validate($model, $validateAttributes);
		}

		if ( $model->load(Yii::$app->request->post()) )
		{

			$model->avatar_file = UploadedFile::getInstance($model, 'avatar');

			if( $model->validate() ) {

				$imagen= $model::AVATAR_BASE_PATH . $model->username .  '.' . $model->avatar_file->extension;

				if($model->avatar_file) {

					if($previousAvatar = $model->avatarExists())
						unlink($previousAvatar);

					$model->avatar_file->saveAs($imagen);
					$model->avatar = "/" . $imagen;

				}
					
				// Trigger event "before registration" and checks if it's valid
				if ( $this->triggerModuleEvent(UserAuthEvent::BEFORE_REGISTRATION, ['model'=>$model]) )
				{
					$user = $model->registerUser(false);

					// Trigger event "after registration" and checks if it's valid
					if ( $this->triggerModuleEvent(UserAuthEvent::AFTER_REGISTRATION, ['model'=>$model, 'user'=>$user]) )
					{
						if ( $user )
						{
							if ( Yii::$app->getModule('user-management')->useEmailAsLogin AND Yii::$app->getModule('user-management')->emailConfirmationRequired )
							{
								return $this->renderIsAjax('registrationWaitForEmailConfirmation', compact('user'));
							}
							else
							{
								$roles = (array)$this->module->rolesAfterRegistration;

								foreach ($roles as $role)
								{
									User::assignRole($user->id, $role);
								}

								Yii::$app->user->login($user);

								return $this->redirect(Yii::$app->user->returnUrl);
							}

						}
					}
				}
			}
		}

		$this->layout = '/noSidebar';

		return $this->renderIsAjax('registration', compact('model'));
	}
}
