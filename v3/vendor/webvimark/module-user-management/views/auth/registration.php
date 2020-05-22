<?php

	use webvimark\modules\UserManagement\UserManagementModule;
	use app\components\SemanticActiveForm;
	use app\assets\AppAsset;
	use yii\captcha\Captcha;

	/**
	 * @var yii\web\View $this
	 * @var app\models\forms\RegistrationForm $model
	 */

	AppAsset::register($this);

	$this->registerCssFile("/css/login.css", ['depends' => 'app\assets\AppAsset']);

	$this->title = UserManagementModule::t('front', 'Registration');
	$this->params['breadcrumbs'][] = $this->title;
?>


<div class="ui raised violet small card">
	<div class="content" style= "padding: 1em 1em 0">
		<div class="center aligned header"><?= $this->title ?></div>
		<div class="description">
			<?php $form = SemanticActiveForm::begin() ?>
				
				<?= $form->field($model, 'email')->textInput(['type' => 'email']) ?>
				<?= $form->field($model, 'username')->textInput(['maxlength' => 50]) ?>
				<?= $form->field($model, 'password')->passwordInput(['autocomplete' => 'off']) ?>
				<?= $form->field($model, 'repeat_password')->passwordInput(['autocomplete' => 'off']) ?>
				<?php $form->field($model, 'captcha')->widget(Captcha::className(), [
					'template' => '<div class="two fields">
										<div class="center aligned field">{image}</div>
										<div class="field">{input}</div></div>',
					'captchaAction'=>['/user-management/auth/captcha']
				]) ?>
					
				<?= $form->submitButton(UserManagementModule::t('front', 'Register'), 'arrow alternate circle right', 
					['class' => 'ui violet fluid button']) ?>
				<?= $form->errorBox() ?>
				
			<?php SemanticActiveForm::end() ?>
		</div>
	</div>
</div>
