<?php
	/**
	 * @var $this yii\web\View
	 * @var $model webvimark\modules\UserManagement\models\forms\LoginForm
	 */

	use app\assets\AppAsset;
	use app\components\SemanticActiveForm;
	use yii\helpers\Url;

	AppAsset::register($this);

	$this->registerCssFile("/css/login.css", ['depends' => 'app\assets\AppAsset']);
?>

<div class="ui raised blue small card">
	<div class="content" style= "padding: 1em 1em 0">
		<div class="center aligned header">Iniciar sesión</div>
		<div class="description">
			<?php $form = SemanticActiveForm::begin() ?>
				
				<?= $form->field($model, 'email')->textInput(['type' => 'email']) ?>
				<?= $form->field($model, 'password')->passwordInput() ?>

				<?php 
					if( isset(Yii::$app->user->enableAutoLogin) && Yii::$app->user->enableAutoLogin )
						echo $form->field($model, 'rememberMe')->checkbox();
				?>
					
				<?= $form->submitButton('Iniciar sesión', ['class' => 'ui blue fluid button']) ?>
				<?= $form->errorBox() ?>

			<?php SemanticActiveForm::end() ?>
		</div>
	</div>
	<div class="extra content" style= "padding-top: 0">
		<div class="ui social container">
			<div class="ui horizontal divider">
				O inicie vinculado con:
			</div>
			<div class="container">
				<button class="ui left floated facebook button"
					onclick="window.open('https://facebook.com')">
					<i class="facebook icon"></i>
					Facebook
				</button>
				<button class="ui right floated twitter button"
					onclick="window.open('https://twitter.com')">
					<i class="twitter icon"></i>
					Twitter
				</button>
			</div>
		</div>
		<div class="ui container">
			<div class="ui horizontal divider" style= "padding-top: 10px">
				¿No tienes cuenta ni redes sociales?
			</div>
			<div class="container">
				<button class="ui fluid button" onclick= "window.location= '<?= Url::to('/user-management/auth/registration') ?>'">
					Crear cuenta
				</button>
			</div>
		</div>
	</div>
