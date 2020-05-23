<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\components\SemanticGhostDropdown;
use webvimark\modules\UserManagement\components\GhostMenu;
use webvimark\modules\UserManagement\UserManagementModule;
use app\components\SemanticActiveForm;
use app\models\Pais;

$this->registerJsFile("js/settings.js", ['position' => $this::POS_END]);

?>

<div class="ui one-form container">
    <div class="ui raised green medium card">
        <div class="content">
            <div class="fluid container">
                <img class="left floated avatar" src="<?= Yii::$app->user->identity->avatar ?>">
                <div class="header">Configuración</div>
            </div>
            <div class="ui top attached tabular menu" style="padding-top: 10px">
                <a class="active item" data-tab="usuario">Cuenta</a>
                <a class="item" data-tab="persona">Datos personales</a>
                <a class="item" data-tab="contraseña">Cambiar contraseña</a>
            </div>
            <div class="ui bottom attached active tab segment" data-tab="usuario">
                <?php $form = SemanticActiveForm::begin() ?>
			    	<?= $form->field($model, 'username')->textInput(['max-length' => '50']) ?>
				    <?= $form->field($model, 'avatar')->fileInput(true, ["accept" => ".jpg,.jpeg,.png"]) ?>
                    <?= $form->field($model, 'email')->textInput(['type' => 'email']) ?>
                    <?= $form->field($model, 'nsfw')->toogle() ?>

                    <div class="ui indicating small blue progress hidden">
                        <div class="bar">
                            <div class="progress"></div>
                        </div>
                        <div class="label"></div>
                    </div>

                    <?= $form->submitButton('Guardar cambios', null, ['class' => 'ui blue fluid button']) ?>
                    <?= $form->errorBox() ?>    
                 <?php SemanticActiveForm::end() ?>
            </div>
            <div class="ui bottom attached tab segment" data-tab="persona">
                <?php $form2 = SemanticActiveForm::begin() ?>
                    <?= $form2->field($model, 'fecha_nacimiento')->textInput(['type' => 'date']) ?>
                    <?= $form2->field($model, "id_pais")->dropDownList(Pais::getList(), ['prompt'=>'--Seleccione un país--']) ?>
                    <?= $form2->field($model, 'sexo')->radioList([
                        "1" => "Masculino",
                        "0" => "Femenino",
                        "" => "Otro"
                    ]) ?>

                    <div class="ui indicating small blue progress hidden">
                        <div class="bar">
                            <div class="progress"></div>
                        </div>
                        <div class="label"></div>
                    </div>

                    <?= $form->submitButton('Guardar cambios', null, ['class' => 'ui blue fluid button']) ?>
                    <?= $form->errorBox() ?>  
                <?php SemanticActiveForm::end() ?>
            </div>
            <div class="ui bottom attached tab segment" data-tab="contraseña">
                <?php $form3 = SemanticActiveForm::begin() ?>
                <?= $form3->field($modelPassword, 'current_password')->textInput(['type' => 'password', 'autocomplete' => 'off']) ?>
                    <?= $form3->field($modelPassword, 'password')->textInput(['type' => 'password', 'autocomplete' => 'off']) ?>
                    <?= $form3->field($modelPassword, 'repeat_password')->textInput(['type' => 'password', 'autocomplete' => 'off']) ?>
                    
                    <div class="ui indicating small blue progress hidden">
                        <div class="bar">
                            <div class="progress"></div>
                        </div>
                        <div class="label"></div>
                    </div>
                    
                    <?= $form->submitButton('Guardar cambios', null, ['class' => 'ui blue fluid button']) ?>
                    <?= $form->errorBox() ?>  
                <?php SemanticActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>
                

<?php
echo SemanticGhostDropdown::widget([
    'items' => [
        ['label' => 'Change own password', 'url' => ['/user-management/auth/change-own-password']],
    ]
]);
?>