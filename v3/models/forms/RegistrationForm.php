<?php
namespace app\models\forms;

use Yii;
use app\models\Usuario;
use webvimark\modules\UserManagement\models\User;
use webvimark\modules\UserManagement\UserManagementModule;

class RegistrationForm extends Usuario
{
	public $username;
	public $email;
	public $password;
	public $repeat_password;
	public $nombre;
	public $avatar;
	//public $captcha;

	/**
	 * @param bool $performValidation
	 *
	 * @return bool|User
	 */
	public function registerUser($performValidation = true)
	{
		if ( $performValidation AND !$this->validate() )
		{
			return false;
		}

		if ( $this->save($performValidation) )
		{
			return $this;
		}
		else
		{
			$this->addError('username', UserManagementModule::t('front', 'Login has been taken'));
		}
	}

	/**
	 * Implement your own logic if you have user profile and save some there after registration
	 *
	 * @param User $user
	 */
	protected function saveProfile($user)
	{
	}


	/**
	 * @param User $user
	 *
	 * @return bool
	 */
	protected function sendConfirmationEmail($user)
	{
		return Yii::$app->mailer->compose(Yii::$app->getModule('user-management')->mailerOptions['registrationFormViewFile'], ['user' => $user])
			->setFrom(Yii::$app->getModule('user-management')->mailerOptions['from'])
			->setTo($user->email)
			->setSubject(UserManagementModule::t('front', 'E-mail confirmation for') . ' ' . Yii::$app->name)
			->send();
	}

	/**
	 * Check received confirmation token and if user found - activate it, set username, roles and log him in
	 *
	 * @param string $token
	 *
	 * @return bool|User
	 */
	public function checkConfirmationToken($token)
	{
		$user = User::findInactiveByConfirmationToken($token);

		if ( $user )
		{
			$user->username = $user->email;
			$user->status = User::STATUS_ACTIVE;
			$user->email_confirmed = 1;
			$user->removeConfirmationToken();
			$user->save(false);

			$roles = (array)Yii::$app->getModule('user-management')->rolesAfterRegistration;

			foreach ($roles as $role)
			{
				User::assignRole($user->id, $role);
			}

			Yii::$app->user->login($user);

			return $user;
		}

		return false;
	}

	public function getDirtyAttributes($names = null)
    {

        if ($names === null) {
			return [
				"username"				=>		$this->username, 
				"auth_key"				=>		$this->auth_key, 
				"password_hash"			=>		$this->password_hash, 
				"confirmation_token"	=>		$this->confirmation_token, 
				"status"				=>		1, 
				"superadmin"			=>		$this->superadmin, 
				"created_at"			=>		$this->created_at, 
				"updated_at"			=>		$this->updated_at, 
				"registration_ip"		=>		$this->registration_ip, 
				"bind_to_ip"			=>		$this->bind_to_ip, 
				"email"					=>		$this->email, 
				"nombre"				=>		$this->nombre, 
				"avatar"				=>		$this->avatar,
			];
		}
		else {
			return parent::getDirtyAttributes($names);
		}
    }
}
